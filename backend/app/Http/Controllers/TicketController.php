<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Reaction;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();


        if ($user->role === 'admin') {

            $tickets = Ticket::with([
                'user',
                'category',
                'assignedAdmin'
            ])->get();

        } else {

            $tickets = Ticket::with([
                'category',
                'assignedAdmin'
            ])
            ->where('user_id', $user->id)
            ->get();

        }


        return response()->json([
            'tickets' => $tickets
        ]);
    }



    public function show(Request $request, Ticket $ticket)
    {
        $user = $request->user();


        // Alleen eigen tickets bekijken voor normale gebruikers
        if (
            $user->role !== 'admin' &&
            $ticket->user_id !== $user->id
        ) {
            return response()->json([
                'message' => 'Geen toegang tot dit ticket.'
            ], 403);
        }


        $ticket->load([
            'user',
            'category',
            'assignedAdmin',
            'reactions.user',
            'notes.user'
        ]);


        return response()->json([
            'ticket' => $ticket
        ]);
    }

    public function storeReaction(Request $request, Ticket $ticket)
{
    $validated = $request->validate([
        'message' => 'required|string'
    ]);

    $reaction = Reaction::create([
        'message' => $validated['message'],
        'ticket_id' => $ticket->id,
        'user_id' => $request->user()->id,
    ]);

    $reaction->load('user');

    return response()->json([
        'message' => 'Reactie toegevoegd.',
        'reaction' => $reaction
    ], 201);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        'priority' => 'required|in:Laag,Normaal,Hoog',
    ]);


    $ticket = Ticket::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'category_id' => $validated['category_id'],
        'priority' => $validated['priority'],
        'status' => 'Open',
        'user_id' => $request->user()->id,
    ]);


    $ticket->load('category');


    return response()->json([
        'message' => 'Ticket succesvol aangemaakt.',
        'ticket' => $ticket
    ], 201);
}
}
