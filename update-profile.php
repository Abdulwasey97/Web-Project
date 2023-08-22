<?php
session_start();
include("includes/config.php");
include("includes/common.php");
if (isset($_SESSION["signedin"]) && $_SESSION["signedin"] ) {
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
            if(isset($_GET["msg"])){
                $msg = sanitizeInput($_GET["msg"]);
                if($msg == "FE"){
                    echo "<p class=\"info\">File Already Exists</p>";
                }
                if($msg == "FL"){
                    echo "<p class=\"info\">File too Large</p>";
                }
                if($msg == "NF"){
                    echo "<p class=\"info\">No File Selected</p>";
                }
                if($msg == "Fileerror"){
                     echo "<p class=\"info\">File Error!</p>";
                }
            }
            ?>
                
                </div>
               <div class="main_section">
            <?php 
            $name = getname();
          
            $conn = connect($host, $dusername, $dpassword, $database);
            $sql = "SELECT * FROM persons WHERE fullname='$name'";
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
                <input type="number" id="age" name="age" placeholder="<?php echo $row['age'];?>" required><br>
                <label for="address">Address:</label><br>
                <input type="text" id="address" name="address" placeholder="<?php echo $row['address'];?>" required><br>
                <label for="phonenumber">Phone Number:</label><br>
                <input type="tel" id="phonenumber" name="phonenumber" placeholder="<?php echo $row['phonenumber'];?>" pattern="^(\+92|0)\d{10}$" required>
                <small>Enter a valid Pakistani phone number starting with +92 or 0</small><br>
               
              <label for="profilepic">Profile Picture</label><br>
             
                <input type="file"  accept="image/png, image/gif, image/jpeg" name="file"  placeholder="Picture " requried /><br>
           
                <input type="submit" value="Submit">
            </form>
            <?php } ?>
        </div>
    </main>
    <?php include("includes/footer.php"); ?>
</body>
</html>
<?php
}else{
    header("Location: index.php?msg=UAA");
    exit();
}
    ?>