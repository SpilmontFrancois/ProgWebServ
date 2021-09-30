<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $user1
 * @property int $user2
 */
class Friend extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'friends';

    /**
     * @var array
     */
    protected $fillable = ['user1', 'user2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
