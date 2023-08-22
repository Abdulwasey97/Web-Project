<?php 
session_start();
include("includes/config.php");
include("includes/common.php");
$currentpage="login";
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
    if($_SESSION['type'] == 'student'){
        header("Location: student-dashboard.php");
        exit;
    } else {
        header("Location: teacher-dashboard.php");
    }
}
else {
    $username="";
    if (isset($_COOKIE['username'])) {
        $username = sanitizeInput($_COOKIE['username']);

    }
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Login | AttendEase</title>
    <?php include("includes/css-meta.php"); ?>
</head>
<body>
    <?php include("includes/header.php"); ?>
    <?php include("includes/menu.php"); ?>
    <main>
        <section>
            <div id="greeting"></div>
            <h2>Sign In Form</h2> 
            <div class="message">
                    <?php 
            if(isset($_GET["msg"])){
                $msg = sanitizeInput($_GET["msg"]);
                if($msg == "SRA"){
                    echo "<p class=\"info\">You are Successfully Signed Up</p>";
                }
                if($msg == "IEA"){
                    echo "<p class=\"error\">You Entered incorrect Email</p>";
                }
                if($msg == "IPW"){
                    echo "<p class=\"error\">You Entered incorrect Password</p>";
                }
                if($msg == "UUA"){
                    echo "<p class=\"error\">Unauthorized Access</p>";
                }
                 if($msg == "SLO"){
                    echo "<p class=\"info\">Successfully Logged Out!</p>";
                }
                if($msg == "UAA"){
                    echo "<p class=\"error\">Unauthorized Access</p>";
                }
                if($msg == "PC"){
                    echo "<p class=\"error\">Password Changed</p>";
                }
            }
            ?>
                
                </div>
            
            <div class="login_section">
                <form action="signin.php" method="POST">
                    <label for="username">Enter your Username</label><br>
                    <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $username;?>" required><br>
                    
                    <label for="password">Enter your Password</label><br>
                    <input type="password" id="password" name="password" placeholder="Password" required><br>
                   
                    <input type="submit" value="Submit">
                </form>
            </div>
        </section>
        <div class="second_section">
            <h3>Want to signup? <a href="signup.php">Register Now!</a></h3>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>
<?php
}
?>
