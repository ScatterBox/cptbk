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

    // Get the form data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $img = $_POST['img']; // Get the image URL

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO admin (name, username, password, role, img) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $username, $password, $role, $img);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(array('message' => 'New record created successfully'));
    } else {
        echo json_encode(array('message' => 'Error: ' . $stmt->error));
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
?>
