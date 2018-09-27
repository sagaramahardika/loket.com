<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Ticket;

class EventAPIController extends Controller
{
    public function create( Request $request ) {

        $this->validate($request, [
            'name'              => 'required|string',
            'organizer'         => 'required|string',
            'date_start'        => 'required',
            'date_end'          => 'required',
            'time_start'        => 'required',
            'time_end'          => 'required',
            'location_name'     => 'required|string',
            'location_address'  => 'required|string',
            'location_city'     => 'required|string', 
        ]);

        $arr_time_start = explode(":", $request->input('time_start') );
        $arr_time_end = explode(":", $request->input('time_end') );
        $time_start = 60 * intval($arr_time_start[0]) + intval($arr_time_start[1]);
        $time_end = 60 * intval($arr_time_end[0]) + intval($arr_time_end[1]);

        $event = new Event();
        $event->id_user = 1;
        $event->name = $request->input('name');
        $event->organizer = $request->input('organizer');
        $event->date_start = strtotime( $request->input('date_start') );
        $event->date_end = strtotime( $request->input('date_end') );
        $event->time_start = $time_start;
        $event->time_end = $time_end;
        $event->location_name = $request->input('location_name');
        $event->location_address = $request->input('location_address');
        $event->location_city = $request->input('location_city');
        $event->save();

        return response()->json( $event, 201 );
    }

    public function createTicket( Request $request ) {

        $this->validate($request, [
            'id_event'          => 'required',      
            'name'              => 'required|string',
            'description'       => 'required|string',
            'price'             => 'required|numeric',
            'quantity'          => 'required|numeric', 
        ]);

        $ticket = new Ticket();
        $ticket->id_event = $request->input('id_event');
        $ticket->name = $request->input('name');
        $ticket->description = $request->input('description');
        $ticket->price = $request->input('price');
        $ticket->quantity = $request->input('quantity');
        $ticket->save();

        return response()->json( $ticket, 201 );
    }
}
