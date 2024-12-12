<?php

declare(strict_types=1);

namespace App\Infrastructure\NBP;

use App\Infrastructure\NBP\DTO\CurrencyDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class Client
{
    public function __construct(
        private readonly HttpClient $httpClient,
        private readonly SerializerInterface $serializer,
    ) {
    }

    public function getCurrencies(): CurrencyDTO
    {
        $response = $this->httpClient->sendRequest(Request::METHOD_GET, 'exchangerates/tables/A');

        $response = substr($response, 1, -1);

        return $this->serializer->deserialize($response, CurrencyDTO::class, 'json');
    }
}
