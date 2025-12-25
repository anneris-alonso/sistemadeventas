const form = document.querySelector(".typing-area"),
incoming_id = form.querySelector(".incoming_id").value,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-box");



form.onsubmit = (e)=>{
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = ()=>{
    if(inputField.value != ""){
        sendBtn.classList.add("active");
    }else{
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              inputField.value = "";
              scrollToBottom();
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
chatBox.onmouseenter = ()=>{
    chatBox.classList.add("active");
}

chatBox.onmouseleave = ()=>{
    chatBox.classList.remove("active");
}

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
                scrollToBottom();
              }
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id="+incoming_id);
}, 500);

function scrollToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
  }
  
// ... other code in chat.js

// Inside the fetchUsers function, modify the output creation:
const existingChatsUL = document.getElementById('existing-chats');
            output.forEach(user => {
                const li = document.createElement('li');
                li.innerHTML = `
                    <a href="chat.php?user_id=${user.id_usuario}" class="chat-link">  </a>`; // Added the href

                existingChatsUL.appendChild(li);

                 li.addEventListener('click', function(event) {

                    // Prevent default link behavior to handle with AJAX
                    event.preventDefault();

                    // Hide the sidebar (or do other actions as needed)
                    chatSidebar.style.display = 'none';



                    // Get the user_id from the link
                    const userId = this.querySelector('a').href.split('=')[1];

                    // Redirect to chat.php
                    window.location.href = `chat.php?user_id=${userId}`;




            });



                fetchUsers();
            });
