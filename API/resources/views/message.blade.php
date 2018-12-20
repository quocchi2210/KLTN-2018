<html>

<head>
    <title>Demo chat</title>
</head>
<body>

    <div>
        <form action="send-message" method="POST">
        {{csrf_field()}}
        Name: <input type="text" name="author">
        <br>
        <br>
        Content: <textarea name="content" rows="5" style="width:100%"></textarea>
        <button type="submit" name="send">Send</button>
        </form>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.1/socket.io.js"></script>
        <script>

        var socket = io('https://35.237.188.74:6001');
        socket.on('chat:message',function(data){
            console.log(data)
            $('body').append('<p>'+data+'</p>')
            // if($('#'+data.id).length == 0){
            //
            // }
            // else{
            //     console.log('Đã có tin nhắn')
            // }
        })

        </script>
    </div>
</body>

</html>
