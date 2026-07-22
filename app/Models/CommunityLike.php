<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityLike extends Model
{
    use HasFactory;
    public $table       = 'community_post_likes';
    protected $fillable = [
        'post_id',
        'user_id',
    ];

}
