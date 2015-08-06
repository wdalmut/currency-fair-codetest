var redis = require('redis');
var app = require('http').createServer();
io = require('socket.io').listen(app);

app.listen(9090);

io.sockets.on('connection', function (socket) {
    subscribe = redis.createClient(undefined, "127.0.0.1");
    pub = redis.createClient(undefined, "127.0.0.1");

   socket.on("subscribe", function (channel) {
        subscribe.subscribe(channel);
        socket.emit("init", "woww");
    });

    socket.on('unsubscribe', function (obj) {
        subscribe.unsubscribe(obj.channel);
    });

    subscribe.on("message", function (channel, data) {
        socket.send(data);
    });
});
