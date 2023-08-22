<?php 
session_start();
include("includes/config.php");
include("includes/common.php");

if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {   
    if (isset($_SESSION["teacher"]) && $_SESSION["teacher"]) {
        header("location: teacher-dashboard.php");
        exit();
    } else {
        $id = $_SESSION['id'];
        $fullname = sanitizeInput($_POST["fullname"]);
        $course1 = sanitizeInput($_POST["course1"]);
        $course2 = sanitizeInput($_POST["course2"]);
        $course3 = sanitizeInput($_POST["course3"]);
        $course4 = sanitizeInput($_POST["course4"]);
        $course5 = sanitizeInput($_POST["course5"]);
        $conn = connect($host, $dusername, $dpassword, $database);

        $query = "INSERT INTO `teacher-selection` (id, stname, physics, chemistry, math, urdu, english) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "issssss", $id, $fullname, $course3, $course5, $course1, $course4, $course2);

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            header("Location: teacherselection.php?msg=DI");
        } else {
            header("Location: teacherselection.php?msg=DNI");
        }
    }
} else {
    header("Location: index.php?msg=UAA");
}
?>
