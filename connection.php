<?php
// Database connection file
function open_conn() {
    $servername = "localhost";
    $username = "root"; // MySQL username
    $password = "mysql@123"; // MySQL password
    $dbname = "traffic_violation"; // Database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function close_conn($conn) {
    if ($conn instanceof mysqli && $conn->ping()) { // Ensure the connection is valid
        $conn->close();
    }
}
?>
