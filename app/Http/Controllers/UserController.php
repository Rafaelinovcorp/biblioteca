<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,cidadao',
            'foto_perfil' => 'required|image|max:5120',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['foto_perfil'] = $request->file('foto_perfil')->store('users', 'public');

        $user = User::create($data);

        LogService::criar(
            'Utilizadores',
            'Criou utilizador: ' . $user->email,
            $user->id
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilizador criado com sucesso.');
    }

    public function show(User $user)
    {
        $user->load('requisicoes');

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,cidadao',
            'foto_perfil' => 'nullable|image|max:5120',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('foto_perfil')) {
            if ($user->foto_perfil) {
                Storage::disk('public')->delete($user->foto_perfil);
            }
            $data['foto_perfil'] = $request->file('foto_perfil')->store('users', 'public');
        }

        $user->update($data);

        LogService::criar(
            'Utilizadores',
            'Atualizou utilizador: ' . $user->email,
            $user->id
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilizador atualizado.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'erro' => 'Não podes eliminar a tua própria conta.',
            ]);
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors([
                'erro' => 'Tem de existir pelo menos um administrador.',
            ]);
        }

        if ($user->foto_perfil) {
            Storage::disk('public')->delete($user->foto_perfil);
        }

        $userEmail = $user->email;
        $userId = $user->id;

        $user->delete();

        LogService::criar(
            'Utilizadores',
            'Eliminou utilizador: ' . $userEmail,
            $userId
        );

        return redirect()
            ->route('users.index')
            ->with('success', 'Utilizador eliminado.');
    }
}
