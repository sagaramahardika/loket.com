<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Auth;

class EventController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view( 'users.event.index' );
    }

    public function create() {
        return view( 'users.event.create' );
    }

    public function edit($id) {
        try {
            $event = Event::findOrFail($id);
        } catch ( Exception $e ) {
            return redirect()->route( 'matkul.index' )
                ->with('error', "Failed to view Event with id {$id}");
        }
        
        return view( 'users.event.edit', [
            'event' => $event
        ]);
    }

    public function store( Request $request ) {
        $user = Auth::user();

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
        $event->id_user = $user->id;
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

        $request->session()->flash(
            'success', "Event {$event->name} successfully added!"
        );
        return redirect()->route( 'event.index' );
    }

    public function update($id, Request $request ) {
        $user = Auth::user();

        try {
            $event = Event::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to update Event with id {$id}!"
            );
            return redirect()->route( 'event.index' );
        }

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

        $request->session()->flash(
            'success', "Event {$event->name} successfully added!"
        );
        return redirect()->route( 'event.index' );
    }

    public function delete($id, Request $request) {
        try {
            $event = Event::findOrFail($id);
        } catch ( Exception $e ) {
            $request->session()->flash(
                'error', "Failed to delete event with id {$id}!"
            );
            return redirect()->route( 'matkul.index' );
        }

        $event_name = $event->name;
        $event->delete();

        $request->session()->flash(
            'success', "Event {$event_name} successfully deleted!"
        );
        return redirect()->route( 'event.index' );
    }

    // get all matakuliah for Datatable
    public function all( Request $request ) {
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

        $totalData = Event::count();
        $totalFiltered = $totalData;
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if ( empty($request->input('search.value') )) {            
            $events = Event::offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {
            $search = $request->input('search.value'); 

            $matakuliahs = Event::where('name','LIKE',"%{$search}%")
            ->orWhere('organizer', 'LIKE',"%{$search}%")
            ->orWhere('location_name', 'LIKE',"%{$search}%")
            ->orWhere('location_address', 'LIKE',"%{$search}%")
            ->orWhere('location_city', 'LIKE',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $totalFiltered = Event::where('name','LIKE',"%{$search}%")
            ->orWhere('organizer', 'LIKE',"%{$search}%")
            ->orWhere('location_name', 'LIKE',"%{$search}%")
            ->orWhere('location_address', 'LIKE',"%{$search}%")
            ->orWhere('location_city', 'LIKE',"%{$search}%")
            ->count();
        }

        $data = array();
        if(!empty($events)) {
            foreach ($events as $event) {
                $edit = route( 'event.edit', $event->id );
                $delete =  route( 'event.delete', $event->id );
                $time_start = floor( $event->time_start / 60 ) . ":" . ( $event->time_start % 60 );
                $time_end = floor( $event->time_end / 60 ) . ":" . ( $event->time_end % 60 );

                $nestedData['name'] = $event->name;
                $nestedData['organizer'] = $event->organizer;
                $nestedData['date_start'] = date( 'd M Y', $event->date_start );
                $nestedData['date_end'] = date( 'd M Y', $event->date_end );
                $nestedData['time_start'] = $time_start;
                $nestedData['time_end'] = $time_end;
                $nestedData['location_name'] = $event->location_name;
                $nestedData['location_address'] = $event->location_address;
                $nestedData['location_city'] = $event->location_city;
                $nestedData['options'] = "
                    <a href='{$edit}' title='EDIT' class='btn btn-info' >Edit</a>
                    <form action='{$delete}' method='POST' style='display:inline-block'>
                        <input type='hidden' name='_method' value='DELETE'>
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
