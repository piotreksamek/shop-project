<?php

declare(strict_types=1);

namespace App\Tests\Unit\NBP\Infrastructure\NBP;

use App\Infrastructure\NBP\Client;
use App\Infrastructure\NBP\DTO\CurrencyDTO;
use App\Infrastructure\NBP\DTO\RatesDTO;
use App\Infrastructure\NBP\HttpClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ClientTest extends TestCase
{
    public function atestGetCurrencies(): void
    {
        $httpClientMock = $this->createMock(HttpClient::class);
        $serializerMock = $this->createMock(SerializerInterface::class);
        $client = new Client($httpClientMock, $serializerMock);

        $apiResponse = '[{"table": "A", "currency": "USD", "code": "USD", "rates": [{"no": "001/A/NBP/2024", "effectiveDate": "2024-12-12", "mid": 4.5}]}]';
        $trimmedResponse = '"table": "A", "currency": "USD", "code": "USD", "rates": [{"no": "001/A/NBP/2024", "effectiveDate": "2024-12-12", "mid": 4.5}]}';

        $rates = [
            new RatesDTO(
                currency: "USD",
                code: "USD",
                mid: 4.5,
            ),
        ];

        $currencyDTO = new CurrencyDTO(
            table: "A",
            no: "001/A/NBP/2024",
            rates: $rates,
        );

        $httpClientMock->expects($this->once())
            ->method('sendRequest')
            ->with(Request::METHOD_GET, 'exchangerates/tables/A')
            ->willReturn($apiResponse);

        $serializerMock->expects($this->once())
            ->method('deserialize')
            ->with($trimmedResponse, CurrencyDTO::class, 'json')
            ->willReturn($currencyDTO);

        $result = $client->getCurrencies();
        $this->assertInstanceOf(CurrencyDTO::class, $result);
        $this->assertSame($currencyDTO, $result);
    }
}
