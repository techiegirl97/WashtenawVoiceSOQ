<?php
include_once('classes/common.php');
include_once('db/connection.php');
//require_once('classes/PageData.php');


//initiate classes
$PageData = new CommonPage();
//build page
echo $PageData->doctype();
echo $PageData->metaData();
echo $PageData->title("SOQ Search");


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
            
    		<?php echo $acknowledgment; ?>
		<form method="post" action="admin.php" id="admin">
			<div>
				<label>Login: <input type="password" name="login" id="adminLogin" /></label>
				<input type="submit" name="submit" value="Login"/>
			</div>
		</form>

            
        </div><!--end content wrapper-->
     </div>
     <?php echo $PageData->Footer(); ?>
     <?php include_once("analyticstracking.php") ?>
    <script>document.getElementById('adminLogin').focus();</script>
    </body>
</html>