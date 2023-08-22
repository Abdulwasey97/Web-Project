<?php
session_start();
include("includes/config.php");
include("includes/common.php");

if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if ($_SESSION['type'] == 'teacher') {
        header("Location: teacher-dashboard.php");
        exit();
    } else { 
        $id = getid();
        $conn = connect($host, $dusername, $dpassword, $database);

        if ($conn) {
            $deleteQuery = "DELETE FROM `teacher-selection` WHERE id = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id);
                mysqli_stmt_execute($stmt);

                $affectedRows = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);

                if ($affectedRows > 0) {
                    // Row deleted successfully
                    header("Location: teacherselection.php?msg=DD");
                    exit();
                } else {
                    // No rows affected or row not found
                    header("Location: teacherselection.php?msg=NDD");
                    exit();
                }
            } else {
                // Error preparing delete statement
                header("Location: teacherselection.php?msg=ERR");
                exit();
            }

            // Close the database connection
            mysqli_close($conn);
        } else {
            // Error connecting to the database
            header("Location: teacherselection.php?msg=DBE");
            exit();
        }
    }
}else{
    header("location:index.php?msg=UUA");
}
?>
