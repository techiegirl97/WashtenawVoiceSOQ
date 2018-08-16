<?php
include_once('classes/common.php');
include_once('db/connection.php');
//initiate classes
$PageData = new CommonPage();

//build page
echo $PageData->doctype();
echo $PageData->metaData();
echo $PageData->title("SOQ Search");

//search code
$sql = "SELECT * FROM instructors ORDER BY lname asc";
$result = mysqli_query($db, $sql);
//$row = mysqli_fetch_assoc($result);

$acknowledgment = "<p>&nbsp;</p>";

if (isset($_POST['submit'])){
	if ($_POST['login']===$adminPanel){
		session_start();
		$_SESSION['admin'] = "authorized";
		//header('Location: admin.php');
                
                //$acknowledgment = "<h2>Admin Panel</h2><p><a href='admin-instructors.php'>List/Edit Instructors</a></p><p><a href='admin-questions.php'>List/Edit Questions</a></p";
 	}
	else{
		$acknowledgment = "<p class='error'>Incorrect Login</p>";
	}
}

?>
</head>
<body>
    <div id="wrapper">
        <div id="header"><?php echo $PageData->headerText("SOQ Search");?></div>
        <?php echo $PageData->navBar(); ?>
        <div id="content">
            <h2>Instructors List</h2>
    
    <table border="1" class="accountsTable">
        <thead>
        <th>Last Name</th>
        <th>First Name</th>
        <th>edit</th>
        </thead>             
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['lname']; ?></td>
            <td><?= $row['fname']; ?></td>            
            <td><a href="#">Edit...</a></td>

        </tr>
        <?php } ?>
    </table>
            
        </div><!--end content wrapper-->
     </div>
     <?php echo $PageData->Footer(); ?>
     <?php include_once("analyticstracking.php") ?>
    </body>
</html>