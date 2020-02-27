(function() {
    //Get elements 
    var status = getNode('.chatstatus span'),
        messages = getNode('.chatmsgs'),
        textarea = getNode('.chat textarea'),
        chatname = getNode('.chatname'),
        chatIcons = document.querySelectorAll('i.startChat'),
        
        //Get default chatstatus HTML text
        statusDefault = status.textContent,
        
        setStatus = function(s) {
            status.textContent = s;
            if (s !== statusDefault){
                var delay = setTimeout(function() {
                setStatus(statusDefault);
                clearInterval(delay);
                }, 3000);
            }
        }
    ;
    
    try{
        //var port = 8080;
        //var socket = io('http://127.0.0.1:8080'); //Main namespace
        //var chatSocket = io(window.location.hostname +':'+ port +'/chat'); //Chat namespace
        var chatSocket = io('/chat'); //Chat namespace

    }catch(e){
        //Set status to warn user
        console.log('ERR ERR ERR:\n'+e);
    }
    

  if(chatSocket !== undefined) {
    //Emit socket.io room with custom id
    var chatting = false;
    //Declare var  myRoom = "md5($_SESSION['email'])" in myprofile.php
    chatSocket.emit('join', {myRoom});
    
    function requestChat(roomToJoin){
        //Request to connect to private chat room onclick
        chatSocket.emit('sendChatRequest', {
            name: chatname.value.charAt(0).toUpperCase() + chatname.value.slice(1),
            message: 'You are now connected with ',
            roomToJoin,
            senderRoom: myRoom
        });
    }

    for( var i = 0; i < chatIcons.length; i++){
        //Add chat event handler to msg icon
        var chatIcon = chatIcons[i];
        addEventHandler(chatIcon, 'click', function(e) {
            !chatting ? requestChat(e.target.id) : alert('Please, disconnect from the current chat before sending a chat request.');
        });
    }

    chatSocket.on('chatRequestRec', function(data){
        //Get recipient's response
        var recipient = getId(data.senderRoom+'_name').innerText;
        var acceptReq = confirm('Would you like to chat with' + recipient + '?');
        if (acceptReq) {
            chatting = true;
            chatSocket.emit('acceptChat', data);
        } else {
            chatSocket.emit('abortChat', data);
        }
    });

    //Reject request
    chatSocket.on('abortChat', function(data){
        var recipient = getId(data.roomToJoin+'_name').innerText;
        alert('Sorry, your request to chat with'+recipient+' was denied.')
    });

    //Accept request
    chatSocket.on('connectChat', function(data){
        var recipient = getId(data.roomToJoin+'_name').innerText;
        alert('You will now be connected to'+recipient+'.')
        chatting = true;
        chatSocket.emit('connectChat', data)
    });
    
    chatSocket.on('outputDbMsgs', function(data){
        data.name = chatname.value.charAt(0).toUpperCase() + chatname.value.slice(1);
        chatSocket.emit('outputDbMsgs', data);
    });

    chatSocket.on('connectionStatus', function(data, connected, disconnect){
        var message = document.createElement('div');

        message.setAttribute('class', 'chatmsg connectmsg');
        message.textContent = !disconnect ? 
            data.message + data.name + '...' 
            : 
            data.name + data.message;
    
        //Append
        messages.appendChild(message); 
        messages.insertBefore(message, null);
        messages.scrollTop = messages.scrollHeight;
        
        
        !disconnect ?
            //If connecting, add button. If disconnecting remove it 
            addDisconnectBtn() 
            : 
            (function(){
                var btn = getNode('button.disconnect')
                btn.parentNode.removeChild(btn);
                chatting = false;
            })();
        data.name = chatname.value.charAt(0).toUpperCase() + chatname.value.slice(1);
        !connected ? chatSocket.emit('startChat', data) : '';
        
    });

    function addDisconnectBtn(){
        var disconnectBtn = document.createElement('button');

        disconnectBtn.setAttribute('class', 'disconnect');
        disconnectBtn.textContent = 'Disconnect';

        getNode('#disconnect').appendChild(disconnectBtn);
        addDisconnectListener(disconnectBtn);
        
    }

    //listen for keydown to emit msg to server 
    addEventHandler(textarea,'keyup', function(e) {
        var text = textarea.value.length;
        var name = chatname.value.charAt(0).toUpperCase() + chatname.value.slice(1)
        var key = e.which;
        var valid = 
            (key > 47 && key < 58)   || // number keys
            key == 32 || key == 13   || key == 8 || // spacebar & return key(s) (if you want to allow carriage returns)
            (key > 64 && key < 91)   || // letter keys
            (key > 95 && key < 112)  || // numpad keys
            (key > 185 && key < 193) || // ;=,-./` (in order)
            (key > 218 && key < 223);   // [\]' (in order)
        if(valid && chatting){
            if(e.which === 13 && e.shiftKey === false && text > 0) {	
                chatSocket.emit('input', {
                    name,
                    message: this.value
                });
                e.preventDefault();
            }
            //When user begins typing, notify other user that they are typing
            else if (e.which !== 13 && e.which !== 8 && e.which >0 && text == 1) {	
                chatSocket.emit('inputStatus', {
                    name
                });	
            }
            else if (e.which == 8 && text == 0) {	
                chatSocket.emit('clearOutputStatus')
            }
        }
    });

    function addDisconnectListener(disconnectBtn) {
        addEventHandler(disconnectBtn, 'click',function(){
            var disconnect = confirm('Are you sure you want to disconnect from current chatroom?');
            disconnect ? chatSocket.emit('disconnectChat', {
                name: chatname.value.charAt(0).toUpperCase() + chatname.value.slice(1), 
                message: this.name + ' has left the chat.',
                connected: false, 
                disconnect: true
            }) : ''; 
        });
    }

    chatSocket.on('disconnectChat', function(data) {
        chatSocket.emit('disconnectChat', data);
    }) 

    //Listen for output chatSocket (msg received)
    chatSocket.on('output', function(data, db) {
        if(data.length) {
            //Loop thru results from database
            for(var i = 0; i < data.length; i++) {
                var message = document.createElement('div');
                var nameSpan = document.createElement('span');
                //Set classes
                message.setAttribute('class', 'chatmsg');
                nameSpan.setAttribute('class', 'msgName');
                nameSpan.textContent = data[i].name+ ': ';
                //Append name and text to div
                message.appendChild(nameSpan);
                message.appendChild(document.createTextNode(data[i].message));
                    
                //Append chat msg to chat box 
                (db && i==0) ? messages.innerHTML = '' : ''; // Clear chatBox before db msgs added
                messages.appendChild(message); 
                messages.insertBefore(message, null);
                messages.scrollTop = messages.scrollHeight; // Re-position scrollHeight to bottom
            }
        } else {messages.innerHTML = ''}
    });

    chatSocket.on('outputStatus', function(data){
        var message = document.createElement('div');
        message.setAttribute('class', 'connectmsg outputStatus_'+data.name);
        message.setAttribute('id', 'outputStatus');
        message.textContent = data.name + (data.text || ' is typing...');
        //Append
        messages.appendChild(message); 
        messages.insertBefore(message, null);
        messages.scrollTop = messages.scrollHeight;
    });

    chatSocket.on('clearOutputStatus', function(){
        var outputStatus = getId('outputStatus');
        if (outputStatus !== null) {
            outputStatus.parentNode.removeChild(outputStatus);
            messages.scrollTop = messages.scrollHeight;
        };
    })

    //Listen for a status chatSocket for updated status
    chatSocket.on('status', function(data) {
        //Update status depending on object or string received
        setStatus(typeof data === 'object' ? data.message : data);
        
        if(data.clear === true) {
            textarea.value = '';
        }
    });

  }
})();