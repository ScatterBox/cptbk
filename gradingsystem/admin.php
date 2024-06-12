<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<?php include 'hui.php' ?>
<?php include 'adduser.php'; ?>

<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="style.css">

<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script defer src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script defer src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script defer src="script.js"></script>

<body>
    <div class="container-fluid">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="logo.jpg" alt="logo" />
                <div class="header-text">
                    <h2>Admin</h2>
                    <h2>Dashboard</h2>
                </div>
            </div>
            <ul class="sidebar-links">
                <li>
                    <a href="#" onclick="showFaculty()">
                        <span class="material-symbols-outlined"> Person </span>Teachers</a>
                </li>
                <li>
                    <a href="#" onclick="showAdmin()">
                        <span class="material-symbols-outlined"> Person </span>Admin</a>
                </li>
                <li>
                    <a href="#" onclick="showManageClass()">
                        <span class="material-symbols-outlined">
                            Person
                        </span>
                        Students</a>
                </li>

                <h4>
                    <span>Manage Info</span>
                    <div class="menu-separator"></div>
                </h4>
                <li>
                    <a href="#" onclick="showNewAdmin()">
                        <span class="material-symbols-outlined">
                            person_add
                        </span>Add Admin</a>
                </li>
                <li>
                    <a href="#" onclick="showNewTeacher()">
                        <span class="material-symbols-outlined">
                            person_add
                        </span>Add Teacher</a>
                </li>
                <li>
                    <a href="#" onclick="showAddUser()">
                        <span class="material-symbols-outlined">
                            person_add
                        </span>Add User</a>
                </li>

                <h4>
                    <span>Account</span>
                    <div class="menu-separator"></div>
                </h4>
                <li>
                    <a href="logout.php"><span class="material-symbols-outlined"> logout </span>Logout</a>
                </li>
            </ul>
            <div class="user-account">
                <div class="user-profile">
                    <img src="<?php echo $_SESSION['user']['img']; ?>" alt="Profile Image" />
                    <div class="user-detail">
                        <h3><?php echo $_SESSION['user']['nickname']; ?></h3>
                        <span><?php echo ucfirst($_SESSION['user']['role']); ?></span>
                    </div>
                </div>
            </div>

        </aside>

        <!-- Main content -->
        <div class="col-md-9" id="mainContent">

        </div>
    </div>

    <script>
        //List of Admins//
        function showAdmin() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = `
        <style>
            .smaller-table {
                font-size: 0.8em; /* Adjust as needed */
                width: 80%; /* Adjust as needed */
                margin: auto;
            }
            .smaller-table th, .smaller-table td {
                padding: 5px; /* Adjust as needed */
            }
        </style>
        <h1 style="text-align: center;">List of Admins</h1>
        <table id="adminTable" class="table table-striped smaller-table" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Age</th>
                    <th scope="col">Address</th>
                    <th scope="col">Gender</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Age</th>
                    <th scope="col">Address</th>
                    <th scope="col">Gender</th>
                </tr>
            </tfoot>
        </table>
    `;

            // Fetch the admin data from the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_admins.php', true);
            xhr.onload = function () {
                if (this.status == 200) {
                    // Parse the JSON data
                    var admins = JSON.parse(this.responseText);

                    // Get the table body
                    var tbody = document.querySelector('#adminTable tbody');

                    // Insert the admin data into the table
                    for (var i = 0; i < admins.length; i++) {
                        var tr = document.createElement('tr');
                        var fullname = `${admins[i].fname} ${admins[i].mname} ${admins[i].lname} ${admins[i].ename}`;
                        tr.innerHTML = `
                    <th scope="row">${i + 1}</th>
                    <td>${fullname}</td>
                    <td>${admins[i].age}</td>
                    <td>${admins[i].address}</td>
                    <td>${admins[i].gender}</td>
                `;
                        tbody.appendChild(tr);
                    }

                    // Initialize DataTable
                    $('#adminTable').DataTable();
                }
            };
            xhr.send();
        }

        // Ensure the function is called to render the admin table
        document.addEventListener('DOMContentLoaded', showAdmin);

        //Add Teacher//
        function showNewTeacher() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = `  <?php include 'conn.php'; ?>
    <h3>Teacher Submitter Form</h3>
        <div class="registration-form">
        <form id="teacherForm">
        <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" class="form-control item" id="fname" placeholder="Example: Juan" required>
            </div>
            <div class="form-group">
                <label for="mname">Middle Name:</label>
                <input type="text" class="form-control item" id="mname" placeholder="Example: Dela" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" class="form-control item" id="lname" placeholder="Example: Crunchy" required>
            </div>
            <div class="form-group">
                <label for="ename">Extension Name:</label>
                <input type="text" class="form-control item" id="ename" placeholder="Example: Sr.">
            </div>
            <div class="form-group">
                <label for="nickname">Nickname:</label>
                <input type="text" class="form-control item" id="nickname" placeholder="Example: Tutu" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" class="form-control item" id="age" placeholder="Example: 12" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control item" id="gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="birthdate">Birthdate:</label>
                <input type="date" class="form-control item" id="birthdate" placeholder="Example: 01/01/2001">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control item" id="address" placeholder="Example: Purok. Pinetree, Brgy. Oringao, Kabankalan City, Negros Occidental." required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control item" id="username" placeholder="Example: @JuanFGSNHS" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control item" id="password" placeholder="" required>
            </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <input type="text" class="form-control item" id="role" name="role" value="teacher" readonly>
                </div>
                <div class="form-group">
                <label for="img">Profile Image URL:</label>
                <input type="url" class="form-control item" id="img" placeholder="Example: juan.jpg" name="img" required>
            </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Account</button>                
                </div>
            </form>
        </div>
    `;
            document.getElementById('teacherForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                var fname = document.getElementById('fname').value;
                var mname = document.getElementById('mname').value;
                var lname = document.getElementById('lname').value;
                var ename = document.getElementById('ename').value;
                var nickname = document.getElementById('nickname').value;
                var age = document.getElementById('age').value;
                var gender = document.getElementById('gender').value;
                var birthdate = document.getElementById('birthdate').value;
                var address = document.getElementById('address').value;
                var username = document.getElementById('username').value;
                var password = document.getElementById('password').value;
                var role = document.getElementById('role').value;
                var img = document.getElementById('img').value; // Get the image URL

                // Send the form data to the server using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'tdbconn.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('fname=' + fname + '&mname=' + mname + '&lname=' + lname + '&ename=' + ename + '&nickname=' + nickname + '&age=' + age + '&birthdate=' + birthdate + '&gender=' + gender + '&address=' + address + '&username=' + username + '&password=' + password + '&role=' + role + '&img=' + img);

                xhr.onload = function () {
                    if (this.status == 200) {
                        // Handle the response from the server
                        var response = JSON.parse(this.responseText);
                        console.log(response);
                        if (response.message === 'New record created successfully') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Account was successfully created!'
                            });
                            // Clear the form
                            document.getElementById('teacherForm').reset();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error creating the account: ' + response.message
                            });
                        }
                    }
                };
            });
        }


        //Add Admin//
        function showNewAdmin() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = ` <?php include 'conn.php'; ?> 
            <h3>Admin Submitter Form</h3>
    <div class="registration-form">
        <form id="adminForm">
            <div class="form-group">
                <label for="fname">First Name:</label>
                <input type="text" class="form-control item" id="fname" placeholder="Example: Juan" required>
            </div>
            <div class="form-group">
                <label for="mname">Middle Name:</label>
                <input type="text" class="form-control item" id="mname" placeholder="Example: Dela" required>
            </div>
            <div class="form-group">
                <label for="lname">Last Name:</label>
                <input type="text" class="form-control item" id="lname" placeholder="Example: Crunchy" required>
            </div>
            <div class="form-group">
                <label for="ename">Extension Name:</label>
                <input type="text" class="form-control item" id="ename" placeholder="Example: Sr.">
            </div>
            <div class="form-group">
                <label for="nickname">Nickname:</label>
                <input type="text" class="form-control item" id="nickname" placeholder="Example: Tutu" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" class="form-control item" id="age" placeholder="Example: 12" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control item" id="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="birthdate">Birthdate:</label>
                <input type="date" class="form-control item" id="birthdate" placeholder="Example: 01/01/2001" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control item" id="address" placeholder="Example: Purok. Pinetree, Brgy. Oringao, Kabankalan City, Negros Occidental." required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control item" id="username" placeholder="Example: @JuanFGSNHS" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control item" id="password" placeholder="" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" class="form-control item" id="role" name="role" value="Admin" readonly>
            </div>
            <div class="form-group">
                <label for="img">Profile Image Filename:</label>
                <input type="text" class="form-control item" id="img" placeholder="Example: juan.jpg" name="img">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create Account</button>
            </div>
        </form>
    </div>
    `;
            document.getElementById('adminForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                var name = document.getElementById('adminName').value;
                var username = document.getElementById('adminUsername').value;
                var password = document.getElementById('adminPassword').value;
                var role = document.getElementById('adminRole').value;
                var img = document.getElementById('img').value; // Get the image filename

                // Send the form data to the server using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'adbconn.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('name=' + name + '&username=' + username + '&password=' + password + '&role=' + role + '&img=' + img);

                xhr.onload = function () {
                    if (this.status == 200) {
                        // Handle the response from the server
                        var response = JSON.parse(this.responseText);
                        console.log(response);
                        if (response.message === 'New record created successfully') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Account was successfully created!'
                            });
                            // Clear the form
                            document.getElementById('adminForm').reset();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an error creating the account: ' + response.message
                            });
                        }
                    }
                };
            });
        }



        //Add Student//
        function showAddUser() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = ` <h3>Student Submitter Form</h3> <?php include 'conn.php'; ?>
            <div class="registration-form">
    <form action="submit.php" method="post" id="studentForm">
        <div class="form-group">
            <label for="fname">First Name:</label>
            <input type="text" class="form-control item" id="fname" name="fname" placeholder="Example: Juan" required>
        </div>
        <div class="form-group">
            <label for="mname">Middle Name:</label>
            <input type="text" class="form-control item" id="mname" name="mname" placeholder="Example: Dela" required>
        </div>
        <div class="form-group">
            <label for="lname">Last Name:</label>
            <input type="text" class="form-control item" id="lname" name="lname" placeholder="Example: Crunchy" required>
        </div>
        <div class="form-group">
            <label for="ename">Extension Name:</label>
            <input type="text" class="form-control item" id="ename" name="ename" placeholder="Example: Sr.">
        </div>
        <div class="form-group">
            <label for="pname">Parent's name:</label>
            <input type="text" class="form-control item" id="pname" name="pname" placeholder="Example: Pname" required>
        </div>
        <div class="form-group">
            <label for="lrn">Lrn:</label>
            <input type="text" class="form-control item" id="lrn" name="lrn" placeholder="Example: Lrn" required>
        </div>
        <div class="form-group">
            <label for="nickname">Nickname:</label>
            <input type="text" class="form-control item" id="nickname" name="nickname" placeholder="Example: Tutu" required>
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" class="form-control item" id="age" name="age" placeholder="Example: 12" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control item" id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="birthdate">Birthdate:</label>
            <input type="date" class="form-control item" id="birthdate" name="birthdate" placeholder="Example: 01/01/2001" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control item" id="address" name="address" placeholder="Example: Purok. Pinetree, Brgy. Oringao, Kabankalan City, Negros Occidental." required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control item" id="username" name="username" placeholder="Example: @JuanFGSNHS" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control item" id="password" name="password" placeholder="" required>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <input type="text" class="form-control item" id="role" name="role" value="student" readonly>
        </div>
        <div class="form-group">
            <label for="img">Image:</label>
            <input type="text" class="form-control item" id="img" name="img" placeholder="Example: image.jpg">
        </div>
        <div class="form-group">
            <label for="section">Section:</label>
            <select class="form-control item" id="section" name="section">
                <option value="section1">Section 1</option>
                <option value="section2">Section 2</option>
                <option value="section3">Section 3</option>
                <option value="section4">Section 4</option>
                <option value="section5">Section 5</option>
                <option value="section6">Section 6</option>
                <option value="section7">Section 7</option>
            </select>
        </div>
        <div class="form-group">
            <label for="yearlevel">Year Level:</label>
            <select class="form-control item" id="yearlevel" name="yearlevel">
                <option value="grade9">Grade 9</option>
                <option value="grade10">Grade 10</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Account</button>
        </div>
    </form>
</div>

`;
// Get the form element
var form = document.getElementById('studentForm');

// Attach a submit event handler to the form
form.addEventListener('submit', function(event) {
    // Prevent the form from being submitted normally
    event.preventDefault();

    // Create a new FormData object from the form
    var formData = new FormData(form);

    // Use AJAX to submit the form data
    var request = new XMLHttpRequest();
    request.open('POST', 'submit.php');
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            // The request has completed successfully
            Swal.fire(
                'Success!',
                'New record created successfully',
                'success'
            );

            // Reset the form fields
            form.reset();
        }
    };
    request.send(formData);
});
        }



        //students//
        function showManageClass() {
            var mainContent = document.getElementById('mainContent');

            // Create and configure the grade level selector
            var gradeLevelSelect = document.createElement('select');
            gradeLevelSelect.id = 'gradeLevel';
            gradeLevelSelect.className = 'form-select';
            gradeLevelSelect.style = 'width: auto; display: inline-block; margin-left: 10px;'; // Adjust styles to position near search bar
            gradeLevelSelect.onchange = function () {
                showStudents(this.value);
            };

            for (var i = 7; i <= 10; i++) {
                var option = document.createElement('option');
                option.value = 'grade' + i; // The value is the table name
                option.text = 'Grade ' + i;
                gradeLevelSelect.add(option);
            }

            // Create the table
            var table = document.createElement('table');
            table.className = 'table table-striped smaller-table';
            table.id = 'studentTable';

            var headers = ['#', 'Full Name', 'Age', 'Gender', 'Birthdate', 'Address', 'Username', 'Password', 'Section'];
            var thead = document.createElement('thead');
            var tr = document.createElement('tr');

            headers.forEach(function (header) {
                var th = document.createElement('th');
                th.scope = 'col';
                th.textContent = header;
                tr.appendChild(th);
            });

            thead.appendChild(tr);
            table.appendChild(thead);

            // Create the table body
            var tbody = document.createElement('tbody');
            table.appendChild(tbody);

            // Add the selectors and table to the main content
            mainContent.innerHTML = '<h1 style="text-align: center;">List of Students</h1>';
            mainContent.appendChild(gradeLevelSelect); // Add grade level selector
            mainContent.appendChild(table);

            // Load initial data for grade 9 (Modify this if default grade level is different)
            showStudents(gradeLevelSelect.value);
        }

        function showStudents(gradeLevel) {
            // Fetch the data from the database
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_data.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('grade=' + gradeLevel);

            xhr.onload = function () {
                if (this.status == 200) {
                    // Parse the response
                    var data = JSON.parse(this.responseText);

                    // Get the table body
                    var tbody = document.querySelector('#studentTable tbody');

                    // Clear the current table data
                    tbody.innerHTML = '';

                    // Add the new data to the table
                    data.forEach(function (row, index) {
                        var tr = document.createElement('tr');

                        // Add each column to the row
                        tr.innerHTML = `
                    <th scope="row">${index + 1}</th>
                    <td>${row.fullname}</td>
                    <td>${row.age}</td>
                    <td>${row.gender}</td>
                    <td>${row.birthdate}</td>
                    <td>${row.address}</td>
                    <td>${row.username}</td>
                    <td>${row.password}</td>
                    <td>${row.section}</td>
                `;

                        // Add the row to the table body
                        tbody.appendChild(tr);
                    });

                    // If DataTable already exists, destroy it
                    if ($.fn.DataTable.isDataTable('#studentTable')) {
                        $('#studentTable').DataTable().destroy();
                    }

                    // Initialize DataTable with search, entries control, and pagination
                    $('#studentTable').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false
                    });
                }
            };
        }

        // Ensure the function is called to render the manage class table on page load
        document.addEventListener('DOMContentLoaded', function () {
            showManageClass();
        });







        function showFaculty() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = `
        <style>
            .smaller-table {
                font-size: 0.8em; /* Adjust as needed */
                width: 80%; /* Adjust as needed */
                margin: auto;
            }
            .smaller-table th, .smaller-table td {
                padding: 5px; /* Adjust as needed */
            }
        </style>
        <h1 style="text-align: center;">List of Teachers</h1>
        <table id="adminTable" class="table table-striped smaller-table" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Age</th>
                    <th scope="col">Address</th>
                    <th scope="col">Gender</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Age</th>
                    <th scope="col">Address</th>
                    <th scope="col">Gender</th>
                </tr>
            </tfoot>
        </table>
    `;

            // Fetch the admin data from the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_teachers.php', true);
            xhr.onload = function () {
                if (this.status == 200) {
                    // Parse the JSON data
                    var teachers = JSON.parse(this.responseText);

                    // Get the table body
                    var tbody = document.querySelector('#adminTable tbody');

                    // Insert the teacher data into the table
                    for (var i = 0; i < teachers.length; i++) {
                        var tr = document.createElement('tr');
                        var fullname = `${teachers[i].fname} ${teachers[i].mname} ${teachers[i].lname} ${teachers[i].ename}`;
                        tr.innerHTML = `
                    <th scope="row">${i + 1}</th>
                    <td>${fullname}</td>
                    <td>${teachers[i].age}</td>
                    <td>${teachers[i].address}</td>
                    <td>${teachers[i].gender}</td>
                `;
                        tbody.appendChild(tr);
                    }

                    // Initialize DataTable
                    $('#adminTable').DataTable();
                }
            };
            xhr.send();
        }

        // Ensure the function is called to render the teachers table
        document.addEventListener('DOMContentLoaded', showFaculty);

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>