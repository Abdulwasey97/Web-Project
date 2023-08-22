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
    $studentid = sanitizeInput($_POST["student"]);
    $grade = sanitizeInput($_POST["grade"]);
    $instr_id = $id;
    $conn = connect($host, $dusername, $dpassword, $database);
        
       if(empty($id) or empty($studentid) or empty($grade)){
        header("Location: upload-result.php?msg=SRNS");
        }
        else{
                // For selecting specific subject
    $sql = "SELECT * FROM `teacher-selection` WHERE english = '$id' OR physics = '$id' OR math = '$id' OR chemistry = '$id' OR urdu = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['english'] == $id) {
        $subject = 'english';
        $instr_id_subj = 'english_instr_id';
    } elseif ($row['physics'] == $id) {
        $subject = 'physics';
        $instr_id_subj = 'physics_instr_id';
    } elseif ($row['math'] == $id) {
        $subject = 'math';
        $instr_id_subj = 'math_instr_id';
    } elseif ($row['chemistry'] == $id) {
        $subject = 'chemistry';
        $instr_id_subj = 'chemistry_instr_id';
    } elseif ($row['urdu'] == $id) {
        $subject = 'urdu';
        $instr_id_subj = 'urdu_instr_id';
    }

    $query = "SELECT * FROM `results` WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "i", $studentid);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        
        mysqli_stmt_store_result($stmt);

        // if Student ID exists, fetch the existing grade
        if (mysqli_stmt_num_rows($stmt) > 0) {
            
            $existingGradeQuery = "SELECT `$subject` FROM `results` WHERE student_id = ?";
            $existingGradeStmt = mysqli_prepare($conn, $existingGradeQuery);
            
            mysqli_stmt_bind_param($existingGradeStmt, "i", $studentid);
            
            mysqli_stmt_execute($existingGradeStmt);
            
            mysqli_stmt_bind_result($existingGradeStmt, $existingGrade);
            
            mysqli_stmt_fetch($existingGradeStmt);
            
            mysqli_stmt_close($existingGradeStmt);

            // Check if the existing grade is 0
            if ($existingGrade == 0) {
                
                //check if the grade to upload is not zero
                if ($grade != 0) {
                    $updateQuery = "UPDATE `results` SET `$subject` = ?, `$instr_id_subj` = ? WHERE student_id = ?";

                    $updateStmt = mysqli_prepare($conn, $updateQuery);

                    if ($updateStmt) {
                        mysqli_stmt_bind_param($updateStmt, "iii", $grade, $instr_id, $studentid);
                        if (mysqli_stmt_execute($updateStmt)) {
                            header("Location: upload-result.php?msg=SRI");
                            echo "Subject marks updated successfully.";
                        } else {
                            echo "Error updating subject marks: " . mysqli_stmt_error($updateStmt);
                        }
                        mysqli_stmt_close($updateStmt);
                    } else {
                        echo "Error preparing update statement: " . mysqli_error($conn);
                    }
                } else {
                    // If Grade to be uploaded is 0
                    header("Location: upload-result.php?msg=ZNU");
                }
            } else {
                // If grade is already uploaded
                header("Location: upload-result.php?msg=MAU");
            }
        } else {
            $query = "INSERT INTO `results` (student_id, `$subject`, `$instr_id_subj`) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);

            if (!$stmt) {
                header("location: upload-result.php?msg=EPUS");
            }

            $success = mysqli_stmt_bind_param($stmt, "isi", $studentid, $grade, $instr_id);

            if ($success === false) {
                header("location: upload-result.php?msg=EBS");
            }

            $success = mysqli_stmt_execute($stmt);

            if (!$success) {
                 header("location: upload-result.php?msg=EES");
            }

            mysqli_stmt_close($stmt);
            header("Location: upload-result.php?msg=SRI");
        }
        mysqli_close($conn);
    }
            else {
            header("Location: upload-result.php?msg=EPSS");
        }
        }


    }
}else{
    header("Location: index.php?msg=UAA");
}
?>
