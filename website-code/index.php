<?php
include_once('classes/common.php');
//initiate classes
$PageData = new CommonPage();

//build page
echo $PageData->doctype();
echo $PageData->metaData();
echo $PageData->title("SOQ Home");
?>
</head>
<body>
    <div id="wrapper">
        <div id="header"><?php echo $PageData->headerText("Rate WCC Instructors");?></div>
        <?php echo $PageData->navBar(); ?>
        <div id="content">            
            <h2>Washtenaw Community College students, </h2>
            <p>This site is a resource for you, to help you make informed decisions about which instructors will guide your education. The data you will find in the instructor search results is compiled from the past several years of student opinion questionnaires filled out by your peers. </p>
            <p>The Washtenaw Voice grouped the questions by topic to make the data more useful. The four areas are: organization and preparation, effectiveness and helpfulness, grading methods and “would recommend.”</p>
            <p>We know that nearly every college student has used RateMyProfessor.com to choose between different instructors. The website allows anyone to post anonymously as many times as they want. This means posts can be made by non-WCC students, by the instructors themselves, or one person can post ten times if they really hate an instructor. It does not present a fair or statistically accurate picture of how students feel about their teachers. We believe the data we’ve presented is the best alternative to that system.</p>
            While these evaluations should be taken with a grain of salt, they do present a fairer picture that students, who are making an investment with each class, deserve to see. </p>
            <p>We plan to add a comments section soon that will require a WCC email to post.</p>
            <p>-Natalie Wright, Editor, The Washtenaw Voice</p>
        </div><!--end content wrapper-->
     </div>
     <?php echo $PageData->Footer(); ?>
     <?php include_once("analyticstracking.php") ?>
    </body>
</html>