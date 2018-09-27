<div class="collapse navbar-collapse" id="app-navbar-collapse">
    <!-- Left Side Of Navbar -->
    
    <ul class="nav navbar-nav">

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                Event <span class="caret"></span>
            </a>

            <ul class="dropdown-menu">
                <li><a href="{{ route('event.index') }}"> View </a></li>
                <li><a href="{{ route('event.create') }}"> Create </a></li>
            </ul>
        </li>
    </ul>

    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="{{ route('logout') }}"> Logout </a>
        </li>
    </ul>
    
</div>