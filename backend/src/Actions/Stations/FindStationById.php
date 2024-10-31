<?php

namespace Alexander\CityBike\Actions\Stations;

use Alexander\CityBike\Http\{ErrorResponse, Request, Response, SuccessfulResponse};
use Alexander\CityBike\Repositories\StationsRepository;
use Alexander\CityBike\Exceptions\{StationNotFoundException};
use Alexander\CityBike\Actions\ActionInterface;

class FindStationById implements ActionInterface
{
    public function __construct(
        private StationsRepository $stationsRepository
    ) {
    }

    public function handle(Request $request): Response
    {

        // Get the 'id' query parameter from the request
        $id =  $request->query('id');

        // Validate the 'id' parameter
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return new ErrorResponse('Invalid station id.');
        }

        try {
            // Get the station and additional information by ID
            $station = $this->stationsRepository->getById($id);
            $info = $this->stationsRepository->getMoreInfoById($id);
        } catch (StationNotFoundException $error) {
            return new ErrorResponse($error->getMessage(), 404);
        }

        // Prepare the response data and send a successful response
        return new SuccessfulResponse([
            'id' => $station->getId(),
            'name' => $station->getNameFi(),
            'address' => $station->getAddressFi(),
            'capacity' => $station->getCapacity(),
            'x' => $station->getCoordinateX(),
            'y' => $station->getCoordinateY(),
            'total_start' => $info['total_start'],
            'total_end' => $info['total_end'],
            'avg_distance_start' => $info['avg_distance_start'],
            'avg_distance_end' => $info['avg_distance_end']
        ]);
    }
}
