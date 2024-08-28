<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = ['question', 'slug', 'is_active'];

    public function options()
    {
        return $this->hasMany('App\Option');
    }
}
