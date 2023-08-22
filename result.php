<?php
session_start();
include("includes/config.php");
include("includes/common.php");
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if ($_SESSION['type'] == 'teacher') {
        header("Location: teacher-dashboard.php");
        exit();
    } else {
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Result | AttendEase</title>
    <?php include("includes/css-meta.php"); ?>
</head>
<body>
    <?php include("includes/header.php"); ?>
    <?php include("includes/menu.php"); ?>
    <main>
        <?php
        $id = getid();
        ?>
        <h2>View your Results</h2>
        <section>
            <div class="student_result">
                <?php 
                $conn = connect($host, $dusername, $dpassword, $database);
                $sql = "SELECT * FROM persons ur, results sr WHERE ur.id = $id AND sr.student_id = $id";

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id_of_student = $row['id'];
                        $student_name = $row['fullname'];
                        $student_email = $row['email'];
                        $chemistry_grade = $row['chemistry'];
                        $physics_grade = $row['physics'];
                        $maths_grade = $row['math'];
                        $english_grade = $row['english'];
                        $urdu_grade = $row['urdu'];
                    }
                    
                    if ($chemistry_grade == 0 || $physics_grade == 0 || $maths_grade == 0 || $english_grade == 0 || $urdu_grade == 0) {
                         ?>
                       <h3>Sorry Result not uploaded yet!</h3>
                        <h3>Back to <a href="student-dashboard.php">Dashboard</a></h3>
                        <?php
                    } else {
                        ?>
                        <table class="student_result_table">
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Student Email</th>
                                <th>Chemistry</th>
                                <th>Physics</th>
                                <th>Math</th>
                                <th>English</th>
                                <th>Urdu</th>
                            </tr>
                            <tr>
                                <td><?php echo $id_of_student; ?></td>
                                <td><?php echo $student_name; ?></td>
                                <td><?php echo $student_email; ?></td>
                                <td><?php echo $chemistry_grade; ?></td>
                                <td><?php echo $physics_grade ?></td>
                                <td><?php echo $maths_grade; ?></td>
                                <td><?php echo $english_grade; ?></td>
                                <td><?php echo $urdu_grade; ?></td>
                            </tr>
                        </table>
                
                <table class="student_result_table2">
                            <tr>
                                <th>Student ID</th>
                                <td><?php echo $id_of_student; ?></td>
                            </tr>
                        <tr>
                                <th>Student Name</th>
                                <td><?php echo $student_name; ?></td>
                         </tr>
                    <tr>
                                <th>Student Email</th>
                                <td><?php echo $student_email; ?></td>
                    </tr>
                     <tr>
                                <th>Chemistry</th>
                                <td><?php echo $chemistry_grade; ?></td>
                    </tr>
                    <tr>
                                <th>Physics</th>
                                <td><?php echo $physics_grade ?></td>
                    </tr>
                    <tr>
                                <th>Math</th>
                                <td><?php echo $maths_grade; ?></td>
                    </tr>
                    <tr>
                                <th>English</th>
                                <td><?php echo $english_grade; ?></td>
                    </tr>
                    <tr>
                                <th>Urdu</th>
                                <td><?php echo $urdu_grade; ?></td>
                    </tr>
                        </table>
                        <?php
                    }
                } else {
                  echo "No record!";
                }
                ?>
            </div>
        </section>
    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>
<?php
}
} else {
    header("location:index.php?msg=UAA");
    exit();
}
?>
