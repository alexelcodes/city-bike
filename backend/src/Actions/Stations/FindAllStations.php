<?php

namespace Alexander\CityBike\Actions\Stations;

use Alexander\CityBike\Http\{ErrorResponse, Request, Response, SuccessfulResponse};
use Alexander\CityBike\Repositories\StationsRepository;
use Alexander\CityBike\Exceptions\{StationNotFoundException, HttpException};
use Alexander\CityBike\Actions\ActionInterface;

class FindAllStations implements ActionInterface
{
    public function __construct(
        private StationsRepository $stationsRepository
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            // Get the 'page' and 'limit' query parameters from the request
            $page = $request->query('page');
            $limit = $request->query('limit');
        } catch (HttpException $e) {
            return new ErrorResponse($e->getMessage());
        }

        // Validate the 'page' and 'limit' parameters
        if (!filter_var($page, FILTER_VALIDATE_INT) || (!filter_var($limit, FILTER_VALIDATE_INT) && $limit !== "0")) {
            return new ErrorResponse('Invalid parameters.');
        }

        try {
            $entries = $this->stationsRepository->getEntries();
            $stations = $this->stationsRepository->getAll($page, $limit);

            if (empty($stations)) {
                return new ErrorResponse('No stations found.', 404);
            }

            // Prepare the response data
            $data['entries'] = $entries;
            $data['stations'] = $stations;

            return new SuccessfulResponse($data);
        } catch (StationNotFoundException $e) {
            return new ErrorResponse($e->getMessage(), 404);
        }
    }
}
