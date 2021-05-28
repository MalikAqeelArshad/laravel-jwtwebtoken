<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuestionCommentMail extends Mailable
{
    protected $user;
    protected $comment;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $comment)
    {
        $this->user = $user;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.question-comment')->with([
            'user' => $this->user,
            'comment' => $this->comment
        ])->subject($this->comment->question->title)
            ->to($this->user->email)->from(auth()->user()->email);
    }
}
