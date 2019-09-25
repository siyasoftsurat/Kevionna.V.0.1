<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Category;
class Bennar extends Model
{
    use SoftDeletes;
    protected $table = 'bennars';
    protected $fillable = ['path','description','categories_id'];

    public function getCategory(){
    	return $this->hasOne(Category::class,'id','categories_id');
    }
}
