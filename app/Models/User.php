<?php

namespace App\Models;

use App\Models\QuestionComment;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    public function getJWTIdentifier()
    {
        return $this->getKey();

    }//end getJWTIdentifier()

    public function getJWTCustomClaims()
    {
        return [];

    }//end getJWTCustomClaims()

    public function questions()
    {
        return $this->hasMany(Question::class);

    }//end questions()

    public function comments()
    {
        return $this->hasMany(QuestionComment::class);

    }//end comments()

    // custom query scope
    public function scopeAllByRole($query)
    {
        return auth()->user()->role == 'support' ? $query : $query->whereId(auth()->id());
    }//end scopeAllByRole()


}//end class
