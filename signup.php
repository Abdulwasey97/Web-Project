<?php
session_start();
include("includes/config.php");
include("includes/common.php");
$currentpage="signup";
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if($_SESSION['type'] == 'student'){
        header("Location: student-dashboard.php");
        exit;
    } else {
        header("Location: teacher-dashboard.php");
    }
}
else{
    ?>
<!Doctype html>
<html lang="en-US">
    <head>
        <title>Signup | AttendEase </title>
         <?php include("includes/css-meta.php"); ?>
    </head>
<body>
     <?php include("includes/header.php"); ?>
     <?php include("includes/menu.php"); ?>
    <main>
        
    <section>
        
            <h2>Sign Up Form</h2>
            <div class="message">
            <?php
if (isset($_GET["msg"])) {
    $msg = sanitizeInput($_GET["msg"]);
    if ($msg == "UNE") {
        echo "<p class=\"info\">Username Already Exists!</p>";
    }
}
?>
                
                </div>
    <div class="main_section">
        
            <form action="signup-action.php" method="POST">
                <label for="fullname">Enter your Fullname:</label><br>
                <input type="text" id="fullname" name="fullname" placeholder="Full Name" required><br>
                <label for="username">Enter your Username:</label><br>
                <input type="text" id="username" name="username" placeholder="Username" required><br>
                <label for="email_address">Enter your Email:</label><br>
                <input type="email" id="email_address" name="email_address" placeholder="Email" required><br>
                <label for="password">Enter your Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Password" required><br>
                <label for="profession">Choose your Profession:</label><br>
                <select id="profession" name="profession">
                <option value="student">Student</option>
                <option value="teacher">Teacher</option>
                </select><br>
                <input type="submit" value="Submit">
            </form>
        
        
        </div>
        
        
    </section>
   
    </main>
    <?php include("includes/footer.php"); ?>
    
</body>
</html>
 <?php
}
?>