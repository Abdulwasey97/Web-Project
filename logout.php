<?php 
session_start();
include("includes/config.php");
include("includes/common.php");
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    session_start();
        if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-86400, '/');
        }
        session_destroy();
    header("Location: index.php?msg=SLO");
    
    exit;
} else {
  header("Location:index.php?msg=UAA");
    
}
?>
