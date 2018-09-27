<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Guest;
use App\Ticket;
use App\Transaction;

class EventGuestController extends Controller
{
    public function buy($id) {
        $tickets = Ticket::where('id_event', $id)->get();

        return view( 'buy', [
            'tickets' => $tickets
        ]);
    }

    public function process(Request $request) {

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
            $ticket->quantity = $ticket->quantity - $quantity;
            $ticket->save();

            $transaction = new Transaction();
            $transaction->id_guest = $guest->id;
            $transaction->id_ticket = $ticketId;
            $transaction->quantity = $quantity;
            $transaction->save();
        }

        $request->session()->flash(
            'success', "Buying Ticket successfull!"
        );
        return redirect()->route( 'home' );
    }
}
