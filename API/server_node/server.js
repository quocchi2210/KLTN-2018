var fs = require('fs');

var options = {
	key: fs.readFileSync('/etc/letsencrypt/live/luxexpress.cf/privkey.pem'),
	cert: fs.readFileSync('/etc/letsencrypt/live/luxexpress.cf/fullchain.pem')
};

var app = require('https').createServer(options);
var io = require('socket.io').listen(app);
app.listen(6001);

