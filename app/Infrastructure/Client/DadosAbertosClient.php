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

    public function __construct(private readonly HttpFactory $httpClient)
    {
        $this->baseUrl = rtrim(config('services.dados_abertos.api_url'), '/');
    }

    /**
     * Busca eventos na API da Câmara sem filtros adicionais.
     *
     * @param  int  $limit  Quantidade de registros desejada.
     * @return array
     */
    public function getEvents(int $limit = 100): array
    {
        $limit = max(1, $limit);

        $params = [
            'ordem'      => 'ASC',
            'ordenarPor' => 'dataHoraInicio',
            'itens'      => $limit,
        ];

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
     * Retorna eventos que possuam proposições do tipo PL na pauta.
     *
     * Cada item do array de retorno tem:
     *  - 'evento'       => dados do evento
     *  - 'proposicoes'  => lista de proposições do tipo PL
     *
     * @param  int $limit  Número de eventos a buscar inicialmente.
     * @return array
     */
    public function getPlEvents(int $limit = 100): array
    {
        $eventos = $this->getEvents(limit: $limit);

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
