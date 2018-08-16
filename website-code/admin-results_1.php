<?php
include_once('classes/common.php');
include_once('db/connection.php');
//initiate classes
$PageData = new CommonPage();

//build page
echo $PageData->doctype();
echo $PageData->metaData();
echo $PageData->title("SOQ Search");

//temporary variable for testing purposes, instructor ID's start at 1 and go to ???

$instructor_id = 1;
//$instructor_id = $_REQUEST['instructor']

//search code to generate the instructors list for selection menu
//$sql = "SELECT * FROM instructors where id = $instructor_id";
$sql = "SELECT * FROM instructors ORDER BY lname asc";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$row_cnt = mysqli_num_rows($result);


//do the error check here for the proper form submission
//all instructor ID's are numeric values between 1 and 3 digits
//need to add a regular expression for error checking and security
//on submit do the error check first
    function errChk(){
        $instructorID = $_REQUEST['instructor'];
        //$instructorID = 'b';//test case for the regular expression
        
        //must be 1 to 3 digits, numeric and not null                
        if (preg_match("/[0-9]{1,3}/", $instructorID)){
            echo "I'm in the error check.<br/>";
            echo "instructorID: ".$_REQUEST['instructor']."<br/>";
           //rptHdr();//if all is well go start the report 
      
        }
        //if the entry is not a 1-3 digit number then show error
        else{
            echo "<strong>Error: not a valid selection</strong>";
        } 
    };//end of error checking

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
array_push($overall, $total_cat1);
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
array_push($overall, $total_cat2);
$answer_cat2 = $total_cat2 / $row_cnt_cat2;

//search Category 3, "Grading Methods"
//the SKL question set does not have this category so we need to display "n/a" or something
$sql_cat3 = "SELECT answers.answer FROM questions INNER JOIN answers ON questions.fk_QuestionSetID = answers.fk_QuestionSetID AND questions.SOQnum = answers.SOQnum WHERE questions.fk_Category = 3 and answers.fk_InstructorID = $instructor_id";
$result_cat3 = mysqli_query($db, $sql_cat3);
$row_cnt_cat3 = mysqli_num_rows($result_cat3);

//push the query results into an array
//need an if else stament here, see if row count is null
if($row_cnt_cat3 === 0){
    //echo "n/a";
}else{    
    $arr_cat3 = array();
    while ($row_cat3 = mysqli_fetch_assoc($result_cat3)){
        array_push($arr_cat3, $row_cat3['answer']);
    }
    $total_cat3 = array_sum($arr_cat3);
    array_push($overall, $total_cat3);
    $answer_cat3 = $total_cat3 / $row_cnt_cat3;
}

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
//not all Question sets have all 4 category groups so need to do an array count and divide by row count
//the array should have 3 or 4 values in it depending on the question set
//3 values if its an SKL (type 3 question set)
//4 values if its a FT/PT or DL (type 1,2,4,5 question set)
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
            <p>Row count: <?php echo $row_cnt_cat1 ?></p>
            <p>Total of array:  <?php echo $total_cat1 ?></p>
            <p>Overall Score: <?php echo $overall_score ?> </p>
            <p>show me the overall array: <?php echo $overall ?>  </p>
            <p>show me the overall array count: </p>
            <p>Organization & Preparedness: <?php echo $answer_cat1 ?></p>
            <p>Effectiveness & Helpfulness: <?php echo $answer_cat2 ?></p>
            <p>Grading Methods: <?php echo $answer_cat3 ?></p>
            <p>show me the row count for Category 3: <?php echo $row_cnt_cat3 ?></p>
            <p>Would Recommend: <?php echo $answer_cat4 ?></p>
            
        </div><!--end content wrapper-->
     </div>
     <?php echo $PageData->Footer(); ?>
     <?php include_once("analyticstracking.php") ?>
    </body>
</html>