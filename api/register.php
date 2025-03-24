<?php
include("connect.php");

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $mobile = mysqli_real_escape_string($connect, $_POST['mobile']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $role = mysqli_real_escape_string($connect, $_POST['role']);

    // Validate mobile number format
    if (!preg_match('/^\d{10}$/', $mobile)) {
        echo '<script>alert("Invalid mobile number! Enter a 10-digit number."); window.location = "../routes/register.html";</script>';
        exit();
    }

    // Handle file upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $image = basename($_FILES['photo']['name']);
        $tmp_name = $_FILES['photo']['tmp_name'];
        $upload_dir = "../uploads/";

        // Validate file type and size
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (in_array($_FILES['photo']['type'], $allowed_types) && $_FILES['photo']['size'] <= $max_size) {
            move_uploaded_file($tmp_name, $upload_dir . $image);
        } else {
            echo '<script>alert("Invalid file type or size! Only JPEG, PNG, and GIF files up to 5MB are allowed."); window.location = "../routes/register.html";</script>';
            exit();
        }
    } else {
        echo '<script>alert("File upload error!"); window.location = "../routes/register.html";</script>';
        exit();
    }

    // Validate password match
    if ($password === $cpassword) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database using prepared statement
        $stmt = $connect->prepare("INSERT INTO user (name, mobile, address, password, photo, role, status, votes) 
            VALUES (?, ?, ?, ?, ?, ?, 0, 0)");
        $stmt->bind_param("ssssss", $name, $mobile, $address, $hashed_password, $image, $role);

        if ($stmt->execute()) {
            echo '<script>alert("Registered Successfully"); window.location = "../";</script>';
        } else {
            echo '<script>alert("Some error occurred while registering!"); window.location = "../routes/register.html";</script>';
        }
        $stmt->close();
    } else {
        echo '<script>alert("Password and Confirm Password do not match!"); window.location = "../routes/register.html";</script>';
    }
}
?>
