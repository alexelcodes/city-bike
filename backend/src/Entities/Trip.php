<?php

namespace Alexander\CityBike\Entities;

class Trip
{
    private int $id;

    public function __construct(
        private string $departure = '',
        private string $return = '',
        private int $departure_station_id = 0,
        private string $departure_station_name = '',
        private int $return_station_id = 0,
        private string $return_station_name = '',
        private int $distance = 0,
        private int $duration = 0
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDeparture(): string
    {
        return $this->departure;
    }

    public function getDepartureStationId(): int
    {
        return $this->departure_station_id;
    }

    public function getDepartureStationName(): string
    {
        return $this->departure_station_name;
    }

    public function getReturn(): string
    {
        return $this->return;
    }

    public function getReturnStationId(): int
    {
        return $this->return_station_id;
    }

    public function getReturnStationName(): string
    {
        return $this->return_station_name;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
