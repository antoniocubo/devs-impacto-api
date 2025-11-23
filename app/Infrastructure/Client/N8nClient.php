<?php

namespace App\Infrastructure\Client;

use GuzzleHttp\Client;

class N8nClient
{
    public function __construct(
        protected Client $client,
    ) {
        $this->client = new Client([
            'headers' => [
                config('n8n.auth_header_name') => config('n8n.api_key')
            ]
        ]);
    }

    public function post(string $url, array $data): array
    {
        $response = $this->client->post($url, [
            'json' => $data
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
