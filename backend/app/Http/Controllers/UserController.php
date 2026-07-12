<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    /**
     * Geef alle administrators terug.
     */
    public function admins()
    {
        $admins = User::where('role', 'admin')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'admins' => $admins
        ]);
    }

    public function index(Request $request)
{
    if ($request->user()->role !== 'admin') {

        return response()->json([
            'message' => 'Geen toegang.'
        ], 403);

    }

    $users = User::orderBy('name')->get();

    return response()->json([
        'users' => $users
    ]);
}


public function update(Request $request, User $user)
{
    if ($request->user()->role !== 'admin') {

        return response()->json([
            'message' => 'Geen toegang.'
        ], 403);

    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,user',
    ]);

    $user->update($validated);

    return response()->json([
        'message' => 'Gebruiker bijgewerkt.',
        'user' => $user
    ]);
}


public function destroy(Request $request, User $user)
{
    if ($request->user()->role !== 'admin') {

        return response()->json([
            'message' => 'Geen toegang.'
        ], 403);

    }

    // Voorkom dat een administrator zichzelf verwijdert
    if ($request->user()->id === $user->id) {

        return response()->json([
            'message' => 'Je kunt je eigen account niet verwijderen.'
        ], 422);

    }

    $user->delete();

    return response()->json([
        'message' => 'Gebruiker verwijderd.'
    ]);
}
}