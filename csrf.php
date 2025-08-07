<?php
session_start();

function GenerateCsrfToken(){
    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token']=bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
?>