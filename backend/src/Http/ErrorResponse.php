<?php

namespace Alexander\CityBike\Http;

use Alexander\CityBike\Http\Response;

class ErrorResponse extends Response
{
    protected const SUCCESS = false;

    public function __construct(
        private string $reason = 'Something went wrong',
        private int $statusCode = 400
    ) {
    }

    public function status(): int
    {
        return $this->statusCode;
    }

    public function payload(): array
    {
        return ['reason' => $this->reason];
    }
}
