<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Meal extends Model
{
    use SoftDeletes;
    use Userstamps;
    
    protected $table = "meals";
    
    protected $guarded = ['id'];
    
    protected $dates = ['date'];
    
}
