<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $firstname
 * @property string $lastname
 * @property string $login
 * @property string $password
 * @property string $coordinates
 * @property boolean $contaminated
 */
class User extends Authenticatable
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = ['fisrtname', 'lastname', 'login', 'password', 'coordinates', 'contaminated'];

    public function messages()
    {
        return $this->hasMany(Messages::class);
    }
}
