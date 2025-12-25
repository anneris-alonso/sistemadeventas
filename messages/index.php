<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CTRLV</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://kit.fontawesome.com/5dd1f4223f.js" crossorigin="anonymous"></script>
</head>
<body>
    <div id="chat-container">
        <div class="chat-header">
            <h2>CTRLV</h2>
                <button id="close-iframe-button"><i class="fas fa-cicle-rxmark"></i></button>
			
        </div>
        <div id="chat-box"></div>
        <div class="input-container">
		    <button id="microphone-button"><i class="fas fa-microphone"></i></button>
            <input type="text" id="user-input"  placeholder="Type your message...">
            <button id="send-button" onclick="sendMessage()">Send</button>
            
        </div>
    </div>
    <script type="text/javascript" src="script.js"></script>
    <script>
        document.getElementById('close-iframe-button').addEventListener('click', function() {
            parent.document.getElementById('close-messages-sidebar').click();
        });
    </script>
</body>
</html>
