<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use Userstamps;

    protected $table ="users";
    
    protected $guarded = ['id', 'password_confirmation'];
    
    protected $hidden = ['password', 'remember_token'];
    
    public function hasRole($role) {
        return $this->type == $role;
    }
}
