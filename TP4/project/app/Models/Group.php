<?php

namespace App\Models;

use App\Models\Group as ModelsGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 */
class Group extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'group';

    /**
     * @var array
     */
    protected $fillable = ['name'];

    public function annonces()
    {
        return $this->hasMany(Annonce::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class, 'User2group', 'user_id', 'group_id');
    }
}
