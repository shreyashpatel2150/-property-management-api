<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyCreateRequest;
use App\Repository\PropertyRepositoryInterface;

class PropertyController extends Controller
{
    private PropertyRepositoryInterface $propertyRepository;

    public function __construct(PropertyRepositoryInterface $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;   
    }

    /**
     * create new property
     * 
     * @param \App\Http\Requests\PropertyCreateRequest $request
     * @return Json
     */
    public function create(PropertyCreateRequest $request)
    {
        $response = $this->propertyRepository->create($request->all());
        if ( true == $response ) {
            return response()->json([ 'data' => $response['data'] ], 200);
        }

        return response()->json([ 'message' => $response['message'] ], 500);
    }
}
