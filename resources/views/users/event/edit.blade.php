@extends("layouts.app")

@section('title')
    Edit Event
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"/>
@endsection

@section('content')
    <div class="container" id="event">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Event {{ $event->name }}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('event.update', $event->id) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $event->name }}" placeholder="Enter Name">
                                    
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Organizer</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="organizer" name="organizer" value="{{ $event->organizer }}" placeholder="Enter Organizer">
                                    
                                    @if ($errors->has('organizer'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('organizer') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="thn_ajaran" class="col-md-4 control-label">Date Start</label>
                                <div class='input-group date col-md-6' id='date_start'>
                                    <input type='text' class="form-control" name="date_start" value="{{ date( 'm/d/Y', $event->date_start ) }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>

                                    @if ($errors->has('date_start'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('date_start') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="date_end" class="col-md-4 control-label">Date End</label>
                                <div class='input-group date col-md-6' id='date_end'>
                                    <input type='text' class="form-control" name="date_end" value="{{ date( 'm/d/Y', $event->date_end ) }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>

                                    @if ($errors->has('date_end'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('date_end') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                @php
                                    $time_start = floor($event->time_start / 60) . ":" . ($event->time_start % 60);
                                @endphp
                                <label for="time_start" class="col-md-4 control-label">Time Start</label>
                                <div class='input-group date col-md-6' id='time_start'>
                                    <input type='text' class="form-control" name="time_start" value="{{ $time_start }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>

                                    @if ($errors->has('time_start'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('time_start') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                @php
                                    $time_end = floor($event->time_end / 60) . ":" . ($event->time_end % 60);
                                @endphp
                                <label for="time_end" class="col-md-4 control-label">Time End</label>
                                <div class='input-group date col-md-6' id='time_end'>
                                    <input type='text' class="form-control" name="time_end" value="{{ $time_end }}" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>

                                    @if ($errors->has('time_end'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('time_end') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Location Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="location_name" name="location_name" value="{{ $event->location_name }}" placeholder="Enter Location Name">

                                    @if ($errors->has('location_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('location_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Location Address</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="location_address" name="location_address" value="{{ $event->location_address }}" placeholder="Enter Location Address">

                                    @if ($errors->has('location_address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('location_address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Location City</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="location_city" name="location_city" value="{{ $event->location_city }}" placeholder="Enter Location City">

                                    @if ($errors->has('location_city'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('location_city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('event.index') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/user.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
@endsection