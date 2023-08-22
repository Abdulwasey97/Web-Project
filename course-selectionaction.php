<?php 
session_start();
include("includes/config.php");
include("includes/common.php");
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {    
    if ($_SESSION['type'] == 'teacher') {
      
        if (isset($_POST["id"]) && isset($_POST["fullname"]) && isset($_POST["course"])) {
            $fullname = sanitizeInput($_POST["fullname"]);
            $id = sanitizeInput($_POST["id"]);
            $course = sanitizeInput($_POST["course"]);
            $_SESSION["subject"] = $course;

            $conn = connect($host, $dusername, $dpassword, $database);

            // Prepare and bind the parameters
            $stmt = $conn->prepare("INSERT INTO `course-selection` (instructorid, instructor, subjectname) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $id, $fullname, $course);

            // Execute the statement
            if ($stmt->execute()) {
             header("location:course-selection.php?msg=DI");
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            header("Location: course-selection.php?msg=SC");
        }
    } else {
        header("Location: student-dashboard.php");
        exit();
    }
   
} else {
    header("Location: index.php?msg=UAA");
    exit();
}
?>
