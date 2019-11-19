<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    
    protected $fillable = ([
        'competition_name','event_scope_id','prize_id','user_id'
    ]);

    public function scope(){
        return $this->hasOne('\App\Event_scope','event_scope_id','event_scope_id');
    }

    public function prize(){
        return $this->hasOne('\App\Prize','prize_id','prize_id');
    }

}