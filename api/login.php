<?php
session_start();
include("connect.php"); 

if (isset($_POST['loginbutton']))
{
    $mobile = mysqli_real_escape_string($connect, $_POST['mobile']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $role = mysqli_real_escape_string($connect, $_POST['role']);

    // Fetch user details
    $query = "SELECT * FROM user WHERE mobile = '$mobile' AND role = '$role'";
    $check = mysqli_query($connect, $query);

    if (mysqli_num_rows($check) > 0) {
        $userdata=mysqli_fetch_array($check);
        $groups=mysqli_query($connect,"select * from user where role=2");
        $groupdata = mysqli_fetch_all($groups,MYSQLI_ASSOC);

        $_SESSION['userdata']=$userdata;
        $_SESSION['groupsdata']=$groupdata;
        header("Location: ../routes/dashboard.php");
       
        
    } 
    else 
    {
        echo '<script>alert("User not found please register !"); window.location = "../routes/register.html";</script>';
    }
    
}   
else 
{
        echo '<script>alert("User not found or invalid credentials!"); window.location = "../routes/register.html";</script>';
}



