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
$fname = $_POST['fname'];
$mname = $_POST['mname'];
$lname = $_POST['lname'];
$ename = $_POST['ename'];
$nickname = $_POST['nickname'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$birthdate = $_POST['birthdate'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];
$img = $_POST['img']; // Get the image URL

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO teachers (fname, mname, lname, ename, nickname, age, gender, birthdate, address, username, password, role, img) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssisssssss", $fname, $mname, $lname, $ename, $nickname, $age, $gender, $birthdate, $address, $username, $password, $role, $img);

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
