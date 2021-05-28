<?php

namespace App\Models;

use App\Models\User;
use App\Models\QuestionComment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $fillable = ['user_id', 'title', 'status', 'spam'];

    // custom query scopes
    public function scopeAllByRole($query)
    {
        return auth()->user()->role == 'support' ? $query : $query->whereUserId(auth()->id());
    }//end scopeAllByRole()

    public function scopeStatus($query, $status = null)
    {
        return !$status ? $query : $query->whereStatus($status);
    }//end scopeStatus()

    public function scopeWhereLike($query, $search = null)
    {
        return !$search ? $query : $query->whereHas('user', function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
    }//end scopeWhereLike()

    public function user()
    {
        return $this->belongsTo(User::class);

    }//end question()

    public function comments()
    {
        return $this->hasMany(QuestionComment::class, 'question_id', 'id');

    }//end comments()
}
