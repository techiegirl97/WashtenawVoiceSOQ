<?php
include_once('../classes/common.php');
//initiate classes
$PageData = new CommonPage();

//build page
echo $PageData->doctype();
echo $PageData->metaData();
echo $PageData->title("404 Page Not Found");
?>
</head>
<body>
    <div id="wrapper">
        <div id="header"><?php echo $PageData->headerText("404 Page Not Found");?></div>
        <?php echo $PageData->navBar(); ?>
        <div id="content">
            <h2>404 Error</h2>
            <p>Nothing to see here.</p>
        </div><!--end content wrapper-->
     </div>
     <?php echo $PageData->Footer(); ?>
     <?php include_once("analyticstracking.php") ?>
    </body>
</html>