<?php

namespace Alexander\CityBike\Entities;

class Station
{
    private int $id;

    public function __construct(
        private string $name_fi = '',
        private string $name_sv = '',
        private string $name_en = '',
        private string $address_fi = '',
        private string $address_sv = '',
        private string $city_fi = '',
        private string $city_sv = '',
        private string $operator = '',
        private int $capacity = 0,
        private float $coordinate_x = 0.0,
        private float $coordinate_y = 0.0,
    ) {
        $this->name_fi = ucfirst(trim($name_fi));
        $this->name_sv = ucfirst(trim($name_sv));
        $this->name_en = ucfirst(trim($name_en));
        $this->address_fi = ucfirst(trim($address_fi));
        $this->address_sv = ucfirst(trim($address_sv));
        $this->city_fi = ucfirst(trim($city_fi));
        $this->city_sv = ucfirst(trim($city_sv));
        $this->operator = ucfirst(trim($operator));
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNameFi(): string
    {
        return $this->name_fi;
    }

    public function getNameSv(): string
    {
        return $this->name_sv;
    }

    public function getNameEn(): string
    {
        return $this->name_en;
    }

    public function getAddressFi(): string
    {
        return $this->address_fi;
    }

    public function getAddressSv(): string
    {
        return $this->address_sv;
    }

    public function getCityFi(): string
    {
        return $this->city_fi;
    }

    public function getCitySv(): string
    {
        return $this->city_sv;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getCoordinateX(): float
    {
        return $this->coordinate_x;
    }

    public function getCoordinateY(): float
    {
        return $this->coordinate_y;
    }
}
