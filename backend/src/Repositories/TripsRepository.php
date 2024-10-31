<?php

namespace Alexander\CityBike\Repositories;

use Alexander\CityBike\Entities\Trip;
use InvalidArgumentException;

class TripsRepository
{
    public function __construct(
        private \PDO $pdo
    ) {
    }

    // Get the total number of trips in the database
    public function getEntries(): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM `trips`;");
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }

    public function getAll(int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;

        $stmt = $this->pdo->prepare("SELECT id, departure, `return`, departure_station_id, departure_station_name, return_station_id, return_station_name, distance, duration FROM `trips` LIMIT :offset, :limit;");

        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);

        $stmt->execute();

        return  $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function save(Trip $trip): void
    {
        $stmt = $this->pdo->prepare("INSERT IGNORE INTO trips (departure, `return`, departure_station_id, departure_station_name, return_station_id, return_station_name, distance, duration) VALUES (:departure, :return, :departure_station_id, :departure_station_name, :return_station_id, :return_station_name, :distance, :duration)");

        try {
            $stmt->execute(
                [
                    ':departure' => (string) $trip->getDeparture(),
                    ':return' => (string) $trip->getReturn(),
                    ':departure_station_id' => (int) $trip->getDepartureStationId(),
                    ':departure_station_name' => (string) $trip->getDepartureStationName(),
                    ':return_station_id' => (int) $trip->getReturnStationId(),
                    ':return_station_name' => (string) $trip->getReturnStationName(),
                    ':distance' => (int) $trip->getDistance(),
                    ':duration' => (int) $trip->getDuration(),
                ]
            );
        } catch (\Error $e) {
            throw new InvalidArgumentException('Trip contains invalid data.');
        }
    }
}
