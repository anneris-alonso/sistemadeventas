<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['id_usuario'])) { 
  header("location: login.php");
}
?>
<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $sql = mysqli_query($conn, "SELECT * FROM tb_usuarios WHERE id_usuario = {$user_id}");
        if (mysqli_num_rows($sql) > 0) {
          $row = mysqli_fetch_assoc($sql);
        } else {
          header("location: users.php");
        }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['nombres'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
         <button id="toggle-gemini-sidebar">Gemini</button>
      </header>
        <div id="existing-chats">
          </div>
      <div class="chat-box">
           <div id="chat-container" class="chat-container"></div>
      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" id="message-input" class="input-field" placeholder="Escribe tu mensaje aquí..." autocomplete="off">
        <button id="send-message"><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
    <aside class="gemini-sidebar">
        <div class="chat-header">
            <h3>Gemini Chat</h3>
            <button id="close-gemini-sidebar">Close</button>
        </div>
        <div id="gemini-chat-container" class="gemini-chat-container">
        </div>
        <div class="message-input-area">
            <input type="text" id="gemini-message-input" placeholder="Escribe tu mensaje...">
            <button id="send-gemini-message">Enviar</button>
        </div>
    </aside>
      <aside class="chat-sidebar">
          <div class="chat-header">
              <h3>Chats</h3>
              <button id="close-chat-sidebar">Close</button>
          </div>
      </aside>
  </div>
  <script>
  var globalURL = "";
  </script>
  <script src="javascript/chat.js"></script>

</body>

</html>
