<?php
// session_start() remove koro - already config/db.php e start hoye geche

if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = 'Guest';
}

function getUserId(){
    return $_SESSION['user_id'];
}
?>