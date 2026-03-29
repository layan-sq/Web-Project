
<?php

// اسم المستخدم وكلمة المرور
$username = 'admin';
$password = '12345';

// فحص بيانات تسجيل الدخول
if (!isset($_SERVER['PHP_AUTH_USER']) || $_SERVER['PHP_AUTH_USER'] !== $username || $_SERVER['PHP_AUTH_PW'] !== $password) {
    // طلب المصادقة
    header('WWW-Authenticate: Basic realm="Protected Area"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Access denied. You need to log in with a valid username and password.';
    exit();
}



// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Zahra1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add new data
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $symptoms = $_POST['symptoms'];

    $sql = "INSERT INTO mental_health (name, description, symptoms) VALUES ('$name', '$description', '$symptoms')";
    if ($conn->query($sql) === TRUE) {
        echo "New disorder added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Edit existing data
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $symptoms = $_POST['symptoms'];

    $sql = "UPDATE mental_health SET name='$name', description='$description', symptoms='$symptoms' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Disorder updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Delete data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM mental_health WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Disorder deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch disorders
$sql = "SELECT * FROM mental_health";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Disorders Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F8EDE3; /* Light pink background */
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #C5705D; /* Dark pink for headers */
        }
        .disorder {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #C5705D; /* Pink left border */
        }
        .disorder h2 {
            color: #C5705D;
        }
        .disorder p {
            margin: 10px 0;
        }
        .form-input {
            margin: 10px 0;
            padding: 8px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .link {
            background-color: #D0B8A8;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer
        }
       
    </style>
</head>
<body>

    <h1>Mental Health Disorders Management</h1>

    <!-- Add new disorder form -->
    <h2>Add a New Disorder</h2>
    <form method="POST" action="">
        <input type="text" name="name" class="form-input" placeholder="Disorder Name" required>
        <textarea name="description" class="form-input" placeholder="Description" required></textarea>
        <textarea name="symptoms" class="form-input" placeholder="Symptoms" required></textarea>
        <button type="submit" name="add" class="button">Add Disorder</button>
    </form>

    <hr>

    <!-- Display list of disorders -->
    <h2>List of Disorders</h2>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="disorder">';
            echo '<h2>' . $row['name'] . '</h2>';
            echo '<p><strong>Description:</strong> ' . $row['description'] . '</p>';
            echo '<p><strong>Symptoms:</strong> ' . $row['symptoms'] . '</p>';
            echo '<a href="?delete=' . $row['id'] . '" class="button">Delete</a>';
            echo ' <a href="#editForm" class="button" onclick="editForm(' . $row['id'] . ', \'' . $row['name'] . '\', \'' . $row['description'] . '\', \'' . $row['symptoms'] . '\')">Edit</a>';
            echo '</div>';
        }
    } else {
        echo "No disorders found.";
    }
    ?>

    <!-- Edit disorder form (hidden by default) -->
    <form id="editForm" method="POST" action="" style="display: none;">
        <h2 id="editFormTitle">Edit Disorder</h2>
        <input type="hidden" id="editId" name="id">
        <input type="text" id="editName" name="name" class="form-input" placeholder="Disorder Name" required>
        <textarea id="editDescription" name="description" class="form-input" placeholder="Description" required></textarea>
        <textarea id="editSymptoms" name="symptoms" class="form-input" placeholder="Symptoms" required></textarea>
        <button type="submit" name="edit" class="button">Update Disorder</button>
    </form>

    <script>
        // Function to fill the edit form with existing data
        function editForm(id, name, description, symptoms) {
            document.getElementById("editId").value = id;
            document.getElementById("editName").value = name;
            document.getElementById("editDescription").value = description;
            document.getElementById("editSymptoms").value = symptoms;
            document.getElementById("editForm").style.display = "block";
            document.getElementById("editFormTitle").style.display = "block";
        }
    </script>
    <br>
<a href="page1.html" class="link">Go to Home page</a>
</body>
</html>

<?php
// Close connection
$conn->close();

?>