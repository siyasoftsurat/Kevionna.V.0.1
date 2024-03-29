<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyInfo extends Model
{
    use SoftDeletes;
    protected $fillable=["name","logo","address","mobile","email","workingtime"];
}
