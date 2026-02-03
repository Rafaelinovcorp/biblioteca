<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'avatar',
        'created_by',
    ];

    /* --------------------
     | RELATIONSHIPS
     |--------------------*/

    // Participantes da conversa
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('joined_at');
    }

    // Mensagens da conversa
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Criador da conversa (admin ou user)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /* --------------------
     | HELPERS
     |--------------------*/

    public function isDirect(): bool
    {
        return $this->type === 'direct';
    }

    public function isRoom(): bool
    {
        return $this->type === 'room';
    }

   public static function getOrCreateDirect(User $userA, User $userB): self
{
    // Procurar DM existente
    $conversation = self::where('type', 'direct')
        ->whereHas('users', function ($q) use ($userA) {
            $q->where('users.id', $userA->id);
        })
        ->whereHas('users', function ($q) use ($userB) {
            $q->where('users.id', $userB->id);
        })
        ->get()
        ->first(function ($conversation) {
            return $conversation->users()->count() === 2;
        });

    if ($conversation) {
        return $conversation;
    }

    // Criar nova DM
    $conversation = self::create([
        'type' => 'direct',
        'created_by' => $userA->id,
    ]);

    $conversation->users()->attach([
        $userA->id => ['joined_at' => now()],
        $userB->id => ['joined_at' => now()],
    ]);

    return $conversation;
}

public static function createRoom(
    string $name,
    array $userIds,
    int $adminId,
    ?string $avatar = null
): self {
    $conversation = self::create([
        'type' => 'room',
        'name' => $name,
        'avatar' => $avatar,
        'created_by' => $adminId,
    ]);

    // adicionar admin à sala
    $userIds[] = $adminId;
    $userIds = array_unique($userIds);

    $conversation->users()->attach(
        collect($userIds)->mapWithKeys(fn ($id) => [
            $id => ['joined_at' => now()],
        ])->toArray()
    );

    return $conversation;
}


}
