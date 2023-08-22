<?php
session_start();
include("includes/config.php");
include("includes/common.php");

if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if ($_SESSION['type'] == 'student') {
        header("Location: student-dashboard.php");
        exit();
    } else {
        $studentid = sanitizeInput($_POST["student_id"]);
        $subject_name = sanitizeInput($_POST["subject_name"]);
        $grade = sanitizeInput($_POST["grade"]);
        $conn = connect($host, $dusername, $dpassword, $database);
        
        if(empty($studentid) or empty($subject_name) or empty($grade)){
        header("Location: upload-result.php?msg=SRNS");
        }
        else{
        $query = "SELECT * FROM `results` WHERE student_id = ?";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $studentid);
            mysqli_stmt_execute($stmt);

            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                if ($grade == 0) {
                    header("Location: upload-result.php?msg=NGD");
                    exit();
                } else {
                    // Student ID exists, set it to NULL
                    $updateQuery = "UPDATE `results` SET $subject_name = NULL WHERE student_id = ?";
                    $updateStmt = mysqli_prepare($conn, $updateQuery);

                    if ($updateStmt) {
                        mysqli_stmt_bind_param($updateStmt, "i", $studentid);
                        if (mysqli_stmt_execute($updateStmt)) {
                            header("location: upload-result.php?msg=SGDS");
                            exit();
                        } else {
                            header("location: upload-result.php?msg=EDSG");
                        }
                        mysqli_stmt_close($updateStmt);
                    } else {
                        header("location: upload-result.php?msg=EPUS");
                    }
                }
            } else {
                header("Location: upload-result.php?msg=SINE");
            }

            mysqli_stmt_close($stmt);
        } else {
            header("Location: upload-result.php?msg=EPSS");
        }

        mysqli_close($conn);
    }
        }
}else{
    header("Location: index.php?msg=UAA");
    exit();
}
?>
