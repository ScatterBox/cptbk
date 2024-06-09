<?php
    // Your database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gradingsystem";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT name, age, birthdate, gender, email, username, password, role FROM teachers");
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the data as an associative array
    $teachers = $result->fetch_all(MYSQLI_ASSOC);

    // Send the data as a JSON response
    echo json_encode($teachers);

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
?>
