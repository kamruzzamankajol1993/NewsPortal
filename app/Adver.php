<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adver extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
