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
            <title>Dashboard | AttendEase</title>
            <?php include("includes/css-meta.php"); ?>
        </head>
        <body>
            <?php include("includes/header.php"); ?>
            <?php include("includes/menu.php"); ?>
            <main>
                <h2>Welcome!</h2>
                <div class="message">
            <?php
            if (isset($_GET["msg"])) {
                $msg = sanitizeInput($_GET["msg"]);
                if ($msg == "DI") {
                    echo "<p class=\"info\">Data Inserted</p>";
                }
                if ($msg == "DNI") {
                    echo "<p class=\"info\">Data Not Inserted</p>";
                }
            }
            ?>
        </div>
                <div class="teacher_select_section">
                    <?php
                    $name = getname();
                    $id = getid();
                    $conn = connect($host, $dusername, $dpassword, $database);
        
                    $sql = "SELECT * FROM `teacher-selection` WHERE id='$id'";
                    $result = mysqli_query($conn, $sql);
        
                    if (!$result || mysqli_num_rows($result) == 0) {
                        $sql = "SELECT * FROM `course-selection`";
                        $result = mysqli_query($conn, $sql);
        
                        if (mysqli_num_rows($result) > 0) {
                    ?>
                    <form action="teacher-selectionaction.php" method="POST" enctype="multipart/form-data">
                        <label for="fullname">Enter your Full Name:</label><br>
                        <label><?php echo $name; ?></label><br>
                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" required>
                        <input type="hidden" id="fullname" name="fullname" value="<?php echo $name; ?>" required>
        
                        <label for="course1">Math:</label><br>
                        <select id="course1" name="course1">
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                $subjectname = $row['subjectname'];
                                if ($subjectname == 'math') {
                                    echo "<option value='" . $row['instructorid'] . "'>" . $row['instructor'] . "</option>";
                                }
                            }
                            ?>
                        </select><br>
        
                        <label for="course2">English:</label><br>
                        <select id="course2" name="course2">
                            <?php
                            mysqli_data_seek($result, 0); // Reset the result pointer to the beginning
                            while ($row = mysqli_fetch_assoc($result)) {
                                $subjectname = $row['subjectname'];
                                if ($subjectname == 'english') {
                                    echo "<option value='" . $row['instructorid'] . "'>" . $row['instructor'] . "</option>";
                                }
                            }
                            ?>
                        </select><br>
        
                        <label for="course3">Physics:</label><br>
                        <select id="course3" name="course3">
                            <?php
                            mysqli_data_seek($result, 0); // Reset the result pointer to the beginning
                            while ($row = mysqli_fetch_assoc($result)) {
                                $subjectname = $row['subjectname'];
                                if ($subjectname == 'physics') {
                                    echo "<option value='" . $row['instructorid'] . "'>" . $row['instructor'] . "</option>";
                                }
                            }
                            ?>
                        </select><br>
        
                        <label for="course4">Urdu:</label><br>
                        <select id="course4" name="course4">
                            <?php
                            mysqli_data_seek($result, 0); // Reset the result pointer to the beginning
                            while ($row = mysqli_fetch_assoc($result)) {
                                $subjectname = $row['subjectname'];
                                if ($subjectname == 'urdu') {
                                    echo "<option value='" . $row['instructorid'] . "'>" . $row['instructor'] . "</option>";
                                }
                            }
                            ?>
                        </select><br>
        
                        <label for="course5">Chemistry:</label><br>
                        <select id="course5" name="course5">
                            <?php
                            mysqli_data_seek($result, 0); 
                            while ($row = mysqli_fetch_assoc($result)) {
                                $subjectname = $row['subjectname'];
                                if ($subjectname == 'chemistry') {
                                    echo "<option value='" . $row['instructorid'] . "'>" . $row['instructor'] . "</option>";
                                }
                            }
                            ?>
                        </select><br>
        
                        <input type="submit" value="Submit">
                    </form>
                    <?php
                        } else {
                           header("Location: student-dashboard.php?msg=NSA");
                        }
                    } else {
                        
                        $query = "SELECT ts.physics, ts.english, ts.chemistry, ts.math, ts.urdu, cs.instructor, cs.subjectname
                        FROM `teacher-selection` AS ts
                        JOIN `course-selection` AS cs ON cs.instructorid IN (ts.physics, ts.english, ts.chemistry, ts.math, ts.urdu)
                        WHERE ts.id = ?";
                      
                        $stmt = mysqli_prepare($conn, $query);
                        mysqli_stmt_bind_param($stmt, "i", $id);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
              
                            if (mysqli_num_rows($result) > 0) {
                                ?>
                                <form>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $teacher = $row['instructor'];
                                        $subject = $row['subjectname'];
                                        ?>
                                        <label><?php echo "Subject Name: $subject<br>"; ?></label>
                                        <label><?php echo "$subject teacher: $teacher<br>"; ?></label><br>
                                        <?php
                      }
                      ?>
                    <a href='delete-teacherselectionaction.php'>DELETE</a>
                  </form>
                  <?php
              } else {
                   header("Location: student-dashboard.php?msg=NRF");
              }
              
              mysqli_stmt_close($stmt);
              mysqli_close($conn);
                  }      ?>
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
