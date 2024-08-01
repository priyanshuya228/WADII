<?php 
include_once "connection.inc.php";

if(isset($_SESSION["USER_ID"]) && isset($_POST['incomingid'])){
    $outgoing_id = $_SESSION["USER_ID"];
    $incoming_id = intval($_POST['incomingid']);
    $output = "";

    $sql = "SELECT * FROM messages 
            LEFT JOIN users ON users.id = messages.outgoing_msg_id
            WHERE (outgoing_msg_id = ? AND incoming_msg_id = ?)
            OR (outgoing_msg_id = ? AND incoming_msg_id = ?) 
            ORDER BY msg_id";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){

            $message = htmlspecialchars($row['msg']);
            
            if($row['outgoing_msg_id'] == $outgoing_id){
                $output .= '<div class="chat outgoing">
                            <div class="details">
                                <p>'. $message .'</p>
                            </div>
                            </div>';
            }else{
                $output .= '<div class="chat incoming">
                            <div class="details">
                                <p>'. $message .'</p>
                            </div>
                            </div>';
            }
        }
    }else{
        $output .= '<div class="text">No messages are available. Once you send a message, they will appear here.</div>';
    }

    echo $output;
}
?>
