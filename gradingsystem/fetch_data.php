<?php
// Include database connection file
include('conn.php');

// Check if the grade level is set
if (isset($_POST['grade'])) {
    $gradeLevel = $_POST['grade'];

    // SQL query to fetch data from the selected grade level table
    $sql = "SELECT * FROM $gradeLevel";
    $result = $conn->query($sql);

    $students = [];
    if ($result->num_rows > 0) {
        // Fetch each row as an associative array
        while ($row = $result->fetch_assoc()) {
            $students[] = [
                'fullname' => $row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . ' ' . $row['ename'],
                'age' => $row['age'],
                'gender' => $row['gender'],
                'birthdate' => $row['birthdate'],
                'address' => $row['address'],
                'username' => $row['username'],
                'password' => $row['password'],
                'section' => $row['section']
            ];
        }
    }

    // Output the data in JSON format
    echo json_encode($students);
}
?>
