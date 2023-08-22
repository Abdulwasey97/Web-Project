<?php
session_start();

include("includes/config.php");
include("includes/common.php");
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if ($_SESSION['type'] == 'student') {
        header("Location: student-dashboard.php");
        exit();
    } else {
    if (isset($_GET['id'])) {
        $student_id = sanitizeInput($_GET["id"]);
    }if (empty($student_id)) {
             header("Location: upload-result.php?msg=SRNS");
    }else{
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Dashboard | AttendEase</title>
    <?php include("includes/css-meta.php"); ?>
</head>
<body>
    <?php include("includes/header.php"); ?>
    <?php include("includes/menu.php"); ?>
    <main>
        
        <h2>Delete Result</h2>
        <h4>Are you Sure you want to delete - This is an irreversible action!</h4>
        <div  class="main_section">
            <?php
            $name = getname();
            $id = getid();
       
            $conn = connect($host, $dusername, $dpassword, $database);
            $sql = "SELECT * FROM `teacher-selection` WHERE english = '$id' OR physics = '$id' OR math = '$id' OR chemistry = '$id' OR urdu = '$id'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                
                    mysqli_data_seek($result, 0); // Reset the result pointer to the beginning

                    while ($row = mysqli_fetch_assoc($result)) {
                            if ($row['english'] == $id) {
                                $subject_id = 'english';
                            } elseif ($row['physics'] == $id) {
                                $subject_id = 'physics';
                            } elseif ($row['math'] == $id) {
                                $subject_id = 'math';
                            } elseif ($row['chemistry'] == $id) {
                                $subject_id = 'chemistry';
                            } elseif ($row['urdu'] == $id) {
                                $subject_id = 'urdu';
                            }
                    }
                
                
                 $sql = "SELECT * FROM `teacher-selection` WHERE english = $subject_id OR physics = $subject_id OR math = $subject_id OR urdu = $subject_id OR chemistry = $subject_id";
                $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['english'] == $id) {
                            $subject_name = 'english';
                        } elseif ($row['physics'] == $id) {
                            $subject_name = 'physics';
                        } elseif ($row['math'] == $id) {
                            $subject_name = 'math';
                        } elseif ($row['chemistry'] == $id) {
                            $subject_name = 'chemistry';
                        } elseif ($row['urdu'] == $id) {
                            $subject_name = 'urdu';
                        }
                    }
   }
     else {
        header("Location: upload-result.php?msg=NTSF");
    }
    
    // selecting grades
   
        $sql_subject = "SELECT * FROM results WHERE student_id = '$student_id'";
        $result_subject = mysqli_query($conn, $sql_subject);

        if (mysqli_num_rows($result_subject) > 0) {
        $row = mysqli_fetch_assoc($result_subject);
            $subjectGrade = $row[$subject_name];
        } else {
        header("Location: upload-result.php?msg=NGF");
        }
                     
               
            } else {
                header("Location: upload-result.php?msg=NSA");
            }
    
    
            ?>
            
            <form action="delete-resultaction.php" method="POST" enctype="multipart/form-data">
                    <label for="student_id">Student ID:</label>
                    <?php echo $student_id; ?>
                    
                    <input type="hidden" id="student_id" name="student_id" value="<?php echo $student_id; ?>">
                  <br><br>
                    <label for="subject_name">Subject:</label>
                    <?php echo $subject_id; ?>
                    <input type="hidden" id="subject_name" name="subject_name" value="<?php echo $subject_id; ?>">
                 <br><br>
                    <label for="grade">Grade:</label>
                    <?php  echo $subjectGrade; ?>
                    <input type="hidden" id="grade" name="grade" value="<?php echo $subjectGrade; ?>">
                    <br><br>
                    <input type="submit" value="Delete">
                </form>
        </div>
        
       
        
    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>
<?php
}
    }
}else{
    header("Location: index.php?msg=UAA");
    exit();
}
?>
