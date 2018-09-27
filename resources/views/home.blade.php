@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">Events</div>

                <div class="panel-body">
                        @if ( Session::has('success') )
                            <div class="alert alert-success">
                                <p> {{ Session::get('success') }} </p>
                            </div>
                        @endif

                    @if ( $events->isNotEmpty() )
                        @foreach( $events as $event )

                            <div class="col-md-6">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQYadGhnEEljY7Pv-N5sSQyhTsgbMkOcpPaua7Io8OmUVJx5eA" alt="" />
                                <label for="">{{ $event->name }}</label>
                                <div class="section_date">
                                    <label for="">Date Start : {{ date('d M Y', $event->date_start) }}</label>
                                    <label for="">Date End : {{ date('d M Y', $event->date_end) }}</label>
                                </div>
                                <div class="section_time">
                                    @php
                                        $time_start = floor( $event->time_start / 60 ) . ":" . ( $event->time_start % 60 );
                                        $time_end = floor( $event->time_end / 60 ) . ":" . ( $event->time_end % 60 );
                                    @endphp
                                    <label for="">Time Start : {{ $time_start }}</label>
                                    <label for="">Time End : {{ $time_end }}</label>
                                </div>
                                <div class="location">
                                    <label for="">Location : {{ $event->location_name }}</label>
                                    <label for="">{{ $event->location_address . " " . $event->location_city }}</label>
                                </div>
                                <a href="{{ route('event.buy', $event->id) }}" class="btn btn-primary">Buy Ticket</a>
                            </div>

                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
