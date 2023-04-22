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
     * @param Array $data
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
                        if ( '' != $amenity ) {
                            $propertyAmenity = new $this->propertyAmenity;
                            $propertyAmenity->property_id = $property->id;
                            $propertyAmenity->name = $amenity;
                            $propertyAmenity->save();
                        }
                    }
                }
            });

            return [ 'status' => true, 'data' => $this->property->with('amenities')->find($property->id) ];

        } catch(Exception $e) {
            return [ 'status' => false, 'message' => 'Something went wrong happen!' ];
        }
    }

    /**
     * 
     * list all properties
     * @param String $search
     * 
     * @return \Illuminate\contracts\Pagination\LengthAwarePaginator
     */
    public function list($search = '') : ?\Illuminate\contracts\Pagination\LengthAwarePaginator
    {
        $properties = $this->property->with('amenities');
        if ( '' != $search ) {
            $properties = $properties->where('name', 'like', "%{$search}%")
                                    ->orWhere('address', 'like', "%{$search}%")
                                    ->orWhere('floor_area_width', 'like', "%{$search}%")
                                    ->orWhere('floor_area_length', 'like', "%{$search}%")
                                    ->orWhere('land_area_width', 'like', "%{$search}%")
                                    ->orWhere('land_area_length', 'like', "%{$search}%");
        }
        return $properties->paginate(5);
    }

    /**
     * 
     * Delete property
     * @param integer $id
     * 
     * @return Array
     */
    public function destroy(int $id) : array
    {
        try {
            if($this->property->destroy($id)) {
                return [ 'status' => true, 'data' => [], 'message' => 'Property deleted successfully.' ];
            }

            return [ 'status' => false, 'message' => 'Something went wrong happen!' ];
        } catch(Exception $e) {
            dd($e);
            return [ 'status' => false, 'message' => 'Something went wrong happen!' ];
        }
    }

    /**
     * Get the property details by property id
     * @param integer $id
     * @return \App\Models\Property
     */
    public function find(int $id) : \App\Models\Property
    {
        return $this->property->with('amenities')->find($id);
    }

    /**
     * Update property detail
     * 
     * @param Array $data
     * @param integer $id
     * @return Array
     */
    public function update(array $data, int $id) : array
    {
        try {
            DB::transaction(function () use ($data, $id) {
                $property = $this->property->find($id);
                $property->name = $data['name'];
                $property->description = $data['description'];
                $property->address = $data['address'];
                $property->floor_area_width = $data['floor_area_width'];
                $property->floor_area_length = $data['floor_area_length'];
                $property->land_area_width = $data['land_area_width'];
                $property->land_area_length = $data['land_area_length'];
                $property->save();

                $allPropertyIds = [];
                if ( true == isset( $data['amenities'] ) && true == is_array( $data['amenities'] ) ) {
                    foreach ( $data['amenities'] as $key => $amenity ) {
                        if ( '' != $amenity ) {
                            if ( isset($data['amenityIds'][$key]) && $data['amenityIds'][$key] > 0 ) {
                                $propertyAmenity = $this->propertyAmenity->find($data['amenityIds'][$key]);
                            } else {
                                $propertyAmenity = new $this->propertyAmenity;
                                $propertyAmenity->property_id = $property->id;
                            }
                            $propertyAmenity->name = $amenity;
                            $propertyAmenity->save();
                            $allPropertyIds[] = $propertyAmenity->id;
                        }
                    }
                }

                $amenities = $this->propertyAmenity->where('property_id', $id);
                if ( count( $allPropertyIds ) > 0 ) {
                    $amenities->whereNotIn('id', $allPropertyIds);
                }
                $amenities->delete();
            });
            return [ 'status' => true, 'message' => 'Property updated succesfully.' ];
        } catch(Exception $e) {
            return [ 'status' => false, 'message' => 'Something went wrong happen!' ];
        }
    }
}