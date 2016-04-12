@extends('broadcast.master')

@section('content')
    <p id="power">0</p>
@stop

@section('footer')
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
    <script>
        //var socket = io('http://localhost:3000');
        var socket = io('http://192.168.33.40:3000');
        socket.on("test-channel:App\\Events\\TestEvent", function(message){
            // increase the power everytime we load test route
            $('#power').text(parseInt($('#power').text()) + parseInt(message.data.power));
        });
    </script>
@stop
