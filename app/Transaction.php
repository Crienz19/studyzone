<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'space_id',
        'pager_no',
        'start',
        'end',
        'pax',
        'duration',
        'sub_total',
        'discount',
        'total',
        'status',
        'type'
    ];

    public function format()
    {
        return [
            'id'        =>  $this->id,
            'user'      =>  $this->user,
            'space'     =>  $this->space,
            'pager_no'  =>  $this->pager_no ? $this->pager_no : 'N/A',
            'start'     =>  Carbon::parse($this->start)->format('h:i:s A'),
            'end'       =>  $this->end ? Carbon::parse($this->end)->format('h:i:s A') : 'N/A',
            'duration'  =>  $this->duration,
            'pax'       =>  $this->pax,
            'sub_total' =>  $this->sub_total,
            'discount'  =>  $this->discount,
            'total'     =>  $this->total,
            'status'    =>  $this->status,
            'type'      =>  $this->type,
            'created_at'=>  $this->created_at->toDateTimeString()
        ];
    }

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function space()
    {
        return $this->hasOne('App\Space', 'id', 'space_id');
    }
}
