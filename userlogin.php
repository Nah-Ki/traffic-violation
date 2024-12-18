<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/usrlogin.css">
    <script src="https://kit.fontawesome.com/2182b01a00.js" crossorigin="anonymous"></script>
    <title>TRVMS USER LOGIN</title>
</head>
<body>
    <header>
        <a href="index.php"><img src="/assests/logo.png" alt="Logo" id="logo"></a>
        <div id="links">
            <a href="https://github.com/Nah-Ki/traffic-violation/blob/main/README.md" target="_blank" rel="noopener noreferrer" class="nav-btn">About</a>
            <a href="https://github.com/Nah-Ki/traffic-violation" target="_blank" rel="noopener noreferrer" class="nav-btn">Source Code</a>
        </div>
    </header>
    <div id="content">
        <div id="form-box">
            <h1>Hi! Welcome back</h1>
            <form name="loginform" action="userlogin.php" onsubmit = "return validation()" method="post">
                <label for="aadharno">Aadhar Number</label><br>
                <div class="input-box">
                    <input type="number" name="aadharno" id="aadharno">
                </div>
                <label for="pwd">Password</label><br>
                <div class="input-box">
                    <input type="password" name="pwd" id="pwd">
                </div>
                <div class="input-box">
                    <input type="submit" name= "submit" id = "submit" value="Login">
                </div>
                <p id="sign-up">Don't have an account? <a href = "userregister.php">Sign Up</a></p>
            </form>
        </div>
        <img src="assests/6387974.jpg" alt="" id="img-box">
    </div>
    <a href="index.php" id="back2index"> Back To Landing Page</a>
</body>
</html>
<?php
    ob_start();
    include "connection.php";
    include "formvalidations.php";
    ob_end_clean();

    if(isset($_POST['submit'])){
        $aadharno = aadhar($_POST['aadharno']); // Clean Aadhar number
        $pwd = $_POST['pwd']; // User entered password

        if(!empty($aadharno) && !empty($pwd)){
            $conn = open_conn();
            $sql = "SELECT * FROM user WHERE aadhar_no = '$aadharno'";
            $result = $conn->query($sql);

            if($result->num_rows === 1){
                session_start();
                $row = $result->fetch_assoc();

                // Debugging: print entered password and stored hash
                echo "Entered password: " . $pwd . "<br>";
                echo "Stored password hash: " . $row['passwd'] . "<br>";

                // Compare entered password with the hashed password in the database
                if(password_verify($pwd, $row['passwd'])){
                    $_SESSION['is_login'] = true;
                    $_SESSION['aadhar_no'] = $row['aadhar_no'];
                    $_SESSION['legal_name'] = $row['legal_name'];
                    header("Location: user.php");
                }
                else{
                    echo "Incorrect password. Please try again.<br>";
                    echo "Register as a new user if you don't have an account.";
                }
            }
            else{
                echo "No user found with this Aadhar number.<br>";
                echo "Register as a new user.";
            }
        }
        else{
            echo "Please fill in all the fields.<br>";
        }
    }
?>
