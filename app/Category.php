<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table="categories";
    protected $fillable=["name","parent"];

    ///////////////// 1> (get) set gettor functin (Name) Database Key Name , (3) Attribute set gettor Value : getNameAttribute
    public function getNameAttribute($value){
    	return ucfirst($value);
    }
}
