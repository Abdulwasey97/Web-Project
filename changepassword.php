<?php
session_start();
include("includes/config.php");
include("includes/common.php");
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Change Password | AttendEase</title>
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
                if ($msg == "FE") {
                    echo "<p class=\"info\">File Already Exists</p>";
                } elseif ($msg == "FL") {
                    echo "<p class=\"info\">File too Large</p>";
                } elseif ($msg == "NF") {
                    echo "<p class=\"info\">No File Selected</p>";
                }
            }
            ?>
        </div>
        <div class="main_section">
            <form action="changepassword-action.php" method="POST" enctype="multipart/form-data">
                <label for="password">New Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Password" required><br>
                <label for="cpassword">Confirm New Password:</label><br>
                <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>
<?php
} else {
    header("Location: index.php?msg=UAA");
    exit();
}
?>
