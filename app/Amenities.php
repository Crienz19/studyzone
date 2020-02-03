<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    protected $fillable = [
        'name',
        'price'
    ];

    public function format()
    {
        return [
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'price'         =>  $this->price,
            'created_at'    =>  $this->created_at->toDayDateTimeString()
        ];
    }
}
