<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "pet_adoption";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form inputs
$fullName = $_POST['fullName'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$gmail = $_POST['gmail'];
$petType = $_POST['petType'];
$petBreed = $_POST['petBreed'];
$description = $_POST['description'];

// Handle image upload
$imagePath = "";
if (isset($_FILES['petImage']) && $_FILES['petImage']['error'] == 0) {
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $fileName = basename($_FILES['petImage']['name']);
    $targetFilePath = $uploadDir . time() . '_' . $fileName;
    move_uploaded_file($_FILES['petImage']['tmp_name'], $targetFilePath);
    $imagePath = $targetFilePath;
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO inquiries (fullName, phone, email, address, gmail, petType, petBreed, description, imagePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $fullName, $phone, $email, $address, $gmail, $petType, $petBreed, $description, $imagePath);

if ($stmt->execute()) {
    echo "Your inquiry has been submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
