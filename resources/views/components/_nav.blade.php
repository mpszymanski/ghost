<nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                    <li>
                        <a class="nav-link {{ request()->route()->getName() == 'events.create' ? 'active' : '' }}" 
                            href="{{ route('events.create') }}">
                            {{ __('Create new event') }}
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->route()->getName() == 'events.index' ? 'active' : '' }}" 
                            href="{{ route('events.index') }}">
                            {{ __('Your events') }}
                        </a>
                    </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li>
                        <a class="nav-link {{ request()->route()->getName() == 'login' ? 'active' : '' }}" 
                        href="{{ route('login') }}">
                            {{ __('Login') }}
                        </a>
                    </li>
                    <li>
                        <a class="nav-link {{ request()->route()->getName() == 'register' ? 'active' : '' }}" href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->nick }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>