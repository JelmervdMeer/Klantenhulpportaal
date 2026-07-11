<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

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
}
