<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/trafficpolice.css">
    <link rel="stylesheet" href="css/title.css">
    <title>Traffic Police</title>
</head>
<body>
    <header>
        <div class="loti">
            <a href="index.php"><img src="assests/logo.png" alt="Logo" id="logo"></a>
            <h1>View Offcer Details</h1>
        </div>
        <div class="whitespace"></div>
        <div id="links">
            <a href="trfperson.php" class="nav-btn">Back</a>
        </div>
    </header>
    <div id="tp-form">
        <form action = "trafficpolice.php" method = "POST">
            <label for = "id_" class = "form label">Enter the ID of the officer: </label>
            <input type = "number" name = "id" id = "id"><br>
            <input type="submit" name= "submit" id = "submit" value="Submit">
        </form>
        <p id="message"></p>
    </div>
    
    <?php
    session_start();
    ob_start();
    include "connection.php";
    ob_end_clean();

    // Redirect if session ID is not set
    if (empty($_SESSION['id'])) {
        header("Location: trflogin.php");
        exit();
    }

    $message = ""; // Initialize message variable

    if (isset($_POST['submit'])) {
        if (!empty($_POST['id'])) {
            $id = intval($_POST['id']); // Convert to integer for safety

            $conn = open_conn();
            $stmt = $conn->prepare("SELECT * FROM traffic_police WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                echo "<table border='1'>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>DESIGNATION</th>
                            <th>ZONE</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['designation']) . "</td>
                            <td>" . htmlspecialchars($row['zone_']) . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                $message = "No officer found with ID " . htmlspecialchars($id) . ".";
            }
            $stmt->close();
            $conn->close();
        } else {
            $message = "Please enter an officer ID.";
        }
    }
?>

</body>
</html>