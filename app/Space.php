<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $fillable = [
        'name',
        'description',
        'rate',
        'daily_rate',
        'weekly_rate',
        'monthly_rate',
        'capacity',
        'image'
    ];

    public function format()
    {
        return [
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'description'   =>  $this->description,
            'rate'          =>  $this->rate,
            'daily_rate'    =>  $this->daily_rate,
            'weekly_rate'   =>  $this->weekly_rate,
            'monthly_rate'  =>  $this->monthly_rate,
            'capacity'      =>  $this->capacity,
            'image'         =>  $this->image,
            'updated_at'    =>  $this->updated_at
        ];
    }
}
