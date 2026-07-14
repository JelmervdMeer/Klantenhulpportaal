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


        /*
        |--------------------------------------------------------------------------
        | Admin dashboard
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admin') {


            $tickets = Ticket::with([
                'category',
                'user'
            ])
            ->latest()
            ->take(5)
            ->get();



            return response()->json([


                'totaal' => Ticket::count(),


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


                'hoge_prioriteit' => Ticket::where(
                    'priority',
                    'Hoog'
                )->count(),



                'gebruikers' => User::count(),



                /*
                |--------------------------------------------------------------------------
                | Tickets per status voor grafiek
                |--------------------------------------------------------------------------
                */

                'status_overzicht' => [

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

                ],



                'tickets' => $tickets,



                /*
                |--------------------------------------------------------------------------
                | Tickets per status lijsten
                |--------------------------------------------------------------------------
                */

                'open_tickets' => Ticket::with([
                    'user',
                    'category'
                ])
                ->where(
                    'status',
                    'Open'
                )
                ->latest()
                ->get(),



                'in_behandeling_tickets' => Ticket::with([
                    'user',
                    'category'
                ])
                ->where(
                    'status',
                    'In behandeling'
                )
                ->latest()
                ->get(),



                'gesloten_tickets' => Ticket::with([
                    'user',
                    'category'
                ])
                ->where(
                    'status',
                    'Gesloten'
                )
                ->latest()
                ->get()


            ]);

        }





        /*
        |--------------------------------------------------------------------------
        | Gebruiker dashboard
        |--------------------------------------------------------------------------
        */


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


            'totaal' => Ticket::where(
                'user_id',
                $user->id
            )->count(),



            'open' => Ticket::where(
                'user_id',
                $user->id
            )
            ->where(
                'status',
                'Open'
            )
            ->count(),



            'in_behandeling' => Ticket::where(
                'user_id',
                $user->id
            )
            ->where(
                'status',
                'In behandeling'
            )
            ->count(),



            'gesloten' => Ticket::where(
                'user_id',
                $user->id
            )
            ->where(
                'status',
                'Gesloten'
            )
            ->count(),



            'hoge_prioriteit' => Ticket::where(
                'user_id',
                $user->id
            )
            ->where(
                'priority',
                'Hoog'
            )
            ->count(),



            'gebruikers' => null,



            'status_overzicht' => [

                'open' => Ticket::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'status',
                    'Open'
                )
                ->count(),


                'in_behandeling' => Ticket::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'status',
                    'In behandeling'
                )
                ->count(),


                'gesloten' => Ticket::where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'status',
                    'Gesloten'
                )
                ->count(),

            ],



            'tickets' => $tickets


        ]);

    }

}