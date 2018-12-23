var fs = require('fs');

var options = {
    key: fs.readFileSync('/etc/letsencrypt/live/luxexpress.cf/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/luxexpress.cf/fullchain.pem')
};

var app = require('https').createServer(options);
var io = require('socket.io').listen(app);
app.listen(6001);

// var Redis = require('ioredis')
// var redis = new Redis(1000)
// redis.psubscribe("*",function(error,count){
// 	//
// })
// redis.on('pmessage',function(partner,channel,message){
// 	console.log(channel)
// 	console.log(message)
// 	console.log(partner)

// 	message = JSON.parse(message)
// 	io.emit(channel+":"+message.event,message.data.message)
// 	console.log('Sent')
// })

