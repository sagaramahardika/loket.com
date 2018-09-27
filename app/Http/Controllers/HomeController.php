<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class HomeController extends Controller
{
    public function index() {
        $events = Event::limit(9)->get();

        return view( 'home', [
            'events'    => $events
        ]);
    }
}
