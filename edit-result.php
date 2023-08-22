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
        <h2>Update Grade</h2>

         <div>
            <?php
            $name = getname();
            $id = getid();
           
    //selecting subject id to select subject name
            $conn = connect($host, $dusername, $dpassword, $database);
            $sql = "SELECT * FROM `teacher-selection` WHERE english = '$id' OR physics = '$id' OR math = '$id' OR chemistry = '$id' OR urdu = '$id'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                ?>
              
                    <?php
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
                    ?>
                   
            <?php
            } else {
                 header("Location: upload-result.php?msg=NSA");
            }
            ?>
        </div>
        
       <div>
           
    <?php
    // selecting subject name
    $conn = connect($host, $dusername, $dpassword, $database);
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
        } 
        else {
        header("Location: upload-result.php?msg=NGF");
        }

    //form
    
            $sql = "SELECT * FROM results WHERE student_id = '$id'";
            $result = mysqli_query($conn, $sql);
            ?>
           <div class="main_section">
                <form action="update-marks-action.php" method="POST" enctype="multipart/form-data">
                    <label for="student_id">Student ID:</label>
                    <?php
                    echo $student_id;
                    ?>
                    <br>
                    <label for="marks">Enter Marks for <?php echo $subject_name; ?>:</label><br>
                    <input type="number" id="marks" name="marks" min="0" max="100" value="<?php echo $subjectGrade; ?>" required><br>

                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                    <input type="hidden" name="subject_name" value="<?php echo $subject_name; ?>">

                    <input type="submit" value="Update">
                </form>
           
           
            <?php
           ?>
               </div>
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
