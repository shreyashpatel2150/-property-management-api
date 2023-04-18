<?php
namespace App\Repository;

use DB;
use Exception;
use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Repository\PropertyRepositoryInterface;

class PropertyRepository implements PropertyRepositoryInterface
{

    private $property;
    private $propertyAmenity;

    public function __construct(Property $property, PropertyAmenity $propertyAmenity)
    {
        $this->property = $property;
        $this->propertyAmenity = $propertyAmenity;
    }

    /**
     * create new property
     * 
     * @param Array $request
     * @return Array
     */
    public function create(array $data) : array
    {
        try {
            $property = '';
            DB::transaction(function () use ($data, &$property) {
                $property = new $this->property;
                $property->name = $data['name'];
                $property->description = $data['description'];
                $property->address = $data['address'];
                $property->floor_area_width = $data['floor_area_width'];
                $property->floor_area_length = $data['floor_area_length'];
                $property->land_area_width = $data['land_area_width'];
                $property->land_area_length = $data['land_area_length'];
                $property->save();

                if ( true == isset( $data['amenities'] ) && true == is_array( $data['amenities'] ) ) {
                    foreach ( $data['amenities'] as $amenity ) {
                        $propertyAmenity = new $this->propertyAmenity;
                        $propertyAmenity->property_id = $property->id;
                        $propertyAmenity->name = $amenity;
                        $propertyAmenity->save();
                    }
                }
            });

            return [ 'status' => true, 'data' => $this->property->with('amenities')->find($property->id) ];

        } catch(Exception $e) {
            return [ 'status' => false, 'message' => 'Something went wrong happen!' ];
        }
    }
}