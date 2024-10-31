<?php

namespace Alexander\CityBike\Http;

use JsonException;
use Alexander\CityBike\Exceptions\HttpException;

class Request
{
    public function __construct(
        private array $get,
        private array $server,
        private string $body,
    ) {
    }

    // Get the request method (e.g., GET, POST)
    public function method(): string
    {
        if (!array_key_exists('REQUEST_METHOD', $this->server)) {
            throw new HttpException('Cannot get method from the request');
        }

        return $this->server['REQUEST_METHOD'];
    }


    // Method for parsing the JSON body of the request
    public function jsonBody(): array
    {
        try {
            $data = json_decode(
                $this->body,
                associative: true,
                flags: JSON_THROW_ON_ERROR
            );
        } catch (JsonException) {
            throw new HttpException('Cannot decode json body');
        }

        if (!is_array($data)) {
            throw new HttpException('Not an array/object in json body');
        }

        return $data;
    }

    // Get a specific field from the JSON body
    public function jsonBodyField(string $field): mixed
    {
        $data = $this->jsonBody();

        if (!array_key_exists($field, $data)) {
            throw new HttpException("No such field: $field");
        }
        if (empty($data[$field])) {
            throw new HttpException("Empty field: $field");
        }


        return $data[$field];
    }

    // Get the request path
    public function path(): string
    {
        if (!array_key_exists('REQUEST_URI', $this->server)) {
            throw new HttpException('Cannot get path from the request');
        }

        $components = parse_url($this->server['REQUEST_URI']);

        if (!is_array($components) || !array_key_exists('path', $components)) {
            throw new HttpException('Cannot get path from the request');
        }

        return $components['path'];
    }

    // Get the value of a specific query string parameter
    public function query(string $param): string
    {
        if (!array_key_exists($param, $this->get)) {
            throw new HttpException("No such query param in the request: $param");
        }

        $value = trim($this->get[$param]);

        return $value;
    }

    // Get the value of a specific header
    public function header(string $header): string
    {
        $headerName = mb_strtoupper('http_' . str_replace('-', '_', $header));

        if (!array_key_exists($headerName, $this->server)) {
            throw new HttpException("No such header in the request: $header");
        }

        $value = trim($this->server[$headerName]);

        if (empty($value)) {
            throw new HttpException("Empty header in the request: $header");
        }

        return $value;
    }
}
