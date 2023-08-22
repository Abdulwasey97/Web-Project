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
        <h2>Welcome!</h2>
        <div class="message">
            <?php
            if (isset($_GET["msg"])) {
                $msg = sanitizeInput($_GET["msg"]);
                if ($msg == "DI") {
                    echo "<p class=\"info\">Course Selected</p>";
                }
            }
            ?>
        </div>
<div class="select_form">
        <div class="main_section">
            
            <?php
            $name = getname();
            $id = getid();
            $conn = connect($host, $dusername, $dpassword, $database);
            $sql = "SELECT * FROM persons WHERE id='$id'";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <form action="course-selectionaction.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <label for="fullname">Enter your Full Name:</label><br>
                    <label><?php echo $row['fullname']; ?></label>
                    <input type="hidden" name="fullname" value="<?php echo $row['fullname']; ?>" required><br>

                    <?php
                    $sql1 = "SELECT * FROM `course-selection` WHERE instructorid='$id'";
                    $result2 = mysqli_query($conn, $sql1);

                    if (!$result2 || mysqli_num_rows($result2) == 0) { ?>
                        <label for="course">Select Course:</label><br>
                        <select id="course" name="course">
                            <option value="physics">Physics</option>
                            <option value="chemistry">Chemistry</option>
                            <option value="math">Math</option>
                            <option value="english">English</option>
                            <option value="urdu">Urdu</option>
                        </select><br>
                        <input type="submit" value="Submit">
                    <?php } else {
                        $row2 = mysqli_fetch_assoc($result2); ?>
                        <label>Subject Name: <?php echo $row2['subjectname']; ?></label><br>
                        
                    <?php } ?>

                </form>
            <?php } ?>
            </div>
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
