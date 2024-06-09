<?php
session_start();
if ($_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}
?>

<?php include 'hui.php' ?>
<?php include 'adduser.php'; ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/datatables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="style.css" />

<body>
    <div class="container-fluid">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="logo.jpg" alt="logo" />
                <div class="header-text">
                    <h2>Student</h2>
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
                font-size: 0.6em; /* Adjust as needed */
                width: 80%; /* Adjust as needed */
                margin: auto;
            }
            .smaller-table th, .smaller-table td {
                padding: 5px; /* Adjust as needed */
            }
        </style>
        <h1 style="text-align: center;">List of Admins</h1>
        <table class="table" id="adminTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Fullname</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Address</th>
                    <th scope="col">Email</th>

                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    `;

            // Fetch the admin data from the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_admins.php', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    // Parse the JSON data
                    var admins = JSON.parse(this.responseText);

                    // Get the table body
                    var tbody = document.querySelector('#adminTable tbody');

                    // Insert the admin data into the table
                    for (var i = 0; i < admins.length; i++) {
                        var tr = document.createElement('tr');
                        tr.innerHTML = '<th scope="row">' + (i + 1) + '</th>' +
                            '<td>' + admins[i].name + '</td>' +
                            '<td>' + admins[i].username + '</td>' +
                            '<td>' + admins[i].password + '</td>';
                        tbody.appendChild(tr);
                    }
                }
            };
            xhr.send();
        }

        //Add Teacher//
        function showNewTeacher() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = `  <?php include 'conn.php'; ?>
            
    <h3>Teacher Submitter Form</h3>
        <div class="registration-form">
        <form id="teacherForm">
                <div class="form-group">
                    <input type="text" class="form-control item" id="name" placeholder="Fullname" name="name" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control item" id="age" placeholder="Age" name="age" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control item" id="birthdate" placeholder="Birthdate" name="birthdate" required>
                </div>
                <div class="form-group">
                    <select class="form-control item" id="gender" placeholder="Gender" name="gender" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control item" id="email" placeholder="Email" name="email" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control item" id="username" placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control item" id="password" placeholder="Password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <input type="text" class="form-control item" id="role" name="role" value="teacher" readonly>
                </div>
                <div class="form-group">
                <label for="img">Profile Image URL:</label>
                <input type="url" class="form-control item" id="img" placeholder="Profile Image URL" name="img" required>
            </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Account</button>                
                </div>
            </form>
        </div>
    `;
            document.getElementById('teacherForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var name = document.getElementById('name').value;
                var age = document.getElementById('age').value;
                var birthdate = document.getElementById('birthdate').value;
                var gender = document.getElementById('gender').value;
                var email = document.getElementById('email').value;
                var username = document.getElementById('username').value;
                var password = document.getElementById('password').value;
                var role = document.getElementById('role').value;
                var img = document.getElementById('img').value; // Get the image URL

                // Send the form data to the server using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'tdbconn.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('name=' + name + '&age=' + age + '&birthdate=' + birthdate + '&gender=' + gender + '&email=' + email + '&username=' + username + '&password=' + password + '&role=' + role + '&img=' + img);

                xhr.onload = function() {
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
        <input type="text" class="form-control item" id="adminName" placeholder="Fullname">
    </div>
    <div class="form-group">
        <input type="text" class="form-control item" id="adminUsername" placeholder="Username">
    </div>
    <div class="form-group">
        <input type="password" class="form-control item" id="adminPassword" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="role">Role:</label>
        <input type="text" class="form-control item" id="adminRole" name="role" value="Admin" readonly>
    </div>
    <div class="form-group">
                <label for="img">Profile Image URL:</label>
                <input type="url" class="form-control item" id="img" placeholder="Profile Image URL" name="img" required>
            </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Create Account</button>
    </div>
</form>

        </div>
    `;
            document.getElementById('adminForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var name = document.getElementById('adminName').value;
                var username = document.getElementById('adminUsername').value;
                var password = document.getElementById('adminPassword').value;
                var role = document.getElementById('adminRole').value;
                var img = document.getElementById('img').value; // Get the image URL

                // Send the form data to the server using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'adbconn.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('name=' + name + '&username=' + username + '&password=' + password + '&role=' + role + '&img=' + img);

                xhr.onload = function() {
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
            <form action="admin.php" method="POST">
    <div class="registration-form">
        <div class="form-group">
            <label for="name">Fullname:</label>
            <input type="text" class="form-control item" id="name" placeholder="Fullname" name="name" required>
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="text" class="form-control item" id="age" placeholder="Age" name="age" required>
        </div>
        <div class="form-group">
            <label for="birthdate">Birthdate:</label>
            <input type="text" class="form-control item" id="birthdate" placeholder="Birth Date" name="birthdate" required>
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <select class="form-control item" id="gender" placeholder="Select Gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>            
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control item" id="address" placeholder="Address" name="address" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control item" id="email" placeholder="Email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="text" class="form-control item" id="password" placeholder="Password" name="password" required>
        </div>
        <div class="form-group" id="yearlevel-selector">
            <label for="yearlevel">Grade Level:</label>
            <select class="form-control item" id="yearlevel" placeholder="Select Year Level" name="yearlevel" required>
                <option value="grade9">Grade 9</option>
                <option value="grade10">Grade 10</option>
            </select>
        </div>
        <div class="form-group">
            <label for="role">Role:</label>
            <input type="text" class="form-control item" id="role" name="role" value="student" readonly>
        </div>
        <div class="form-group" id="section-selector">
            <label for="section">Section:</label>
            <select class="form-control item" id="section" placeholder="Select Section" name="section" required>
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
                <label for="img">Profile Image URL:</label>
                <input type="url" class="form-control item" id="img" placeholder="Profile Image URL" name="img" required>
            </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Account</button>
        </div>
    </div>
</form>
`;

            document.getElementById('mainContent').addEventListener('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var name = document.getElementById('name').value;
                var age = document.getElementById('age').value;
                var birthdate = document.getElementById('birthdate').value;
                var gender = document.getElementById('gender').value;
                var address = document.getElementById('address').value;
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
                var role = document.getElementById('role').value;
                var section = document.getElementById('section').value;
                var yearlevel = document.getElementById('yearlevel').value;
                var img = document.getElementById('img').value; // Get the image URL

                // Send the form data to the server using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'sdbconn.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('name=' + name + '&age=' + age + '&birthdate=' + birthdate + '&gender=' + gender + '&address=' + address + '&email=' + email + '&password=' + password + '&role=' + role + '&section=' + section + '&yearlevel=' + yearlevel + '&img=' + img);

                xhr.onload = function() {
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
                            document.getElementById('mainContent').reset();
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

        function showManageClass() {
            var mainContent = document.getElementById('mainContent');

            // Create and configure the grade level selector
            var gradeLevelSelect = document.createElement('select');
            gradeLevelSelect.id = 'gradeLevel';
            gradeLevelSelect.onchange = function() {
                showSections(this.value);
            };

            for (var i = 7; i <= 10; i++) {
                var option = document.createElement('option');
                option.value = 'grade' + i; // The value is the table name
                option.text = 'Grade ' + i;
                gradeLevelSelect.add(option);
            }

            // Create and configure the section selector
            var sectionSelect = document.createElement('select');
            sectionSelect.id = 'section';

            for (var i = 1; i <= 7; i++) {
                var option = document.createElement('option');
                option.value = 'section' + i; // The value is the section name
                option.text = 'Section ' + i;
                sectionSelect.add(option);
            }

            // Create the table
            var table = document.createElement('table');
            table.className = 'table';

            var headers = ['#', 'Full Name', 'Age', 'Gender', 'Birthdate', 'Address', 'Username', 'Password', 'Role', 'Section'];
            var thead = document.createElement('thead');
            var tr = document.createElement('tr');

            headers.forEach(function(header) {
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
            mainContent.appendChild(gradeLevelSelect);
            mainContent.appendChild(sectionSelect);
            mainContent.appendChild(table);
        }

        function showSections(gradeLevel) {
            var sectionSelect = document.getElementById('section');
            sectionSelect.innerHTML = ''; // Clear the current options

            for (var i = 1; i <= 7; i++) {
                var option = document.createElement('option');
                option.value = i;
                option.text = 'Section ' + i;
                sectionSelect.add(option);
            }

            // Fetch the data from the database
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_data.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('grade=' + gradeLevel);

            xhr.onload = function() {
                if (this.status == 200) {
                    // Parse the response
                    var data = JSON.parse(this.responseText);

                    // Get the table body
                    var tbody = document.querySelector('#mainContent table tbody');

                    // Clear the current table data
                    tbody.innerHTML = '';

                    // Add the new data to the table
                    data.forEach(function(row) {
                        var tr = document.createElement('tr');

                        // Add each column to the row
                        Object.values(row).forEach(function(value) {
                            var td = document.createElement('td');
                            td.textContent = value;
                            tr.appendChild(td);
                        });

                        // Add the row to the table body
                        tbody.appendChild(tr);
                    });
                }
            };
        }





        function showFaculty() {
            var mainContent = document.getElementById('mainContent');
            mainContent.innerHTML = `
        <style>
            .smaller-table {
                font-size: 0.6em; /* Adjust as needed */
                width: 80%; /* Adjust as needed */
                margin: auto;
            }
            .smaller-table th, .smaller-table td {
                padding: 5px; /* Adjust as needed */
            }
        </style>
        <h1 style="text-align: center;">List of Teachers</h1>
        <table class="table" id="teacherTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Birthdate</th>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    `;

            // Fetch the teacher data from the server using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch_teachers.php', true);
            xhr.onload = function() {
                if (this.status == 200) {
                    // Parse the JSON data
                    var teachers = JSON.parse(this.responseText);

                    // Get the table body
                    var tbody = document.querySelector('#teacherTable tbody');

                    // Insert the teacher data into the table
                    for (var i = 0; i < teachers.length; i++) {
                        var tr = document.createElement('tr');
                        tr.innerHTML = '<th scope="row">' + (i + 1) + '</th>' +
                            '<td>' + teachers[i].name + '</td>' +
                            '<td>' + teachers[i].gender + '</td>' +
                            '<td>' + teachers[i].birthdate + '</td>' +
                            '<td>' + teachers[i].email + '</td>' +
                            '<td>' + teachers[i].username + '</td>' +
                            '<td>' + teachers[i].password + '</td>' +
                            '<td>' + teachers[i].role + '</td>';
                        tbody.appendChild(tr);
                    }
                }
            };
            xhr.send();
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>