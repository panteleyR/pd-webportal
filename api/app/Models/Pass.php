<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pass extends Model
{
    protected $table = 'pass';
    protected $appends = array('to');

    public function getToAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at'])->addWeek()->format('Y-m-d H:i:s');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function address()
    {
        return $this->hasOne('App\Models\Address', 'id', 'address_id');
    }
}
