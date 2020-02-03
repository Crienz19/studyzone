<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'amenities_id',
        'quantity',
        'total'  
    ];

    public function format()
    {
        return [
            'id'            =>  $this->id,
            'amenities'     =>  $this->amenities,
            'quantity'      =>  $this->quantity,
            'total'         =>  $this->total,
            'created_at'    =>  $this->created_at->toDayDateTimeString()
        ];
    }

    public function amenities()
    {
        return $this->hasOne('App\Amenities', 'id', 'amenities_id');
    }
}
