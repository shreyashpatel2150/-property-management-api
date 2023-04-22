<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyCreateRequest;
use App\Http\Requests\PropertyUpdateRequest;
use App\Repository\PropertyRepositoryInterface;

class PropertyController extends Controller
{
    private PropertyRepositoryInterface $propertyRepository;
    
    /**
     * __construct
     *
     * @param  PropertyRepositoryInterface $propertyRepository
     * @return void
     */
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

    /**
     * 
     * list all properties
     * @param Illuminate\Http\Request $request
     * @return Json
     */
    public function list(Request $request)
    {
        $response = $this->propertyRepository->list($request->search);
        return response()->json([ 'data' => $response ], 200);
    }

    /**
     * Delete property and its amenities
     * @param integer $id
     * @return Json
     */
    public function destroy($id)
    {
        $response = $this->propertyRepository->destroy($id);
        if ( true == $response['status'] ) {
            return response()->json([ 'message' => $response['message'] ], 200);
        }

        return response()->json([ 'message' => $response['message'] ], 500);
    }

    /**
     * Get the property details by property id
     * @param integer $id
     * @return Json
     */
    public function edit($id)
    {
        $response = $this->propertyRepository->find($id);
        return response()->json([ 'data' => $response ], 200);
    }

    /**
     * Update property detail
     * @param App\Http\Requests\PropertyUpdateRequest $request
     * @param integer $id
     * @return Json
     */
    public function update(PropertyUpdateRequest $request, $id)
    {
        $response = $this->propertyRepository->update($request->all(), $id);
        if ( true == $response ) {
            return response()->json([ 'message' => $response['message'] ], 200);
        }

        return response()->json([ 'message' => $response['message'] ], 500);
    }
}
