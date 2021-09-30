<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $group_id
 * @property int $user_id
 * @property string $content
 */
class Annonce extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'annonces';

    /**
     * @var array
     */
    protected $fillable = ['group_id', 'user_id', 'content'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
