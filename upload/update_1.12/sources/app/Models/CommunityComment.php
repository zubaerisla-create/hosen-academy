<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityComment extends Model
{
    use HasFactory;
    public $table       = 'community_post_comments';
    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'comment',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function parent()
    {
        return $this->belongsTo(CommunityComment::class, 'parent_id');
    }
    public function replies()
    {
        return $this->hasMany(CommunityComment::class, 'parent_id')->with('user');
    }

}
