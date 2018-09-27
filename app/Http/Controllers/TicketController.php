<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Ticket;
use Exception;

class TicketController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id) {
        try {
            $event = Event::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'event.index' )
                ->with('error', "Failed to view Ticket Management for event with id {$id}");
        }

        return view( 'users.ticket.index', [
            'event' => $event
        ]);
    }

    public function create($id) {
        try {
            $event = Event::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'event.index' )
                ->with('error', "Failed to view Ticket Management for event with id {$id}");
        }

        return view( 'users.ticket.create', [
            'event' => $event
        ]);
    }

    public function edit($eventId, $ticketId) {
        try {
            $event = Event::findOrFail($eventId);
        } catch ( Exception $e ) {
            return redirect()->route( 'event.index' )
                ->with('error', "Failed to view Ticket with id $ticketId cause there's no Event with id $eventId");
        }

        try {
            $ticket = Ticket::findOrFail($ticketId);
        } catch ( Exception $e ) {
            return redirect()->route( 'ticket.index', $eventId )
                ->with('error', "Failed to view Ticket with id $ticketId");
        }
        
        return view( 'users.ticket.edit', [
            'ticket' => $ticket
        ]);
    }

    public function store( Request $request ) {

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

        $request->session()->flash(
            'success', "Ticket {$ticket->name} successfully added!"
        );
        return redirect()->route( 'ticket.index', $request->input('id_event') );
    }

    public function update($id, Request $request ) {

        try {
            $ticket = Ticket::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update Ticket with id {$id}!"
            );
            return redirect()->route( 'ticket.index', $ticket->id_event );
        }

        $this->validate($request, [   
            'name'              => 'required|string',
            'description'       => 'required|string',
            'price'             => 'required|numeric',
            'quantity'          => 'required|numeric', 
        ]);
        
        $ticket->name = $request->input('name');
        $ticket->description = $request->input('description');
        $ticket->price = $request->input('price');
        $ticket->quantity = $request->input('quantity');
        $ticket->save();

        $request->session()->flash(
            'success', "Ticket {$ticket->name} successfully updated!"
        );
        return redirect()->route( 'ticket.index', $ticket->id_event );
    }

    public function delete($id, Request $request) {
        try {
            $ticket = Ticket::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete Ticket with id {$id}!"
            );
            return redirect()->route( 'ticket.index', $request->input('id_event') );
        }

        $ticket_name = $ticket->name;
        $ticket->delete();

        $request->session()->flash(
            'success', "Ticket {$ticket_name} successfully deleted!"
        );
        return redirect()->route( 'ticket.index', $request->input('id_event') );
    }

    // get all matakuliah for Datatable
    public function all( Request $request ) {
        $id_event = $request->input('id_event');

        $columns = array(
            0   => 'name', 
            1   => 'organizer',
            2   => 'date_start',
            3   => 'date_end',
            4   => 'time_start',
            5   => 'time_end',
            6   => 'location_name',
            7   => 'location_address',
            8   => 'location_city',
            9   => 'id',
        );

        $totalData = Ticket::where('id_event', $id_event)->count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $tickets = Ticket::where('id_event', $id_event)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $tickets = Ticket::where('id_event', $id_event)
            ->orWhere('name','LIKE',"%{$search}%")
            ->orWhere('description', 'LIKE',"%{$search}%")
            ->orWhere('price', 'LIKE',"%{$search}%")
            ->orWhere('quantity', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Ticket::where('id_event', $id_event)
            ->orWhere('name','LIKE',"%{$search}%")
            ->orWhere('description', 'LIKE',"%{$search}%")
            ->orWhere('price', 'LIKE',"%{$search}%")
            ->orWhere('quantity', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($tickets)) {
            foreach ($tickets as $ticket) {
                $edit = route( 'ticket.edit', [ 'eventId' => $ticket->id_event, 'ticketId' => $ticket->id ] );
                $delete =  route( 'ticket.delete', $ticket->id );

                $nestedData['name'] = $ticket->name;
                $nestedData['description'] = $ticket->description;
                $nestedData['price'] = $ticket->price;
                $nestedData['quantity'] = $ticket->quantity;
                $nestedData['options'] = "
                    <a href='{$edit}' title='EDIT' class='btn btn-info' >Edit</a>
                    <form action='{$delete}' method='POST' style='display:inline-block'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='id_event' value='" . $ticket->id_event ."'>
                        <input type='hidden' value='" . $request->session()->token() . "' name='_token' />
                        <button class='btn btn-danger'>
                            Delete
                        </button>
                    </form>
                ";

                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
        );
            
        return response()->json( $json_data );
    }
}
