<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

class CreateNewUser
{
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'foto_perfil' => ['required', 'image', 'max:5120'],
        ])->validate();

        /** @var UploadedFile $foto */
        $foto = $input['foto_perfil'];

        $path = $foto->store('users', 'public');

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => 'cidadao',
            'foto_perfil' => $path,
        ]);
    }
}
