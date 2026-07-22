<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    use HasFactory;
    public $table       = 'community_posts';
    protected $fillable = [
        'user_id',
        'description',
        'file',
        'file_type',
        'total_likes',
        'total_comments',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function savedBy()
    {
        return $this->hasMany(CommunitySavedPost::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(
            CommunityComment::class,
            'post_id'
        )
            ->whereNull('parent_id')
            ->latest()
            ->with(['user', 'replies.user']);
    }

}
