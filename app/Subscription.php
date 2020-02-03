<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'subscription_code',
        'space_id',
        'user_id',
        'plan',
        'date_registered',
        'date_expired',
        'price',
        'status'
    ];

    public function format()
    {
        return array(
            'id'                =>  $this->id,
            'subscription_code' =>  $this->subscription_code,
            'space'             =>  $this->space,
            'user'              =>  $this->user,
            'plan'              =>  $this->plan,
            'date_registered'   =>  Carbon::parse($this->date_registered)->toFormattedDateString(),
            'date_expired'      =>  Carbon::parse($this->date_expired)->toFormattedDateString(),
            'price'             =>  $this->price,
            'status'            =>  $this->status,
            'created_at'        =>  $this->created_at->toDayDateTimeString()
        );
    }

    public function space()
    {
        return $this->hasOne('App\Space', 'id', 'space_id');
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
}
