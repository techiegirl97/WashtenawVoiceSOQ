<?php
include_once('classes/common.php');
include_once('db/connection.php');
//initiate classes
$PageData = new CommonPage();

//build page
echo $PageData->doctype();
echo $PageData->metaData();
echo $PageData->title("SOQ Search");

$instructor_id = 162;

//search code
$sql = "SELECT * FROM instructors where id = $instructor_id";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$row_cnt = mysqli_num_rows($result);

//need to enter $_REQUEST for instructor ID
//search Category 1, Organization & Preparedness
$sql_cat1 = "SELECT answers.answer FROM questions INNER JOIN answers ON questions.fk_QuestionSetID = answers.fk_QuestionSetID AND questions.SOQnum = answers.SOQnum WHERE questions.fk_Category = 1 and answers.fk_InstructorID = $instructor_id";
$result_cat1 = mysqli_query($db, $sql_cat1);
$row_cnt_cat1 = mysqli_num_rows($result_cat1);

//push the query results into an array
$arr_cat1 = array();
while ($row_cat1 = mysqli_fetch_assoc($result_cat1)){
    array_push($arr_cat1, $row_cat1['answer']);
}
$total_cat1 = array_sum($arr_cat1);
$answer_cat1 = $total_cat1 / $row_cnt_cat1;


//search Category 2, 
$sql_cat2 = "SELECT answers.answer FROM questions INNER JOIN answers ON questions.fk_QuestionSetID = answers.fk_QuestionSetID AND questions.SOQnum = answers.SOQnum WHERE questions.fk_Category = 2 and answers.fk_InstructorID = $instructor_id";
$result_cat2 = mysqli_query($db, $sql_cat2);
$row_cnt_cat2 = mysqli_num_rows($result_cat2);

//push the query results into an array
$arr_cat2 = array();
while ($row_cat2 = mysqli_fetch_assoc($result_cat2)){
    array_push($arr_cat2, $row_cat2['answer']);
}
$total_cat2 = array_sum($arr_cat2);
$answer_cat2 = $total_cat2 / $row_cnt_cat2;

//search Category 3
$sql_cat3 = "SELECT answers.answer FROM questions INNER JOIN answers ON questions.fk_QuestionSetID = answers.fk_QuestionSetID AND questions.SOQnum = answers.SOQnum WHERE questions.fk_Category = 3 and answers.fk_InstructorID = $instructor_id";
$result_cat3 = mysqli_query($db, $sql_cat3);
$row_cnt_cat3 = mysqli_num_rows($result_cat3);

//push the query results into an array
$arr_cat3 = array();
while ($row_cat3 = mysqli_fetch_assoc($result_cat3)){
    array_push($arr_cat3, $row_cat3['answer']);
}
$total_cat3 = array_sum($arr_cat3);
$answer_cat3 = $total_cat3 / $row_cnt_cat3;

//search Category 4
$sql_cat4 = "SELECT answers.answer FROM questions INNER JOIN answers ON questions.fk_QuestionSetID = answers.fk_QuestionSetID AND questions.SOQnum = answers.SOQnum WHERE questions.fk_Category = 4 and answers.fk_InstructorID = $instructor_id";
$result_cat4 = mysqli_query($db, $sql_cat4);
$row_cnt_cat4 = mysqli_num_rows($result_cat4);

//push the query results into an array
$arr_cat4 = array();
while ($row_cat4 = mysqli_fetch_assoc($result_cat4)){
    array_push($arr_cat4, $row_cat4['answer']);
}
$total_cat4 = array_sum($arr_cat4);
array_push($overall, $total_cat4);
$answer_cat4 = $total_cat4 / $row_cnt_cat4;


//now calculate an overall score
//not all Question sets have all 4 categories so need to do an array count and divide by row count
$overall = array();

?>
</head>
<body>
    <div id="wrapper">
        <div id="header"><?php echo $PageData->headerText("SOQ Search");?></div>
        <?php echo $PageData->navBar(); ?>
        <div id="content">
            <h2>Sample Results</h2>
            <p>Instructor: <?= $row['lname']; ?>,<?= $row['fname']; ?> </p>                        
            
            <p>Overall Score: <?php echo $overall_score ?> </p>
                <hr/>
            <p>Organization & Preparedness (cat1): <?php echo $answer_cat1 ?></p>
                <p>Total of array cat1:  <?php echo $total_cat1 ?></p>
                <p>Row count cat1: <?php echo $row_cnt_cat1 ?></p>
                <hr/>
            <p>Effectiveness & Helpfulness (cat2): <?php echo $answer_cat2 ?></p>
                <p>Total of array cat2:  <?php echo $total_cat2 ?></p>
                <p>Row count cat2: <?php echo $row_cnt_cat2 ?></p>
                <hr/>                        
            <p>Grading Methods: <?php echo $answer_cat3 ?></p>
                <p>Total of array cat3:  <?php echo $total_cat3 ?></p>
                <p>Row count cat3: <?php echo $row_cnt_cat3 ?></p>
                <hr/>
            <p>Would Recommend: <?php echo $answer_cat4 ?></p>
                <p>Total of array cat4:  <?php echo $total_cat4 ?></p>
                <p>Row count cat4: <?php echo $row_cnt_cat4 ?></p>
            
        </div><!--end content wrapper-->
     </div>
     <?php echo $PageData->Footer(); ?>
     <?php include_once("analyticstracking.php") ?>
    </body>
</html>