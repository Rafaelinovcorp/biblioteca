<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Conversation;
use App\Models\Message;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relações
    |--------------------------------------------------------------------------
    */

    public function requisicoes()
    {
        return $this->hasMany(Requisicao::class);
    }


    public function reviews()
{
    return $this->hasMany(Review::class);
}

    /* --------------------
 | CHAT RELATIONSHIPS
 |--------------------*/

// Conversas onde o user participa
public function conversations()
{
    return $this->belongsToMany(Conversation::class)
        ->withPivot('joined_at');
}

// Mensagens enviadas pelo user
public function messages()
{
    return $this->hasMany(Message::class);
}



}
