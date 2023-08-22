<?php
session_start();
include("includes/config.php");
include("includes/common.php");

if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if ($_SESSION['type'] == 'student') {
        header("Location: student-dashboard.php");
        exit;
    } else {
        header("Location: teacher-dashboard.php");
        exit;
    }
} else {
    $id=getid();
    if (isset($_POST["fullname"]) && isset($_POST["username"]) && isset($_POST["email_address"]) && isset($_POST["password"]) && isset($_POST["profession"])) {
        $fullname = sanitizeInput($_POST["fullname"]);
        $username = sanitizeInput($_POST["username"]);
        $email = sanitizeInput($_POST["email_address"]);
        $password = sanitizeInput($_POST["password"]);
        $securepassword = password_hash($password, PASSWORD_DEFAULT);
        $profession = sanitizeInput($_POST["profession"]);

        $conn = connect($host, $dusername, $dpassword, $database);

        // Check if the username already exists
        $checkUsernameQuery = 'SELECT * FROM persons WHERE username = ?';
        $checkStmt = $conn->prepare($checkUsernameQuery);
        $checkStmt->bind_param('i', $id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $conn->close();
            header("Location: signup.php?msg=UNE"); 
            exit;
        }

        // Insert new record if the username doesn't exist
        $insertQuery = 'INSERT INTO persons (fullname, username, email, password, profession) VALUES (?, ?, ?, ?, ?)';
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('sssss', $fullname, $username, $email, $securepassword, $profession);
        $insertStmt->execute();
       
        $conn->close();
        header("Location: index.php?msg=SRA"); // Redirect to login page with success message
        exit;
    } else {
        header("Location: signup.php?msg=UERR"); // Show error message if form fields are not set
        exit;
    }
}
?>
