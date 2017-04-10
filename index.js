var app = require('express')()
var server = require('http').createServer(app)
var socket = require( 'socket.io' )
var io = socket.listen( server )

io.on('connection', function(client){
  console.log('new client')
  client.on('message', function(data) {
    console.log('message received '+data.text+': ', data.user_id)
    io.sockets.emit('incoming', {text: data.text, user_id: data.user_id})
  })
})//listen

server.listen(8080, function(){
  console.log('listening on 8080')
})
