<style>
    /* Chat Widget Container */
    #ai-chat-widget-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        font-family: 'Inter', sans-serif;
    }

    /* Floating Button */
    #ai-chat-toggle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.25);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    #ai-chat-toggle:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    #ai-chat-toggle svg {
        color: white;
        width: 30px;
        height: 30px;
    }

    /* Chat Window */
    #ai-chat-window {
        display: none;
        /* Hidden by default */
        width: 350px;
        height: 500px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-radius: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
        flex-direction: column;
        overflow: hidden;
        position: absolute;
        bottom: 80px;
        right: 0;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
    }

    #ai-chat-window.open {
        display: flex;
        opacity: 1;
        transform: translateY(0);
    }

    /* Header */
    .chat-profile-header {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: white;
    }

    .chat-profile-info h4 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
    }

    .chat-profile-info p {
        margin: 0;
        font-size: 12px;
        opacity: 0.8;
    }

    #ai-close-btn {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 20px;
    }

    /* Messages Area */
    #ai-chat-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .message {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.4;
    }

    .message.user {
        align-self: flex-end;
        background: #6366f1;
        color: white;
        border-bottom-right-radius: 4px;
    }

    .message.bot {
        align-self: flex-start;
        background: #f3f4f6;
        color: #1f2937;
        border-bottom-left-radius: 4px;
        border: 1px solid #e5e7eb;
    }

    /* Typing Indicator */
    .typing-indicator {
        display: none;
        align-self: flex-start;
        background: #f3f4f6;
        padding: 8px 12px;
        border-radius: 12px;
        border-bottom-left-radius: 4px;
    }

    .typing-dot {
        display: inline-block;
        width: 6px;
        height: 6px;
        background: #9ca3af;
        border-radius: 50%;
        animation: typing 1.4s infinite;
        margin: 0 2px;
    }

    .typing-dot:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-dot:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-4px);
        }
    }

    /* Input Area */
    .chat-input-area {
        padding: 15px;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        background: rgba(255, 255, 255, 0.5);
        display: flex;
        gap: 10px;
    }

    #ai-chat-input {
        flex: 1;
        border: 1px solid #e5e7eb;
        border-radius: 20px;
        padding: 10px 15px;
        outline: none;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    #ai-chat-input:focus {
        border-color: #6366f1;
    }

    #ai-send-btn {
        background: #6366f1;
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div id="ai-chat-widget-container">
    <!-- Chat Window -->
    <div id="ai-chat-window">
        <div class="chat-profile-header">
            <div class="chat-profile-info">
                <h4>BI Assistant</h4>
                <p>Ask me about your data</p>
            </div>
            <button id="ai-close-btn">&times;</button>
        </div>

        <div id="ai-chat-messages">
            <div class="message bot">
                Hello! I can analyze your business data. Try asking: "Top 5 best selling products" or "Monthly sales".
            </div>
            <div class="typing-indicator" id="ai-typing">
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
            </div>
        </div>

        <div class="chat-input-area">
            <input type="text" id="ai-chat-input" placeholder="Ask a question..." autocomplete="off">
            <button id="ai-send-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </div>
    </div>

    <!-- Toggle Button -->
    <button id="ai-chat-toggle">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('ai-chat-toggle');
        const closeBtn = document.getElementById('ai-close-btn');
        const chatWindow = document.getElementById('ai-chat-window');
        const input = document.getElementById('ai-chat-input');
        const sendBtn = document.getElementById('ai-send-btn');
        const messagesContainer = document.getElementById('ai-chat-messages');
        const typingIndicator = document.getElementById('ai-typing');

        // Toggle Chat
        function toggleChat() {
            chatWindow.classList.toggle('open');
        }

        toggleBtn.addEventListener('click', toggleChat);
        closeBtn.addEventListener('click', toggleChat);

        // Send Message
        async function sendMessage() {
            const text = input.value.trim();
            if (!text) return;

            // Add user message
            addMessage(text, 'user');
            input.value = '';

            // Show typing
            typingIndicator.style.display = 'block';
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            try {
                const response = await fetch('<?php echo $URL; ?>/public/api/chat_handler.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ message: text })
                });

                const data = await response.json();

                // Hide typing
                typingIndicator.style.display = 'none';

                if (data.answer) {
                    addMessage(data.answer, 'bot');
                } else if (data.error) {
                    addMessage('Error: ' + data.error, 'bot');
                } else {
                    addMessage('Something went wrong.', 'bot');
                }

            } catch (error) {
                typingIndicator.style.display = 'none';
                addMessage('Network error. Please try again.', 'bot');
                console.error(error);
            }
        }

        function addMessage(text, sender) {
            const div = document.createElement('div');
            div.className = `message ${sender}`;
            div.innerHTML = text; // Allow HTML from backend
            messagesContainer.insertBefore(div, typingIndicator);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Event Listeners
        sendBtn.addEventListener('click', sendMessage);
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') sendMessage();
        });
    });
</script>