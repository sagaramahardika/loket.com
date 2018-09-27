@extends("layouts.app")

@section('title')
    Edit Ticket
@endsection

@section('content')
    <div class="container" id="event">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Ticket {{ $ticket->name }}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('ticket.update', $ticket->id) }}" method="POST">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" value="{{ Session::token() }}" name="_token" />

                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $ticket->name }}" placeholder="Enter Name">
                                    
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="col-md-4 control-label">Description</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="description" name="description" value="{{ $ticket->description }}" placeholder="Enter Description">
                                    
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="price" class="col-md-4 control-label">Price</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="price" name="price" value="{{ $ticket->price }}" placeholder="Enter Price">
                                    
                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="quantity" class="col-md-4 control-label">Quantity</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="quantity" name="quantity" value="{{ $ticket->quantity }}" placeholder="Enter Quantity">
                                    
                                    @if ($errors->has('quantity'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('quantity') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('ticket.index', $ticket->id_event ) }}" class="btn btn-default">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@endsection