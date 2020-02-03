<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'control_no',
        'type',
        'date_activated',
        'date_expired',
        'discount',
        'status',
        'price'
    ];

    public function format()
    {
        return [
            'id'                =>  $this->id,
            'control_no'        =>  $this->control_no,
            'type'              =>  $this->type,
            'date_activated'    =>  Carbon::parse($this->date_activated)->toFormattedDateString(),
            'date_expired'      =>  Carbon::parse($this->date_expired)->toFormattedDateString(),
            'discount'          =>  $this->discount,
            'price'             =>  $this->price,
            'status'            =>  $this->status,
            'created_at'        =>  $this->created_at->toDayDateTimeString()
        ];
    }
}
