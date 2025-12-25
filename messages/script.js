function sendMessage(){
	const userInput = document.getElementById('user-input').value.trim();

    if (userInput === "") return;

    const chatBox = document.getElementById('chat-box');
    // append user message
    const userMessage = document.createElement('div');
    userMessage.className = 'user-message';
    userMessage.textContent = userInput;
    chatBox.appendChild(userMessage);

    fetch("chatbot.php", {
    	method: 'POST',
    	headers: {'Content-Type': 'application/json'},
    	body: JSON.stringify({message: userInput})
    }).then(respose=> respose.json())
      .then(data => {
      	const botMessage = document.createElement('div');
      	botMessage.className = 'bot-message';
        botMessage.textContent = data.error ? `Bot: ${data.error}`:  `Bot: ${data.response}`;
       chatBox.appendChild(botMessage);
       document.getElementById('user-input').value='';
       chatBox.scrollTop = chatBox.scrollHeight;
    }).catch(error=> {
    	const errorMessage = document.createElement('div');
      	errorMessage.className = 'bot-message';
        errorMessage.textContent = 'Bot: Failed to fetch  respose.';
       chatBox.appendChild(errorMessage);
    });
}

// Voice Recognition
const microphoneButton = document.getElementById('microphone-button');
const userInputField = document.getElementById('user-input');

// Check if the browser supports the Web Speech API
if ('webkitSpeechRecognition' in window) {
    const recognition = new webkitSpeechRecognition();
    recognition.continuous = false; // Set to true for continuous recognition
    recognition.lang = 'es-ES'; // Set the language

    recognition.onstart = function() {
        microphoneButton.classList.add('recording'); // Add a class to indicate recording
        console.log('Voice recognition started.');
    };

    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        userInputField.value = transcript;
        console.log('Transcript:', transcript);
    };

    recognition.onerror = function(event) {
        console.error('Recognition error:', event.error);
    };

    recognition.onend = function() {
        microphoneButton.classList.remove('recording'); // Remove the class when recording ends
        console.log('Voice recognition ended.');
    };

    microphoneButton.addEventListener('click', function() {
        recognition.start();
    });
} else {
    microphoneButton.disabled = true;
    microphoneButton.title = 'Voice recognition not supported in this browser.';
    console.error('Voice recognition not supported in this browser.');
}

