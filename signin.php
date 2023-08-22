<?php 
session_start();
include("includes/config.php");
include("includes/common.php");

if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    header("Location: dashboard.php");
    exit;
} else {
    if (isset($_POST["username"]) && isset($_POST["password"])) {        
        $username = sanitizeInput($_POST["username"]);      
        $password = sanitizeInput($_POST["password"]);        
        
        $conn = connect($host, $dusername, $dpassword, $database);
        $sql = 'SELECT * FROM persons WHERE username = ?';
        $stmt = $conn->prepare($sql);
        
        if($stmt === false) {
            trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->error, E_USER_ERROR);
        }
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if($row) {
            $hashed_password = $row['password'];
            if (password_verify($password, $hashed_password)) {
                $_SESSION["signedin"] = true;
                $_SESSION["type"] = $row['profession'];
                $_SESSION["name"] = $row['fullname'];
                $_SESSION["id"] = $row['id'];
                setcookie("username", "$username", time() + 3800);
                if($_SESSION['type'] == 'student'){
                    header("Location: student-dashboard.php");
                } else {
                    header("Location: teacher-dashboard.php");
                }
                exit;
            } else {
                header("Location: index.php?msg=IPW");
                exit;
            }
        } else {
            header("Location: index.php?msg=IEA");
            exit;
        }
    } else {
        header("Location: index.php?msg=UUA");
        exit;
    }
}
?>
