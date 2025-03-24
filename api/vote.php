<?php
session_start();
include 'connect.php';

// Ensure votes are treated as an integer
$votes = intval($_POST['gvotes']);
$total_votes = $votes + 1;
$gid = $_POST['gid'];
$uid = $_SESSION['userdata']['id'];

// Update the votes for the selected group
$update_votes = mysqli_query($connect, "UPDATE user SET votes='$total_votes' WHERE id='$gid'");

// Update the user's status to "voted"
$update_user_status = mysqli_query($connect, "UPDATE user SET status=1 WHERE id='$uid'");

// Track voted groups in session
if (!isset($_SESSION['userdata']['voted_groups'])) {
    $_SESSION['userdata']['voted_groups'] = [];
}
$_SESSION['userdata']['voted_groups'][] = $gid;

if ($update_votes && $update_user_status) {
    // Fetch updated group data
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
    $_SESSION['groupsdata'] = mysqli_fetch_all($groups, MYSQLI_ASSOC);
    $_SESSION['userdata']['status'] = 1;

    echo '
    <script>
        alert("Voting Successful!"); 
        window.location = "../routes/dashboard.php";
    </script>';
} else {
    echo '
    <script>
        alert("Some Error Occurred!"); 
        window.location = "../routes/dashboard.php";
    </script>';
}
?>
