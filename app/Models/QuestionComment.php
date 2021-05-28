<?php

namespace App\Models;

use App\Models\User;
use App\Models\Question;
use App\Mail\QuestionCommentMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionComment extends Model
{
    use HasFactory;
    protected $table = 'question_comments';
    protected $fillable = ['user_id', 'question_id', 'message', 'read_at'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($comment) {
            if (auth()->user()->role == 'support') {
                $user = User::findOrFail($comment->question->user_id);
// dd($user->email);

                \Mail::send(new QuestionCommentMail($user, $comment));
            }

            // \Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            //     $m->from('hello@app.com', 'Your Application');

            //     $m->to($user->email, $user->name)->subject('Your Reminder!');
            // });
        });
    }//end boot()

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');

    }//end question()
}
