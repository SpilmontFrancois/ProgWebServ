<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

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
    use HasFactory, SoftDeletes, HasApiTokens;

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
    public function friends()
    {
        return $this->hasMany(Friend::class);
    }
    
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'User2group', 'user_id', 'group_id');
    }
}
