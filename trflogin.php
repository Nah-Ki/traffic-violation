<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/trlogin.css">
    <title>TRVMS TRAFFIC LOGIN</title>
</head>
<body>
    <header>
        <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
        <div id="links">
            <a href="https://github.com/Nah-Ki/traffic-violation/blob/main/README.md" target="_blank" rel="noopener noreferrer" class="nav-btn">About</a>
            <a href="https://github.com/Nah-Ki/traffic-violation" target="_blank" rel="noopener noreferrer" class="nav-btn">Source Code</a>
        </div>
    </header>
    <div id="content">
        <div id="form-box">
            <h1>Hi! Welcome back.</h1>
            <form name="loginform" action="trflogin.php" onsubmit = "return validation()" method="post">
                <label for="id">ID</label><br>
                <div class="input-box">
                    <input type="number" min="0" name="id" id="id">
                </div>
                <label for="pwd">PASSWORD</label><br>
                <div class="input-box">
                    <input type="password" name="pwd" id="pwd"> 
                </div>
                <div class="input-box">
                    <input type="submit" name= "submit" id = "submit" value="Login">
                </div>
            </form>
        </div>
        <img src="assests/7514770.jpg" alt="" id="img-box">
    </div>
    <a href="index.php" id="back2index">Back To Landing Page</a>


    <script>
        function validation() {
            var id = document.forms["loginform"]["id"].value;
            if(!/^[0-9]+$/.test(id)){
                alert("Enter a vaild ID");
            }
        }
    </script>
</body>
</html>

<?php
    session_start();
    ob_start();
    include "connection.php";
    ob_end_clean();

    if (isset($_POST['submit'])) {
        $id = intval($_POST['id']); // Ensure ID is an integer
        $pwd = trim($_POST['pwd']); // Remove any leading or trailing spaces

        if (!empty($id) && !empty($pwd)) {
            $conn = open_conn();
            $stmt = $conn->prepare("SELECT * FROM traffic_police WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
            
                // Temporarily compare plain text passwords for debugging
                if ($pwd === $row['password']) {
                    $_SESSION['is_login'] = true;
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['name'] = $row['name'];
                    header("Location: trfperson.php");
                    exit();
                } else {
                    echo "<script>alert('Wrong password');</script>";
                }
            } else {
                echo "<script>alert('The user doesn\\'t exist.');</script>";
            }
            

            $stmt->close();
            $conn->close();
        } else {
            echo "<script>alert('Please enter both ID and password.');</script>";
        }
    }
?>
