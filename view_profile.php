<?php
session_start();
include("includes/config.php");
include("includes/common.php");
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"]) {
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
       
        <?php 
            if(isset($_GET["msg"])){
                $msg = sanitizeInput($_GET["msg"]);
                if($msg == "DI"){
                    echo "<p class=\"info\">Data Inserted</p>";
                }
            }
        ?>
       
        <div class="main_section">
            <?php 
            $id=getid();
            $conn = connect($host, $dusername, $dpassword, $database);
            $sql = "SELECT * FROM persons WHERE id=$id";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <form action="enterprofile-dataaction.php" method="POST" enctype="multipart/form-data" >
                <label for="fullname">Your Fullname:</label><br>
                <label><?php echo $row["fullname"]; ?></label><br>
                <label for="username">Your Username:</label><br>
                <label><?php echo $row["username"]; ?></label><br>
                <label for="email_address">Enter your Email:</label><br>
                <label><?php echo $row["email"]; ?></label><br>
                <label for="profession">Your Profession:</label><br>
                <label><?php echo $row["profession"]; ?></label><br>
                <label for="Age">Age:</label><br>
                <label><?php echo $row["age"]; ?></label><br>
                <label for="address">Address:</label><br>
                <label><?php echo $row["address"]; ?></label><br>
                <label for="phonenumber">Phone Number:</label><br>
                <label><?php echo $row["phonenumber"]; ?></label><br>

                <label for="profilepic">Profile Picture:</label><br>
                <?php
                    $imageName = $row['pictureurl'];
                    $imagePath = 'uploads/' . $imageName;

                    if (!$row['pictureurl']=="") {
                      
                        echo '<img width="100px" src="' . $imagePath . '"><br>';
                    } else {
                     ?><label>No profile picture available<br></label><?php
                    }
                ?>
                <a href="update-profile.php">Update Profile</a>
               
            </form>
            <?php } ?>
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
