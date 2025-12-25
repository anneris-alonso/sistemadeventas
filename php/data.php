<?php
while ($row = mysqli_fetch_assoc($query)) {
    $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['id_usuario']} // id_usuario
                OR outgoing_msg_id = {$row['id_usuario']}) AND (outgoing_msg_id = {$outgoing_id}
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
    $query2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($query2);
    (mysqli_num_rows($query2) > 0) ? $result = $row2['msg'] : $result = "No hay mensajes disponibles";
    (strlen($result) > 28) ? $msg =  substr($result, 0, 28) . '...' : $msg = $result;
    if (isset($row2['outgoing_msg_id'])) {
        ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "Tu: " : $you = "";
    } else {
        $you = "";
    }
    ($row['status'] == "Fuera de Línea") ? $offline = "offline" : $offline = ""; //  "status" column doesn't exist in tb_usuarios.
    ($outgoing_id == $row['id_usuario']) ? $hid_me = "hide" : $hid_me = ""; // id_usuario


    $output .= '<div class="content"> <img src="php/images/default.png" alt="">
                    <div class="details">
                        <span>' . $row['nombres'] . '</span> 
                        <p>' . $you . $msg . '</p>
                    </div>
                    </div>
                    <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                </a>';
}
