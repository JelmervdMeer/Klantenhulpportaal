<?php

namespace App\Http\Controllers;

use App\Models\User;

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
}