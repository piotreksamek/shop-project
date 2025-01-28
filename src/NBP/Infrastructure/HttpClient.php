<?php

declare(strict_types=1);

namespace App\NBP\Infrastructure;

use App\NBP\Infrastructure\Exception\ClientException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClient
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        #[Autowire('%env(NBP_API_URL)%')]
        private readonly string $url,
    ) {
    }

    public function sendRequest(string $method, string $prefix): string
    {
        try {
            $response = $this->httpClient->request($method, sprintf('%s%s', $this->url, $prefix));
        } catch (\Exception $exception) {
            throw new ClientException($exception->getMessage());
        }

        return $response->getContent();
    }
}
