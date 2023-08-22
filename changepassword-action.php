<?php 
session_start();
include("includes/config.php");
include("includes/common.php");

if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {    
    if (isset($_POST["password"]) && isset($_POST["cpassword"])) {
        $password = sanitizeInput($_POST["password"]);
        $cpassword = sanitizeInput($_POST["cpassword"]);
        $phonenumber = sanitizeInput($_POST["phonenumber"]);
      
        $passwordcheck = false;
        if ($password == $cpassword) {
            $passwordcheck = true;
        }

        if (!$passwordcheck) {
            header("location:changepassword.php?msg=PNM");
            exit();
        }

        $id = getid();
        $securepassword = password_hash($password, PASSWORD_DEFAULT);
        
        $conn = connect($host, $dusername, $dpassword, $database);

        $sql = "UPDATE persons SET password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        $stmt->bind_param('si', $securepassword, $id);
        if ($stmt->execute()) {
            session_destroy();
            header("location:index.php?msg=PC");
            exit();
        } else {
            header("Location: index.php?msg=NF");
            exit();
        }
    } else {
        // Handle the case when required form fields are not set
    }
} else {
    header("location:index.php?msg=UAA");
    exit();
}
?>
