<?php 
session_start();
include("includes/config.php");
include("includes/common.php");

if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if ($_SESSION['type'] == 'student') {
        header("Location: student-dashboard.php");
        exit();
    } else {  
        $id = $_SESSION['id'];
        $studentid = sanitizeInput($_POST["student_id"]);
        $grade = sanitizeInput($_POST["marks"]);
        $subject = sanitizeInput($_POST["subject_name"]);
        $instr_id = $id;
        $conn = connect($host, $dusername, $dpassword, $database);

        if(empty($studentid) or empty($subject) or empty($instr_id)){
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
                // Student ID exists, update the subject marks
                $updateQuery = "UPDATE `results` SET `$subject` = ? WHERE student_id = ?";
                $updateStmt = mysqli_prepare($conn, $updateQuery);

                if ($updateStmt) {
                    mysqli_stmt_bind_param($updateStmt, "si", $grade, $studentid);
                    if (mysqli_stmt_execute($updateStmt)) {
                        header("Location: upload-result.php?msg=MUS");
                        exit();
                    } else {
                        header("Location: upload-result.php?msg=EUSG");
                    }

                    mysqli_stmt_close($updateStmt);
                } else {
                    header("location: upload-result.php?msg=EPUS");
                }
            } else {
                 header("location: upload-result.php?msg=SINE");
            }
            mysqli_close($conn);
        }
            else {
            header("Location: upload-result.php?msg=EPSS");
        }
    }
    }
}else{
    header("location:index.php?msg=UAA");
}
?>
