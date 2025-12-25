document.addEventListener('DOMContentLoaded', function() {
    const messagesButton = document.getElementById('open-messages-sidebar');
    const messagesSidebar = document.getElementById('messages-sidebar');
    const closeMessagesButton = document.getElementById('close-messages-sidebar');
    const messagesIframe = document.getElementById('messages-iframe');

    messagesButton.addEventListener('click', function(event) {
        event.preventDefault();
        messagesSidebar.classList.add('show');
    });

    closeMessagesButton.addEventListener('click', function() {
        messagesSidebar.classList.remove('show');
    });
});
