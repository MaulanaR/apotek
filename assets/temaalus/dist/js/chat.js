/* 
Created by: Kenrick Beckett

Name: Chat Engine
*/

var instanse = false;
var state;
var mes;
var file;
var base_url = window.location.hostname ;

function Chat () {
    this.update = updateChat;
    this.send = sendChat;
	this.getState = getStateOfChat;
}

//gets the state of the chat
function getStateOfChat(tipe,tipedua){
	if(!instanse){
		 instanse = true;
		 $.ajax({
			   type: "POST",
			   url: "/fhk/chat/proces_chat",
			   data: {  
			   			'function': 'getState',
						'file': file,
						'tipe': tipe,
						'tipedua': tipedua
						},
			   dataType: "json",
			
			   success: function(data){
				   state = data.state;
				   instanse = false;
				   if(data.text){
						for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                        }								  
				   }
				   document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
			   },
			});
	}	 
}

//Updates the chat
function updateChat(tipe,tipedua){
	     $.ajax({
			   type: "POST",
			   url: "/fhk/chat/proces_chat",
			   data: {  
			   			'function': 'update',
						'state': state,
						'tipe': tipe,
						'tipedua': tipedua,
						'file': file
						},
			   dataType: "json",
			   success: function(data){
				   if(data.text){
						for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($("<p>"+ data.text[i] +"</p>"));
                        }								  
				   }
				   document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				   instanse = false;
				   state = data.state;
			   },
			});
}

//send the message
function sendChat(message, nickname, tipe,tipedua)
{       
    updateChat();
     $.ajax({
		   type: "POST",
		   url: "/fhk/chat/proces_chat",
		   data: {  
		   			'function': 'send',
					'message': message,
					'nickname': nickname,
					'file': file,
					'tipe': tipe,
					'tipedua': tipedua
				 },
		   dataType: "json",
		   success: function(data){
			   updateChat();
		   },
		});
}
