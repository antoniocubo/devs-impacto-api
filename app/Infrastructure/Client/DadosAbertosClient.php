<?php

namespace App\Infrastructure\Client;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DadosAbertosClient
{
    private string $baseUrl;

    private const TIPOS_EVENTO_DELIBERATIVOS = [
        '110', // Sessão Deliberativa
        '112', // Reunião Deliberativa
        '125', // Audiência Pública e Deliberação
        '204', // Sessão Deliberativa
        '210', // Tomada de Depoimento e Deliberação
        '212', // Tom. Depoimento, Aud. Pública e Delib.
    ];

    public function __construct(private readonly HttpFactory $httpClient)
    {
        $this->baseUrl = rtrim(config('services.dados_abertos.api_url'), '/');
    }

    /**
     * Busca eventos na API da Câmara.
     *
     * @param  string|null  $dataInicio  (AAAA-MM-DD)
     * @param  string|null  $dataFim     (AAAA-MM-DD)
     * @param  array<string>|null $tiposEvento  Códigos dos tipos de evento (codTipoEvento)
     *
     * @return array
     */
    public function getEvents(
        ?string $dataInicio = null,
        ?string $dataFim = null,
        ?array $tiposEvento = null
    ): array {
        $params = [
            'ordem'      => 'ASC',
            'ordenarPor' => 'dataHoraInicio',
        ];

        if ($dataInicio) {
            $params['dataInicio'] = $dataInicio;
        }

        if ($dataFim) {
            $params['dataFim'] = $dataFim;
        }

        if (!empty($tiposEvento)) {
            $params['codTipoEvento'] = implode(',', $tiposEvento);
        }

        $response = $this->makeRequest('GET', '/eventos', $params);

        return $response['dados'] ?? [];
    }

    /**
     * Pauta (lista de proposições) de um evento.
     *
     * @param  int|string  $idEvento
     * @return array
     */
    public function getEventAgenda(int|string $idEvento): array
    {
        $response = $this->makeRequest('GET', "/eventos/{$idEvento}/pauta", []);

        return $response['dados'] ?? [];
    }

    /**
     * Retorna apenas eventos deliberativos que tenham PLs na pauta.
     *
     * Cada item do array de retorno tem:
     *  - 'evento'       => dados do evento
     *  - 'proposicoes'  => lista de proposições do tipo PL
     *
     * @param  string|null $dataInicio
     * @param  string|null $dataFim
     * @return array
     */
    public function getPlEvents(?string $dataInicio = null, ?string $dataFim = null): array
    {
        $eventos = $this->getEvents(
            dataInicio: $dataInicio,
            dataFim: $dataFim,
            tiposEvento: self::TIPOS_EVENTO_DELIBERATIVOS
        );

        $result = [];

        foreach ($eventos as $evento) {
            if (empty($evento['id'])) {
                continue;
            }

            $pauta = $this->getEventAgenda($evento['id']);

            $pls = array_filter($pauta, static function (array $item) {
                return isset($item['siglaTipo']) && $item['siglaTipo'] === 'PL';
            });

            if (empty($pls)) {
                continue;
            }

            $result[] = [
                'evento'      => $evento,
                'proposicoes' => array_values($pls),
            ];
        }

        return $result;
    }

    private function makeRequest(string $method, string $endpoint, ?array $parameters): array
    {
        try {
            $client = $this->httpClient
                ->baseUrl($this->baseUrl)
                ->timeout(30)
                ->withHeaders($this->getDefaultHeaders());

            $response = match (strtoupper($method)) {
                'GET'    => $client->get($endpoint, $parameters ?? []),
                'POST'   => $client->post($endpoint, $parameters ?? []),
                'DELETE' => $client->delete($endpoint),
                default  => throw new \InvalidArgumentException("Método HTTP não suportado: {$method}"),
            };

            $response->throw();

            return $response->json();

        } catch (RequestException $e) {
            \Log::error("Erro na API de Dados Abertos da Câmara", [
                'status' => $e->response?->status(),
                'body'   => $e->response?->body(),
                'error'  => $e->getMessage(),
            ]);

            throw new HttpException(
                $e->response?->status() ?? Response::HTTP_BAD_GATEWAY,
                "Erro na resposta da Dados Abertos."
            );
        } catch (ConnectionException $e) {
            throw new HttpException(
                Response::HTTP_GATEWAY_TIMEOUT,
                "Erro de conexão com a Dados Abertos."
            );
        }
    }

    private function getDefaultHeaders(): array
    {
        return [
            'Accept'       => 'application/json',
        ];
    }
}
