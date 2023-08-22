<?php
session_start();

include("includes/config.php");
include("includes/common.php");
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if ($_SESSION['type'] == 'student') {
        header("Location: student-dashboard.php");
        exit();
    } else {
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
        
             <?php 
            if(isset($_GET["msg"])){
                $msg = sanitizeInput($_GET["msg"]);
                if($msg == "MUS"){
                    echo "<p class=\"info\">Subject Grade Updated!</p>";
                }
                if($msg == "SRE"){
                    echo "<p class=\"error\">Student Record already Exists - if you want to update please Edit!</p>";
                }
                if($msg == "SGDS"){
                    echo "<p class=\"info\">Subject Grade Deleted Successfully</p>";
                }
                if($msg == "NGD"){
                      echo "<p class=\"error\">No Grade to Delete!</p>";
                }
                if($msg == "SRI"){
                     echo "<p class=\"info\">Subject Record Inserted Successfully</p>";
                }
                if($msg == "ycu"){
                  echo "<p class=\"info\">You can upload</p>";
                }
                if($msg == "OTHER_MESSAGE"){
                     echo "<p class=\"error\">Other message</p>";
                }
                if($msg == "ZNU"){
                    echo "<p class=\"error\">Please enter digit greater than 0</p>";
                }
                if($msg == "MAU"){
                    echo "<p class=\"error\">Grade already Uploaded!</p>";
                }
                if($msg == "SRNS"){
                    echo "<p class=\"error\">Student Record Not Selected!</p>";
                }
                if($msg == "NGF"){
                    echo "<p class=\"error\">No Grade Found!</p>";
                }
                if($msg == "NSA"){
                    echo "<p class=\"error\">No Subject available!</p>";
                }
                if($msg == "NTSF"){
                    echo "<p class=\"error\">No Teacher subject found!</p>";
                }
                if($msg == "SINE"){
                     echo "<p class=\"error\">Student ID doesn't exist!</p>";
                }
                if($msg == "EDSG"){
                     echo "<p class=\"error\">Error in deleting subject Grade!</p>";
                }
                if($msg == "EPUS"){
                     echo "<p class=\"error\">Error in preparing update statement!</p>";
                }
                if($msg == "EPSS"){
                     echo "<p class=\"error\">Error in preparing select statement!</p>";
                }
                if($msg == "EUSG"){
                     echo "<p class=\"error\">Error in updating subject grade!</p>";
                }
                if($msg =="NRF"){
                     echo "<p class=\"error\">No Record found!</p>";
                }
                if($msg == "EBS"){
                      echo "<p class=\"error\">Error binding statement!</p>";
                }
                if($msg == "EES"){
                     echo "<p class=\"error\">Error executing statement!</p>";
                }
                
            }
            ?>
        
        <h2>Upload Result</h2>
        <div class="main_section">
            <?php
            $name = getname();
            $id = getid();
           
            $conn = connect($host, $dusername, $dpassword, $database);
            $sql = "SELECT * FROM `teacher-selection` WHERE english = '$id' OR physics = '$id' OR math = '$id' OR chemistry = '$id' OR urdu = '$id'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                ?>
                <form action="upload-resultaction.php" method="POST" enctype="multipart/form-data">
                    <label for="student">Student ID:</label>
                     
                    <select id="student" name="student">
                       
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $studentId = $row['id'];
                            echo "<option value='$studentId'>$studentId</option>";
                        }
                
                        ?>
                        
                    </select><br>
                    
                    <label for="subjects">Subjects:</label><br>
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
                
                    <?php echo $subject_id ?>
                    <input type="number" id="grade" name="grade" min="0" max="100" required>
                    <br>
                    <input type="submit" value="Upload">
                </form>
            <?php
            } else {
                header("Location: upload-result.php?msg=NSA");
            }
            ?>
        </div>
        
       <div>
    <?php
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
    ?>
</div>
        
     <div class="instr_uploaded_result">
    <h4>Existing Records</h4>
    <?php
    $sql_subject = "SELECT * FROM results WHERE (english = '$subject_name' OR physics = '$subject_name' OR chemistry = '$subject_name' OR urdu = '$subject_name' OR math = '$subject_name') OR english_instr_id = '$id' OR physics_instr_id = '$id' OR chemistry_instr_id = '$id' OR urdu_instr_id = '$id' OR math_instr_id = '$id'";
    $result_subject = mysqli_query($conn, $sql_subject);

    if ($result_subject) {
        if (mysqli_num_rows($result_subject) > 0) {
            echo "<table class=\"teach_result\">";
            echo "<tr>";
            echo "<th>Student ID: </th>";
            echo "<th>$subject_name Marks: </th>";
            echo "<th colspan='2'>Action</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_assoc($result_subject)) {
                $studentId = $row['student_id'];
                $subjectGrade = $row[$subject_name];
                
                if($subjectGrade == 0){
                   
                }
                else{
                    // Display the result record
                echo "<tr>";
                echo "<td>$studentId</td>";
                echo "<td>$subjectGrade</td>";
                echo "<td><a href='edit-result.php?id=".$studentId."'>EDIT</a></td>";
                echo "<td><a href='delete-result.php?id=".$studentId."'>DELETE</a></td>";
                echo "</tr>";
                }
                
            }
            echo "</table>";
        } else {
             
        }
    } else {
        header("Location: upload-result.php?msg=EPSS");
    }
    ?>
</div>

    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>
<?php
}
}else{
    header("Location: index.php?msg=UAA");
}
?>
