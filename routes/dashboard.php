<?php
session_start();
include("../api/connect.php"); // Ensure correct path

// Redirect if user is not logged in
if (!isset($_SESSION['userdata'])) {
    header("Location: ../index.html");
    exit();
}

$userdata = $_SESSION['userdata'];
$groupsdata = $_SESSION['groupsdata'];
$status = ($_SESSION['userdata']['status'] == 0) ? '<b style="color:red"> Not Voted</b>' : '<b style="color:green"> Voted</b>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
</head>
<body>
<style>  
        #backbtn{
        padding: 5px;
        font-size: 15px;
        border-radius: 5px ;  
        background-color: blue ;
        color: white;
        float: left;
        margin: 10px;
        }
        #logoutbtn{
        float: right;
        position:right ;
        padding: 5px;
        border-radius: 5px ;  
        background-color: blue ;
        color: white;
        margin: 10px;
        }
        #Profile{
            background-color: white;
            width: 30%;
            padding: 20px;
            float: left;
        }
        #Group{
            background-color: white;
            width: 60%;
            padding: 20px;
            float: right;
        }
        #votebtn{
        padding: 5px;
        font-size: 15px;
        border-radius: 5px ;  
        background-color: blue ;
        color: white;
        float: left;
        }
        #mainpanel{
            padding: 10px;
        }
        #voted{
        padding: 5px;
        font-size: 15px;
        border-radius: 5px ;  
        background-color: green ;
        color: white;
        float: left;
        }
       
    </style>

    <div id="mainsection">
        <div id="headersection">
            <a href="../"><button id="backbtn">Back</button></a>
            <a href="logout.php"><button id="logoutbtn">Logout</button></a>
            <center><h1>Online Voting System</h1></center>
        </div>
        <hr>
        <div id="mainpanel">
            <div id="Profile">
                <center><img src="../uploads/<?php echo $userdata['photo']; ?>" height="150" width="100"></center><br><br>
                <b>Name:</b> <?php echo $userdata['name']; ?><br><br>
                <b>Mobile:</b> <?php echo $userdata['mobile']; ?><br><br>
                <b>Address:</b> <?php echo $userdata['address']; ?><br><br>
                <b>Status:</b> <?php echo $status; ?><br><br>
            </div>
            <div id="Group">
                <?php 
                if ($groupsdata) {
                    foreach ($groupsdata as $group) { ?>
                        <div>
                            <img style="float:right" src="../uploads/<?php echo $group['photo']; ?>" height="100" width="100"><br><br>
                            <b>Group Name:</b> <?php echo $group['name']; ?><br><br>
                            <b>Votes:</b> <?php echo $group['votes']; ?><br><br>
                            <form action="../api/vote.php" method="POST">
                                <input type="hidden" name="gvotes" value="<?php echo $group['votes']; ?>">
                                <input type="hidden" name="gid" value="<?php echo $group['id']; ?>">

                                <?php 
                                if ($_SESSION['userdata']['status']==0) { ?>
                                    <input type="submit" name="votebtn" value="Vote" id="votebtn">
                                <?php } else { ?>
                                    <button disabled type="button" id="voted">Voted</button>
                                <?php } ?>
                            </form>
                        </div>
                        <hr>
                    <?php }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
