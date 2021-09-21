<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $user1
 * @property string $user2
 * @property string $content
 */
class Ingredient extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'messages';

    /**
     * @var array
     */
    protected $fillable = ['user1', 'user2', 'content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
