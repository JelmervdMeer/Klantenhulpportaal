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


        $query = Ticket::with([
            'user',
            'category',
            'assignedAdmin'
        ]);



        // Normale gebruikers zien alleen eigen tickets

        if ($user->role !== 'admin') {

            $query->where(
                'user_id',
                $user->id
            );

        }



        // Zoeken op titel

        if ($request->filled('search')) {

            $query->where(
                'title',
                'like',
                '%' . $request->search . '%'
            );

        }



        // Filter op status

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }



        // Filter op prioriteit

        if ($request->filled('priority')) {

            $query->where(
                'priority',
                $request->priority
            );

        }



        $tickets = $query
            ->latest()
            ->get();



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





    public function updateStatus(Request $request, Ticket $ticket)
    {

        $validated = $request->validate([

            'status' => 'required|in:Open,In behandeling,Gesloten',

        ]);



        $ticket->update([

            'status' => $validated['status']

        ]);



        return response()->json([

            'message' => 'Status aangepast.',

            'ticket' => $ticket

        ]);

    }





    public function updatePriority(Request $request, Ticket $ticket)
    {

        $validated = $request->validate([

            'priority' => 'required|in:Laag,Normaal,Hoog',

        ]);



        $ticket->update([

            'priority' => $validated['priority'],

        ]);



        return response()->json([

            'message' => 'Prioriteit bijgewerkt',

            'ticket' => $ticket

        ]);

    }

    public function assign(Request $request, Ticket $ticket)
{
    // Alleen administrators mogen tickets toewijzen
    if ($request->user()->role !== 'admin') {

        return response()->json([
            'message' => 'Geen toegang.'
        ], 403);

    }

    $validated = $request->validate([
        'assigned_to' => 'nullable|exists:users,id'
    ]);

    $ticket->update([
        'assigned_to' => $validated['assigned_to']
    ]);

    $ticket->load('assignedAdmin');

    return response()->json([
        'message' => 'Ticket succesvol toegewezen.',
        'ticket' => $ticket
    ]);
}

}