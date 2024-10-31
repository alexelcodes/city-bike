<?php

namespace Alexander\CityBike\Http;

use Alexander\CityBike\Http\Response;

class SuccessfulResponse extends Response
{
    protected const SUCCESS = true;

    public function __construct(
        private array $data = [],
        private int $statusCode = 200
    ) {
    }

    public function payload(): array
    {
        return ['data' => $this->data];
    }

    public function status(): int
    {
        return $this->statusCode;
    }
}
