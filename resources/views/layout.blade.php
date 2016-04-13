<!DOCTYPE HTML>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>My Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>
    @include('navbar')
    <div class="container">
        @if (Session::has('flash_message'))
            <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
        @endif
        @yield('content')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <script>
        @if(\Auth::check())
            @if($app->environment() == 'local')
        if (localStorage.debug != 'socket.io-client:socket') {
            console.log('You must reload to see socket.io messages!');
            localStorage.debug='socket.io-client:socket';
        }
            @endif

        var socket = io.connect('{{ url("/") }}:{{ env('NODE_SERVER_PORT') }}');

        console.log('user_info with', '{{ Auth::user()->id }}', "{{ \Request::url() }}");

        socket.emit('user_info', {
            id: '{{ Auth::user()->id }}',
            location: "/"
        });

        socket.on("yourAction", function(data) {

            console.log('yourAction', data);

        });
        @endif
    </script>
</body>
</html>
