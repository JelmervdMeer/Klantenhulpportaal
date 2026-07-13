<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {

        $user = $request->user();


        if ($user->role === 'admin') {


            $tickets = Ticket::with([
                'category',
                'user'
            ])
            ->latest()
            ->take(5)
            ->get();



            return response()->json([

                'open' => Ticket::where(
                    'status',
                    'Open'
                )->count(),


                'in_behandeling' => Ticket::where(
                    'status',
                    'In behandeling'
                )->count(),


                'gesloten' => Ticket::where(
                    'status',
                    'Gesloten'
                )->count(),


                'gebruikers' => User::count(),


                'tickets' => $tickets

            ]);

        }



        $tickets = Ticket::with([
            'category'
        ])
        ->where(
            'user_id',
            $user->id
        )
        ->latest()
        ->take(5)
        ->get();



        return response()->json([

            'open' => Ticket::where('user_id', $user->id)
                ->where('status', 'Open')
                ->count(),


            'in_behandeling' => Ticket::where('user_id', $user->id)
                ->where('status', 'In behandeling')
                ->count(),


            'gesloten' => Ticket::where('user_id', $user->id)
                ->where('status', 'Gesloten')
                ->count(),


            'gebruikers' => null,


            'tickets' => $tickets

        ]);

    }

}