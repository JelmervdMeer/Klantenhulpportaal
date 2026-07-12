<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Ticket;
use Illuminate\Http\Request;

class NoteController extends Controller
{

    /**
     * Toon alle notities van een ticket
     */
    public function index(Request $request, Ticket $ticket)
    {

        if ($request->user()->role !== 'admin') {

            return response()->json([
                'message' => 'Geen toegang.'
            ], 403);

        }


        $notes = $ticket->notes()
            ->with('user')
            ->latest()
            ->get();



        return response()->json([
            'notes' => $notes
        ]);

    }





    /**
     * Nieuwe notitie toevoegen
     */
    public function store(Request $request, Ticket $ticket)
    {

        if ($request->user()->role !== 'admin') {

            return response()->json([
                'message' => 'Geen toegang.'
            ], 403);

        }



        $validated = $request->validate([

            'note' => 'required|string'

        ]);



        $note = Note::create([

            'note' => $validated['note'],

            'ticket_id' => $ticket->id,

            'user_id' => $request->user()->id

        ]);



        $note->load('user');



        return response()->json([

            'message' => 'Notitie toegevoegd.',

            'note' => $note

        ], 201);

    }





    /**
     * Notitie aanpassen
     */
    public function update(Request $request, Note $note)
    {

        if ($request->user()->role !== 'admin') {

            return response()->json([
                'message' => 'Geen toegang.'
            ], 403);

        }



        $validated = $request->validate([

            'note' => 'required|string'

        ]);



        $note->update([

            'note' => $validated['note']

        ]);



        return response()->json([

            'message' => 'Notitie aangepast.',

            'note' => $note

        ]);

    }





    /**
     * Notitie verwijderen
     */
    public function destroy(Request $request, Note $note)
    {

        if ($request->user()->role !== 'admin') {

            return response()->json([
                'message' => 'Geen toegang.'
            ], 403);

        }



        $note->delete();



        return response()->json([

            'message' => 'Notitie verwijderd.'

        ]);

    }

}