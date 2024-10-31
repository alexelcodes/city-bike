<?php

namespace Alexander\CityBike\Actions;

use Alexander\CityBike\Http\{Request, Response};

interface ActionInterface
{
    public function handle(Request $request): Response;
}
