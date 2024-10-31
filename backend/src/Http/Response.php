<?php

namespace Alexander\CityBike\Http;

abstract class Response
{
    protected const SUCCESS = true;

    // Method for sending the response
    public function send(): void
    {
        // Prepare the response data by combining the success status and payload
        $data = ['success' => static::SUCCESS] + $this->payload();

        // Set the response headers
        header('Content-Type: application/json');
        http_response_code($this->status());

        // Encode the data as JSON
        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    // Abstract method for retrieving the response payload
    abstract public function payload(): array;

    // Abstract method for retrieving the response status code
    abstract public function status(): int;
}
