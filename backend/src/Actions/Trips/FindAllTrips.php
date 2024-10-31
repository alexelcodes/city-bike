<?php

namespace Alexander\CityBike\Actions\Trips;

use Alexander\CityBike\Http\{ErrorResponse, Request, Response, SuccessfulResponse};
use Alexander\CityBike\Repositories\TripsRepository;
use Alexander\CityBike\Exceptions\{TripNotFoundException, HttpException};
use Alexander\CityBike\Actions\ActionInterface;

class FindAllTrips implements ActionInterface
{
    public function __construct(
        private TripsRepository $tripsRepository
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
        if (!filter_var($page, FILTER_VALIDATE_INT) || !filter_var($limit, FILTER_VALIDATE_INT)) {
            return new ErrorResponse('Invalid parameters.');
        }

        try {
            $entries = $this->tripsRepository->getEntries();
            $trips = $this->tripsRepository->getAll($page, $limit);

            if (empty($trips)) {
                return new ErrorResponse('No trips found.', 404);
            }

            // Prepare the response data
            $data['entries'] = $entries;
            $data['trips'] = $trips;
            return new SuccessfulResponse($data);
        } catch (TripNotFoundException $e) {
            return new ErrorResponse($e->getMessage(), 404);
        }
    }
}
