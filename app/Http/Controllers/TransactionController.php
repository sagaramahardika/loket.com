<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guest;
use App\Ticket;
use App\Transaction;

class TransactionController extends Controller
{
    public function getInfo( $id ) {

        try {
            $guest = Guest::findOrFail($id);
        } catch ( Exception $e ) {
            return response()->json( ['message' => "There's no Transaction with id given"], 400 );
        }

        $json_data = array();
        $tickets = array();

        $json_data['id'] = $guest->id;
        $json_data['name'] = $guest->name;
        $json_data['email'] = $guest->email;
        $json_data['phone_number'] = $guest->phone_number;

        foreach( $guest->transactions as $transaction ) {
            $tickets[] = array(
                'id'            => $transaction->id,
                'id_guest'      => $transaction->id_guest,
                'id_ticket'     => $transaction->id_ticket,
                'quantity'      => $transaction->quantity,
            );
        }
        
        $json_data['tickets'] = $tickets;

        return response()->json( $json_data, 201 );
    }

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
