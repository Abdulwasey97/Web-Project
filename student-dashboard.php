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
                <?php
         if(isset($_GET["msg"])){
                $msg = sanitizeInput($_GET["msg"]);
               if($msg =="NRF"){
                     echo "<p class=\"error\">No Record found!</p>";
                }
                if($msg == "NSA"){
                     echo "<p class=\"error\">No Subject available!</p>";
                }
         }
        ?>
                <h2>Welcome</h2>
                <section class="dash_section">
                    <div>
                        <a href="teacherselection.php"><img src="graphics/enrollment_icon.png" alt="Enrollment-icon"></a>
                        <a href="teacherselection.php"><p>Enrollment</p></a>
                    </div>
                    <div>
                        <a href="result.php"><img src="graphics/results.png" alt="Results-icon"></a>
                        <a href="result.php"><p>View Results</p></a>
                    </div>
                    <?php
                    $name = getname();
                    $id=getid();
                    $conn = connect($host, $dusername, $dpassword, $database);
                    $sql = "SELECT * FROM persons WHERE id='$id'";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if ($row["age"] == 0 ||$row["address"] == 0 ||$row["phonenumber"] == 0 ||$row["pictureurl"] == 0  ) {
                                ?>
                                <div>
                                    <a href="completeprofile.php"><img src="graphics/update_profile.png" alt="Update-Profile"></a>
                                    <a href="completeprofile.php"><p>Complete Your Profile</p></a>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div>
                                    <a href="update-profile.php"><img src="graphics/update_profile.png" alt="Update-Profile"></a>
                                    <a href="update-profile.php"><p>Update Profile</p></a>
                                </div>
                                <?php
                            }
                        }
                    }

                    mysqli_close($conn);
                    ?>
                </section>
            </main>
            <?php include("includes/footer.php"); ?>
        </body>
        </html>
        <?php
    }
} else {
    header("Location: index.php?msg=UAA");
    exit();
}
?>
