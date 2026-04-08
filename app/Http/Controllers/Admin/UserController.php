<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Believer;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $believers = Believer::whereDoesntHave('user')->get();
        $roles = Role::all();

        return view('admin.users.form', compact('user', 'believers', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $defaultPassword = 'password'; // Mot de passe par défaut

        $request->validate([
            'believer_id' => 'required|exists:believers,id|unique:users,believer_id',
            'roles' => 'required|array|min:1',
        ]);

        $believer = Believer::findOrFail($request->believer_id);

        $first = Str::of($believer->firstname)->lower()->explode(' ')->last();
        $last = Str::of($believer->lastname)->lower();

       $baseUsername = preg_replace('/[^a-z0-9\-]/', '', $first) . '.' . preg_replace('/[^a-z0-9\-]/', '', $last);
       $username = $baseUsername;

        // Gestion des doublons
        $i = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $i;
            $i++;
        }

        $user = User::create([
            'believer_id' => $believer->id,
            'name' => $believer->firstname . ' ' . $believer->lastname,
            'username' => $username,
            'email' => $believer->email,
            'password' => Hash::make($defaultPassword),
            'must_change_password' => true,
        ]);

        $user->roles()->attach($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'Compte Utilisateur créé avec succès. Username : ' . $username);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $believers = Believer::whereDoesntHave('user')->get();

        return view('admin.users.form', compact('user', 'roles', 'believers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'believer_id' => 'required|exists:believers,id|unique:users,believer_id,' . $user->id,
            'roles' => 'required|array|min:1',
        ]);

        $user->believer_id = $request->believer_id;
        $user->name = Believer::find($request->believer_id)->firstname . ' ' . Believer::find($request->believer_id)->lastname;
        $user->email = Believer::find($request->believer_id)->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $user->roles()->sync($request->roles);

        return redirect()->route('admin.users.index')->with('success', 'Compte Utilisateur mis à jour avec succès.');
    }

    // Désactiver un utilisateur
    public function deactivate(Request $request, User $user)
    {
        $request->validate([
            'deactivation_reason' => 'required|string|max:255',
        ]);

        $user->update([
            'is_active' => false,
            'deactivated_at' => now(),
            'deactivated_by' => auth()->id(),
            'deactivation_reason' => $request->input('deactivation_reason'),
        ]);

        return back()->with('success', 'Compte Utilisateur désactivé avec succès.');
    }

    // Réactiver un utilisateur
    public function reactivate(User $user)
    {
        $user->update([
            'is_active' => true,
            'deactivated_at' => null,
            'deactivated_by' => null,
            'deactivation_reason' => null,
        ]);

        return back()->with('success', 'Compte Utilisateur réactivé avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
