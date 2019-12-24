/*
Made by Andy Wu.
Some websites that gave me insight:
(Sorry for listing, but Prof. Sproull failed to give me insights for module 6.)
http://psitsmike.com/2011/09/node-js-and-socket-io-chat-tutorial/
public_html/module6/chatroom/
*/

// Require the packages we will use:
var http = require("http"),
	socketio = require("socket.io"),
	fs = require("fs");

// Listen for HTTP connections.  This is essentially a miniature static file server that only serves our one file, client.html:
var app = http.createServer(function(req, resp){
	// This callback runs when a new connection is made to our HTTP server.
	
	fs.readFile("client.html", function(err, data){
		// This callback runs when the client.html file has been read from the filesystem.
		
		if(err) return resp.writeHead(500);
		resp.writeHead(200);
		resp.end(data);
	});
});
app.listen(3456);





// Initialize some values here that might be useful.

var users={};
var rooms = ['Room1','Room2','Room3'];
var password = ['','',''];
var creator = ['Admin','Admin','Admin'];
var usernames = {};
var corre_rooms = {};
var socketID = {};
var allSockets = {};
/*
The beginning of Socket.IO thing.
"So the key here is to use some Socket.IO tutorial. You know what I mean." -- Andy Wu
*/
// Do the Socket.IO magic:
var io = socketio.listen(app);
io.sockets.on("connection", function(socket){
	// This callback runs when a new Socket.IO connection is established.
	

	//Start here, my Andy.



		// Reference from the website listed above.========================	
	//PennApple!
	socket.on('adduser', function(username){
		// store the username in the socket session for this client
		socket.username = username;
		// store the room name in the socket session for this client
		socket.room = 'Room1';
		// add the client's username to the global list
		usernames[username] = username;
		allSockets[username] = socket;
		// send client to room 1
		socketID[username] = socket.id;
		socket.join('Room1');
		// echo to client they've connected
		socket.emit('updatechat', 'SERVER', 'you are now in Room1');
		 //socket.emit('updatechat', 'SERVER', 'you have connected to room1');
		// echo to room 1 that a person has connected to their room
		socket.broadcast.to('Room1').emit('updatechat', 'SERVER', username + ' has connected to this room');
			//Different from updateusers(), which gets all clients.
			/*
		socket.emit("getUsersInRoom",function(){
			var all = "";
			for(var result in allSockets){
				if(result.room==socket.room){
					all+="<div>"+result.username+"</div>";
				}
			}
			return all;
		});*/
		socket.emit('updaterooms', rooms, 'Room1');
		socket.emit('updateClientName',username);
		socket.emit('postRoom',socket.room);
		io.sockets.emit('updateusers', usernames);
		socket.emit('updatechat', 'SERVER', 'You are currently in :'+socket.room);
	});


/* 记得实现一下 Create New Room
Password, user，之类的
*/
//rooms, password, creator
socket.on("createNewRoom",function(roomName, pass){
	var sameName = 0;
	for(var i = 0; i < rooms.length;i++){
		if(rooms[i]==roomName)sameName++;
	}
	if (sameName==0){
	rooms.push(roomName);
	password.push(pass);
	creator.push(socket.username);
	io.sockets.emit('updateChatRoom1',rooms);
	}else{
		//We don't want to ruin the addition process.
		socket.emit('updatechat', 'SERVER', 'You cannot create two rooms with the same name; Old room is kept :'+roomName);
	}
});

/*  Switches rooms here.

*/
socket.on("switchRoom",function(realName){
	var roomNum = -1;
	for(var i = 0; i < rooms.length;i++){
	if(realName==rooms[i]){
		roomNum = i;
	}
}
if(password[roomNum]!=''){
		socket.emit("switchWithPassword",realName);
}else{
	
	socket.emit("clearChat","");
	var curr = socket.room;
	socket.room = realName;
	socket.leave(curr);
	socket.join(realName);
	socket.emit('updatechat', 'SERVER', 'you are now in '+realName);
		 //socket.emit('updatechat', 'SERVER', 'you have connected to room1');
		// echo to room 1 that a person has connected to their room
		socket.broadcast.to(realName).emit('updatechat', 'SERVER', socket.username + ' has connected to this room');
		socket.emit('updaterooms', rooms, realName);
		io.sockets.emit('updateusers', usernames);
		socket.emit('postRoom',socket.room);
		socket.emit("hideChatRoom","");
}
});

	socket.on("switchWithPassword1",function(name,passworda){
		var pos = -1;
		for(var i =0; i <  rooms.length; i++){
		if(rooms[i]==name){
			pos = i;
		}
		if(password[i]==passworda){
			socket.emit("clearChat","");
	var curr = socket.room;
	socket.room = name;
	socket.leave(curr);
	socket.join(name);
	socket.emit('updatechat', 'SERVER', 'you are now in '+name);
		 //socket.emit('updatechat', 'SERVER', 'you have connected to room1');
		// echo to room 1 that a person has connected to their room
		socket.broadcast.to(name).emit('updatechat', 'SERVER', socket.username + ' has connected to this room');
		socket.emit('updaterooms', rooms, name);
		io.sockets.emit('updateusers', usernames);
		socket.emit('postRoom',socket.room);
		socket.emit("hideChatRoom","");
		}else{
			socket.emit('updatechat', 'SERVER', 'Incorrect PASSWORD!');
		}
	}
	});


	//Private Messages are here.
	socket.on("privateMessage", function(to, message){
		var newMessage = "Private Message from "+ socket.username + ": " + message;
		socket.broadcast.to(socketID[to]).emit('privateMessage1', newMessage);
	});


socket.on("getName",function(emptyName){
	var name = socket.username;
	var room = socket.room;
	var pos  = -1; 
	for(var i = 0; i < rooms.length;i++){
		if(room==rooms[i])pos = i;
	}
	var res = "false";
	if(pos!=-1){
		if(creator[pos]==name)res =  "true";
	}
	socket.emit("getName1",res);
})



	//End of Reference.====================================================

	socket.on('message_to_server', function(data) {
		// This callback runs when the server receives a new message from the client.
		
		console.log("message: "+data["message"]); // log it to the Node.JS output
		io.sockets.to(socket.room).emit("message_to_client",{message:socket.username+": " + data["message"] }) // broadcast the message to other users
	});


		///////////////
		socket.on('updateChatRoom',function(){
			io.sockets.emit('updateChatRoom1',rooms);
		});

		socket.on("banUser", function(username){
			if (io.sockets.connected[socketID[username]]) {
				socket.broadcast.to(socket.room).emit('updatechat', 'SERVER', username + ' has been banned from this room');
				let socketN = io.sockets.connected[socketID[username]];
				socketN.emit("banUser1", socket.room);
				socketN.leave(socketN.room);
				socketN.room = "Room1";
				socketN.emit('postRoom',socketN.room);
				socketN.join("Room1");
				//io.sockets.connected[socketID[username]].disconnect();
			}
			
		});


		socket.on("exterminateUser", function(username){
			if (io.sockets.connected[socketID[username]]) {
				socket.broadcast.to(socket.room).emit('updatechat', 'SERVER', username + ' has been exterminated from this webpage');
				io.sockets.connected[socketID[username]].disconnect();
			}
			
		});

		socket.on("kickUser", function(username){
			if (io.sockets.connected[socketID[username]]) {
				socket.broadcast.to(socket.room).emit('updatechat', 'SERVER', username + ' has been kicked out from this room');
				//Similar to switch
				//socket1.emit("kickUser1",username);
				let socketN = io.sockets.connected[socketID[username]];
				socketN.leave(socketN.room);
				socketN.room = "Room1";
				socketN.emit('postRoom',socketN.room);
				socketN.join("Room1");
			}
			
		});

/*
		socket.on("kickUser2", function(username,roomName){
			if (io.sockets.connected[socketID[username]]) {
				socket.broadcast.to(socket.room).emit('updatechat', 'SERVER', username + ' has been kicked out from this room');
				//Similar to switch
				socket1.emit("kickUser1",username);
			}
			
		});
*/
//Reference from the uppermost passage.
		socket.on('disconnect', function(){
			delete usernames[socket.username];
			// update list of users in chat, client-side
			io.sockets.emit('updateusers', usernames);
			// echo globally that this client has left
			if(socket.username!=null){
			socket.broadcast.emit('updatechat', 'SERVER', socket.username + ' has disconnected');
			}
		});
//End of reference.
		///////////////
	//end here, my Andy.


});