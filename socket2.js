var base_path = __dirname.replace('./', '');

require('dotenv').config({
  path: base_path +'/.env'
});

var
  env = process.env,
  port = env.NODE_SERVER_PORT,
  redis = require('ioredis'),
  redis_client = new redis(),
  redis_broadcast = new redis(),
  cookie = require('cookie'),
  crypto = require('crypto'),
  PHPUnserialize = require('php-unserialize'),
  fs = require('fs'),
  server = null,
  offline_timeout = {},
  users = {};

if(env.APP_ENV == 'production') {
  console.log = function(){};
}

redis_broadcast.psubscribe('*', function(err, count) {
  console.log('psubscribe', count);
});

redis_broadcast.on('pmessage', function(subscribed, channel, message) {
  message = JSON.parse(message);
  //io.emit(channel, message.data);

  //console.log('io.sockets.connected', io.sockets.connected);
  var keys = Object.keys(io.sockets.connected);
  keys.forEach(function (key){
    var _socket = io.sockets.connected[key];
    if(channel == 'yourAction' && _socket.user_id == 3){
      io.to(key).emit(channel, message.data);
      console.log('emit', _socket.user_id, key, channel);
    }
    console.log('_socket.user_id', _socket.user_id, key, channel);
  });

  //console.log('users', users);
  //console.log('pmessage', subscribed, channel, message);
});

if(env.NODE_HTTPS == 'on') {
  server = require('https').createServer({
    key: fs.readFileSync(env.SSL_KEY),
    cert: fs.readFileSync(env.SSL_CERT)
  });
} else {
  server = require('http').createServer();
}
console.log('Server on Port : ' + port);
server.listen(port);
var io = require('socket.io')(server);

io.use(function(socket, next) {

  if(typeof socket.request.headers.cookie != 'undefined') {
    console.log('cookie is ', socket.request.headers.cookie);
    var cookieObj = cookie.parse(socket.request.headers.cookie);
    console.log('cookieObj is ', cookieObj);
    var laravelSession = cookieObj.laravel_session;
    if(laravelSession){
      redis_client.get('laravel:' + decryptCookie(laravelSession), function(error, result) {
        if (error) {
          console.log('ERROR');
          next(new Error(error));
        }
        else if (result) {
          console.log('Logged In', result);
          next();
        }
        else {
          console.log('Not Authorized');
          next(new Error('Not Authorized'));
        }
      });
    }
  } else {
    console.log('Not Authorized');
    next(new Error('Not Authorized'));
  }
});

io.on('connection', function (socket) {

  socket.on('user_info', function (user_info) {

    clearTimeout(offline_timeout[user_info.id]);

    if(!users[user_info.id]) {
      socket.user_id = user_info.id;
      users[user_info.id] = {
        location: user_info.location
      };
    }
    else {
      socket.leave(users[user_info.id].location);
      users[user_info.id].location = user_info.location;
    }

    console.log('user joined '+user_info.location);

    socket.join(user_info.location);
  });

  socket.on('disconnect', function () {
    if (socket.user_id) {
      offline_timeout[socket.user_id] = setTimeout(
        function() {
          console.log('user ' + socket.user_id + ' disconnected');
          delete users[socket.user_id]
        }, 15000
      );
    }
  });
});

function decryptCookie(cookie)
{
  console.log('decryptCookie', cookie);

  var parsedCookie = JSON.parse(new Buffer(cookie, 'base64'));

  var iv = new Buffer(parsedCookie.iv, 'base64');
  var value = new Buffer(parsedCookie.value, 'base64');

  var decipher = crypto.createDecipheriv('aes-256-cbc', env.APP_KEY, iv);

  var resultSerialized = Buffer.concat([
    decipher.update(value),
    decipher.final()
  ]);

  var ret = PHPUnserialize.unserialize(resultSerialized);
  console.log('parsed is ', ret);
  return ret;
}
