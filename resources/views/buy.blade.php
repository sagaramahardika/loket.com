@extends("layouts.app")

@section('title')
    Tambah Event
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css"/>
@endsection

@section('content')
    <div class="container" id="event">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Event</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('event.process') }}" method="POST">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Buyer Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                                    
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">Email</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email">
                                    
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Phone Number</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Name">
                                    
                                    @if ($errors->has('phone_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if ($errors->has('quantity'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                </span>
                            @endif

                            @foreach( $tickets as $ticket )
                                <div class="form-group">
                                    <label for="name" class="col-md-4 control-label">{{ $ticket->name }}</label>
                                    <div class="col-md-6">
                                        @if ( $ticket->quantity > 0 )
                                            <select name="quantity[{{ $ticket->id }}]" class="form-control">
                                                @for( $i=0; $i <= $ticket->quantity; $i++)
                                                    <option value="{{ $i }}"> {{ $i }}</option>
                                                @endfor
                                            </select>
                                        @else
                                            <label>Sold Out</label>
                                        @endif
                                    </div>
                                </div>
                            @endforeach;

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
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