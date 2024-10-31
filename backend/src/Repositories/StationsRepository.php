<?php

namespace Alexander\CityBike\Repositories;

use Alexander\CityBike\Entities\Station;
use Alexander\CityBike\Exceptions\{InvalidArgumentException, StationNotFoundException};

class StationsRepository
{
    public function __construct(
        private \PDO $pdo
    ) {
    }

    // Get the total number of stations in the database
    public function getEntries(): int
    {

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM `stations`;");
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_COLUMN);
    }

    // Get a list of stations
    public function getAll(int $page, int $limit): array
    {
        $query = "SELECT id, name_fi as `name`, address_fi as `address`, capacity, coordinate_x, coordinate_y FROM `stations` ORDER BY id ASC";

        if ($limit !== 0) {
            $query .= " LIMIT :offset, :limit ;";
        }

        $stmt = $this->pdo->prepare($query);

        if ($limit !== 0) {
            $offset = ($page - 1) * $limit;

            $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?Station
    {
        $stmt = $this->pdo->prepare("SELECT stations.id, stations.name_fi, stations.address_fi, stations.capacity, stations.coordinate_x, stations.coordinate_y
        FROM stations
        WHERE stations.id = :id
        GROUP BY stations.id, stations.name_fi, stations.address_fi, stations.capacity, stations.coordinate_x, stations.coordinate_y;");

        $stmt->execute(
            [
                ':id' => (int) $id
            ]
        );

        $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Station::class)[0] ?? null;

        if ($result === null) {
            $message = "Cannot find station: $id.";
            throw new StationNotFoundException($message);
        }

        return $result;
    }

    public function getMoreInfoById(int $id): array
    {
        // Get total number of trips and the average distance of a trip
        $stmt = $this->pdo->prepare("SELECT
        SUM(CASE WHEN departure_station_id = :id THEN 1 ELSE 0 END) AS total_start,
        AVG(CASE WHEN departure_station_id = :id THEN distance ELSE NULL END) AS avg_distance_start,
        SUM(CASE WHEN return_station_id = :id THEN 1 ELSE 0 END) AS total_end,
        AVG(CASE WHEN return_station_id = :id THEN distance ELSE NULL END) AS avg_distance_end
        FROM trips
        WHERE departure_station_id = :id OR return_station_id = :id");

        $stmt->execute([':id' => $id]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function save(Station $station): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO stations (name_fi, name_sv, name_en, address_fi, address_sv, city_fi, city_sv, operator, capacity, coordinate_x, coordinate_y) VALUES (:name_fi, :name_sv, :name_en, :address_fi, :address_sv, :city_fi, :city_sv, :operator, :capacity, :coordinate_x, :coordinate_y)");

        try {
            $stmt->execute(
                [
                    ':name_fi' => (string) $station->getNameFi(),
                    ':name_sv' => (string) $station->getNameSv(),
                    ':name_en' => (string) $station->getNameEn(),
                    ':address_fi' => (string) $station->getAddressFi(),
                    ':address_sv' => (string) $station->getAddressSv(),
                    ':city_fi' => (string) $station->getCityFi(),
                    ':city_sv' => (string) $station->getCitySv(),
                    ':operator' => (string) $station->getOperator(),
                    ':capacity' => (int) $station->getCapacity(),
                    ':coordinate_x' => (float) $station->getCoordinateX(),
                    ':coordinate_y' => (float) $station->getCoordinateY()
                ]
            );
        } catch (\Error $e) {
            throw new InvalidArgumentException('Station contains invalid data.');
        }
    }
}
