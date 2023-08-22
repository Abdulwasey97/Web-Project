<?php 
session_start();
include("includes/config.php");
include("includes/common.php");

if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {    

    if (isset($_POST["fullname"])  && isset($_POST["email_address"])  && isset($_POST["age"]) && isset($_POST["address"]) && isset($_POST["phonenumber"])) {
        $fullname = sanitizeInput($_POST["fullname"]);
        
        $email = sanitizeInput($_POST["email"]);
        $age = sanitizeInput($_POST["age"]);
        $address = sanitizeInput($_POST["address"]);
        $phonenumber = sanitizeInput($_POST["phonenumber"]);
      
        $conn = connect($host, $dusername, $dpassword, $database);
    
        $id = getid();
        
        $sql = "UPDATE persons SET fullname=?, email=?, age=?, address=?, phone=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        $stmt->bind_param('ssissi', $fullname,  $email, $age, $address, $phonenumber, $id);
        if ($stmt->execute()) {
           
        } else {
            header("Location: update-profile.php?msg=UE");
        }
    
        // File upload handling
        if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
            $img_name = $_FILES['file']['name'];
            $img_size = $_FILES['file']['size'];
            $tmp_name = $_FILES['file']['tmp_name'];
            $error = $_FILES['file']['error'];
            
            if ($error === 0) {
                if ($img_size > 125000) {
                    $em = "Sorry, your file is too large.";
                    header("Location: index.php?error=$em");
                    exit();
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
            
                    $allowed_exs = array("jpg", "jpeg", "png");
            
                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                        $img_upload_path = 'uploads/'.$new_img_name;
                        move_uploaded_file($tmp_name, $img_upload_path);
            
                        // Update pictureurl in the database
                        $update_picture_sql = "UPDATE persons SET pictureurl=? WHERE id=?";
                        $stmt = $conn->prepare($update_picture_sql);
                        if ($stmt === false) {
                            trigger_error('Wrong SQL: ' . $update_picture_sql . ' Error: ' . $conn->error, E_USER_ERROR);
                        }
                        $stmt->bind_param('si', $new_img_name, $id);
                        if ($stmt->execute()) {
                            header("Location: view_profile.php?msg=PU");
                        } else {
                            header("Location: update-profile.php?msg=UE");
                        }
                    }
                }
            }
        }
        $stmt->close();
        $conn->close();
        header("Location: student-dashboard.php");
        exit();
    }else{
        header("Location: index.php?msg=UAA");
    }
}
?>
