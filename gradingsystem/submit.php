<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
// submit.php

include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $mname = $_POST["mname"];
    $lname = $_POST["lname"];
    $ename = $_POST["ename"];
    $pname = $_POST["pname"];
    $lrn = $_POST["lrn"];
    $nickname = $_POST["nickname"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $birthdate = $_POST["birthdate"];
    $address = $_POST["address"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $img = $_POST["img"];
    $section = $_POST["section"];
    $yearlevel = $_POST["yearlevel"];

    $sql = "INSERT INTO $yearlevel (fname, mname, lname, ename, pname, lrn, nickname, age, gender, birthdate, address, username, password, role, img, section)
    VALUES ('$fname', '$mname', '$lname', '$ename', '$pname', '$lrn', '$nickname', '$age', '$gender', '$birthdate', '$address', '$username', '$password', '$role', '$img', '$section')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
    Swal.fire(
        'Success!',
        'New record created successfully',
        'success'
    )
    </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>