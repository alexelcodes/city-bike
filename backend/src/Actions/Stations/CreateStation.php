<?php

namespace Alexander\CityBike\Actions\Stations;

use Alexander\CityBike\Actions\ActionInterface;
use Alexander\CityBike\Entities\Station;
use Alexander\CityBike\Exceptions\HttpException;
use Alexander\CityBike\Http\{ErrorResponse, Request, Response, SuccessfulResponse};
use Alexander\CityBike\Repositories\StationsRepository;


class CreateStation implements ActionInterface
{
    public function __construct(
        private StationsRepository $stationsRepository
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $station = new Station(
                $request->jsonBodyField('name_fi'),
                $request->jsonBodyField('name_sv'),
                $request->jsonBodyField('name_en'),
                $request->jsonBodyField('address_fi'),
                $request->jsonBodyField('address_sv'),
                $request->jsonBodyField('city_fi'),
                $request->jsonBodyField('city_sv'),
                $request->jsonBodyField('operator'),
                $request->jsonBodyField('capacity'),
                $request->jsonBodyField('coordinate_x'),
                $request->jsonBodyField('coordinate_y'),
            );
        } catch (HttpException $error) {
            return new ErrorResponse($error->getMessage());
        }

        $this->stationsRepository->save($station);

        return new SuccessfulResponse([
            'message' => 'New station is added!',
        ]);
    }
}
