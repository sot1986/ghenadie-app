<?php

namespace App\Models;

use App\Models\Traits\HasImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes; // add this line
    use HasImage;

    protected $guarded = [];

    protected $dispatchesEvents = [
        'deleted' => \App\Events\PostDelete::class,
    ];

    public function lastComment()
    {
        return $this->hasOne(Comment::class)->latestOfMany();
    }

    public function last3LatestComments()
    {
        return $this->hasMany(Comment::class)->orderByDesc('id')->limit(3);
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
