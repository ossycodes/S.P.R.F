<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    //disable mass exception
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    //a category can have many questions
    public function questions()
    {
        return $this->hasMany(Category::class);
    }
}
