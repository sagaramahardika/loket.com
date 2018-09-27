<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Ticket;
use Exception;

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

    public function getInfo( $id ) {

        try {
            $event = Event::findOrFail($id);
        } catch ( Exception $e ) {
            return response()->json( ['message' => "There's no Event with id given"], 400 );
        }

        $json_data = array();
        $tickets = array();

        $json_data['id'] = $event->id;
        $json_data['id_user'] = $event->id_user;
        $json_data['name'] = $event->name;
        $json_data['organizer'] = $event->organizer;
        $json_data['date_start'] = $event->date_start;
        $json_data['date_end'] = $event->date_start;
        $json_data['time_start'] = $event->date_start;
        $json_data['time_end'] = $event->date_start;
        $json_data['location_name'] = $event->location_name;
        $json_data['location_address'] = $event->location_address;
        $json_data['location_city'] = $event->location_city;

        foreach( $event->tickets as $ticket ) {
            $tickets[] = array(
                'id'            => $ticket->id,
                'id_event'      => $ticket->id_event,
                'name'          => $ticket->name,
                'description'   => $ticket->description,
                'price'         => $ticket->price,
                'quantity'      => $ticket->quantity,
            );
        }
        
        $json_data['tickets'] = $tickets;

        return response()->json( $json_data, 201 );
    }
}
