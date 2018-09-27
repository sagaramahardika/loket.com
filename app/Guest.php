<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    public function transactions() {
        return $this->hasMany( 'App\Transaction', 'id_guest', 'id' );
    }
}
