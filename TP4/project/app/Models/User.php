<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $login
 * @property string $password
 * @property string $coordinates
 * @property boolean $contaminated
 */
class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'login', 'password', 'coordinates', 'contaminated'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
