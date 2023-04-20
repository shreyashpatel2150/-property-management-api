<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $appends = [ 'display_floor_plan_area', 'display_land_area' ];

    /**
     * Get all of the amenities for the Property
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function amenities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PropertyAmenity::class);
    }


    /**
     * get the display format of floor plan area
     */
    public function getDisplayFloorPlanAreaAttribute()
    {
        return "$this->floor_area_width' x $this->floor_area_length'";
    }

    /**
     * get the display format of land area
     */
    public function getDisplayLandAreaAttribute()
    {
        return "$this->land_area_width' x $this->land_area_length'";
    }
}
