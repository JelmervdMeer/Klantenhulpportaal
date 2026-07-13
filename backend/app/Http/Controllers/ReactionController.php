<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{

    public function update(Request $request, Reaction $reaction)
    {

        if ($request->user()->role !== 'admin') {

            return response()->json([
                'message' => 'Geen toegang.'
            ], 403);

        }


        $validated = $request->validate([

            'message' => 'required|string'

        ]);



        $reaction->update([

            'message' => $validated['message']

        ]);



        $reaction->load('user');



        return response()->json([

            'message' => 'Reactie aangepast.',

            'reaction' => $reaction

        ]);

    }

}