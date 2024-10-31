<?php

namespace Alexander\CityBike\Actions\Trips;

use Alexander\CityBike\Actions\ActionInterface;
use Alexander\CityBike\Entities\Trip;
use Alexander\CityBike\Exceptions\HttpException;
use Alexander\CityBike\Http\{ErrorResponse, Request, Response, SuccessfulResponse};
use Alexander\CityBike\Repositories\TripsRepository;


class CreateTrip implements ActionInterface
{
    public function __construct(
        private TripsRepository $tripsRepository
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $trip = new Trip(
                $request->jsonBodyField('departure'),
                $request->jsonBodyField('return'),
                $request->jsonBodyField('departure_station_id'),
                $request->jsonBodyField('departure_station_name'),
                $request->jsonBodyField('return_station_id'),
                $request->jsonBodyField('return_station_name'),
                $request->jsonBodyField('distance'),
                $request->jsonBodyField('duration'),
            );
        } catch (HttpException $error) {
            return new ErrorResponse($error->getMessage());
        }

        $this->tripsRepository->save($trip);

        return new SuccessfulResponse([
            'message' => 'New trip is added!',
        ]);
    }
}
