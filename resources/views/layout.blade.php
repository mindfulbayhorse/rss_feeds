<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<title>@yield('title','Laracast')</title>
</head>
<body>
    <div id="rss_app">
         <div class="shortcut">
            <div class="profile">
                <dropdown>
                    <template v-slot:trigger>
                        <button title="{{ auth()->user()->name }}"></button>
                    </template>
                    
                    <a href="/profile">Profile</a>
                    <a href="/settings">Settings</a>
                    <a href="">Logout</a>
                </dropdown>
    
            </div>
        </div>
        <div class="wide_screen" id="app">
            @hasSection('left_sidebar')
                    @yield('left_sidebar')
            @endif
             
            <div class="center_part">
                @hasSection('breadcrumbes')
                    @yield('breadcrumbes')
                @endif
                <h1>@yield('title')</h1>
            
            
                  @yield('content')
                    
            </div>
    
        </div>
    
    </div>
<script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
</body>
</html>
