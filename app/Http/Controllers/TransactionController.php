<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guest;
use App\Ticket;
use App\Transaction;

class TransactionController extends Controller
{
    public function purchase( Request $request ) {

        $this->validate($request, [
            'name'              => 'required|string',
            'email'             => 'required|string|email',
            'phone_number'      => 'required|alpha_num',
            'quantity'          => 'required|array',
        ]);

        $guest = new Guest();
        $guest->name = $request->input('name');
        $guest->email = $request->input('email');
        $guest->phone_number = $request->input('phone_number');
        $guest->save();

        foreach( $request->input('quantity') as $ticketId => $quantity ) {
            $ticket = Ticket::findOrFail($ticketId);
            
            if ( $ticket->quantity - $quantity < 0 ) {
                return response()->json( ['message' => "Ticket with id $ticketId has less than request quantity "], 400 );
            }
            
            $ticket->quantity = $ticket->quantity - $quantity;
            $ticket->save();

            $transaction = new Transaction();
            $transaction->id_guest = $guest->id;
            $transaction->id_ticket = $ticketId;
            $transaction->quantity = $quantity;
            $transaction->save();
        }

        return response()->json( ['message' => "Buying ticket successful!"], 201 );
    }
}
