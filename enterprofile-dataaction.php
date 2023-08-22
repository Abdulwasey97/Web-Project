<?php
session_start();
include("includes/config.php");
include("includes/common.php");

if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if (isset($_POST["age"]) && isset($_POST["address"]) && isset($_POST["phonenumber"])) {
        $age = sanitizeInput($_POST["age"]);
        $address = sanitizeInput($_POST["address"]);
        $phonenumber = sanitizeInput($_POST["phonenumber"]);

        $conn = connect($host, $dusername, $dpassword, $database);

        $id = getid();

        $sql = "UPDATE persons SET age=?, address=?, phonenumber=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        $stmt->bind_param('issi', $age, $address, $phonenumber, $id);
        if ($stmt->execute()) {

        } else {
            header("Location: index.php?msg=NF");
            $statusMsg = 'Error updating profile: ' . $stmt->error;
        }

        if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
            $img_name = $_FILES['file']['name'];
            $img_size = $_FILES['file']['size'];
            $tmp_name = $_FILES['file']['tmp_name'];
            $error = $_FILES['file']['error'];

            if ($error === 0) {
                if ($img_size > 1000000) {
                    header("Location: update-profile.php?msg=FL");
                    exit();
                } else {
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);

                    $allowed_exs = array("jpg", "jpeg", "png");

                    if (in_array($img_ex_lc, $allowed_exs)) {
                        $img_upload_path = 'uploads/' . $img_name;
                        if (move_uploaded_file($tmp_name, $img_upload_path)) {
                            $update_picture_sql = "UPDATE persons SET pictureurl=? WHERE id=?";
                            $stmt = $conn->prepare($update_picture_sql);
                            if ($stmt === false) {
                                trigger_error('Wrong SQL: ' . $update_picture_sql . ' Error: ' . $conn->error, E_USER_ERROR);
                            }
                            $stmt->bind_param('si', $img_name, $id);
                            if ($stmt->execute()) {
                                header("Location: view_profile.php?msg=DI");
                            } else {
                                header("Location: update-profile.php?msg=FNU");
                                
                            }
                        } else {
                            header("Location: update-profile.php?msg=EMF");
                    
                        }
                    } else {
                        header("Location: update-profile.php?msg=EXT");
                   
                    }
                }
            } else {
                header("Location: update-profile.php?msg=UPI");
        
            }
        } else {
            header("Location: update-profile.php?msg=NF");
          
        }
    } else {
      header("Location: update-profile.php?msg=Fileerror");
    }
} else {
    header("location:index.php?msg=UAA");
}
?>
