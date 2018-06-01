<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function Answers(){
        return $this->hasMany(Answer::class);
    }
}
