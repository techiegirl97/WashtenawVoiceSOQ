<?php
include_once('classes/common.php');
include_once('db/connection.php');
//initiate classes
$PageData = new CommonPage();

//build page
echo $PageData->doctype();
echo $PageData->metaData();
echo $PageData->title("Search by Instructor");

//create a list of instructors for the drop down box
$sql = "SELECT * FROM instructors ORDER BY lname asc";
$result = mysqli_query($db, $sql);

/////////////////////////////////////////////////////////////////////////

//error check the submittal
    
    function errChk(){
        $instructorID = $_REQUEST['instructor'];
        //$instructorID = 'b';//test case for the regular expression
        
        //must be 1 to 3 digits, numeric and not null                
        if (preg_match("/[0-9]{1,3}/", $instructorID)){            
            rptHdr();//if all is well go start the report                                         
        }
        //if the entry is not a 1-3 digit number then show error
        else{
            echo "<strong>Error: not a valid selection</strong>";
        } 
    }//end of error checking
    
//start the report header

//set up some global variables
//the overall score will be the mean score from the other 4 categories    
$overall = array();

//the report array is used to display each category result
$report = array();
    
    function rptHdr(){
        $instructorID = $_REQUEST['instructor'];
        global $db;
        $sql_name = "SELECT * FROM instructors WHERE id=$instructorID";
        $result_name = mysqli_query($db, $sql_name);
        $row_name = mysqli_fetch_assoc($result_name);

        echo "<h3 class='instructor'>".$row_name['fname']." ".$row_name['lname']."</h3>";
        
        results_1();
    }//end of report header
    
//Do the Category 1 search, "Organization & Preparedness"
    function results_1(){
        $instructorID = $_REQUEST['instructor'];
        global $db;
        global $overall;
        global $report;                

        //search Category 1, Organization & Preparedness
        $sql_cat1 = "SELECT answers.answer FROM questions INNER JOIN answers ON questions.fk_QuestionSetID = answers.fk_QuestionSetID AND questions.SOQnum = answers.SOQnum WHERE questions.fk_Category = 1 and answers.fk_InstructorID = $instructorID";
        $result_cat1 = mysqli_query($db, $sql_cat1);
        $row_cnt_cat1 = mysqli_num_rows($result_cat1);

        //push the query results into an array
        $arr_cat1 = array();
        while ($row_cat1 = mysqli_fetch_assoc($result_cat1)){
            array_push($arr_cat1, $row_cat1['answer']);            
            }
        
        //total up the array
        $total_cat1 = array_sum($arr_cat1);                
        
        //get the mean score for category 1
        $answer_cat1 = $total_cat1 / $row_cnt_cat1;          
        array_push($report,number_format($answer_cat1,2));        
        
        results_2();
                
}//end of Category 1 search

//Category 2 search, "Effectivness & Helpfulness"
    function results_2(){
        $instructorID = $_REQUEST['instructor'];
        global $db;
        global $overall;
        global $report;                

        //search Category 1, Organization & Preparedness
        $sql_cat2 = "SELECT answers.answer FROM questions INNER JOIN answers ON questions.fk_QuestionSetID = answers.fk_QuestionSetID AND questions.SOQnum = answers.SOQnum WHERE questions.fk_Category = 2 and answers.fk_InstructorID = $instructorID";
        $result_cat2 = mysqli_query($db, $sql_cat2);
        $row_cnt_cat2 = mysqli_num_rows($result_cat2);

        //push the query results into an array
        $arr_cat2 = array();
        while ($row_cat2 = mysqli_fetch_assoc($result_cat2)){
            array_push($arr_cat2, $row_cat2['answer']);            
            }
        
        //total up the array
        $total_cat2 = array_sum($arr_cat2);                
        
        //get the mean score for category 1
        $answer_cat2 = $total_cat2 / $row_cnt_cat2;          
        array_push($report,number_format($answer_cat2,2));         
        
        results_3();
                
}//end of Category 2 search

//Category 3 search, "Grading Methods"
    function results_3(){
        $instructorID = $_REQUEST['instructor'];
        global $db;        
        global $report;                

        //search Category 1, Organization & Preparedness
        $sql_cat3 = "SELECT answers.answer FROM questions INNER JOIN answers ON questions.fk_QuestionSetID = answers.fk_QuestionSetID AND questions.SOQnum = answers.SOQnum WHERE questions.fk_Category = 3 and answers.fk_InstructorID = $instructorID";
        $result_cat3 = mysqli_query($db, $sql_cat3);
        $row_cnt_cat3 = mysqli_num_rows($result_cat3);

        //push the query results into an array
        $arr_cat3 = array();
        while ($row_cat3 = mysqli_fetch_assoc($result_cat3)){
            array_push($arr_cat3, $row_cat3['answer']);            
            }        
            
        //total up the array    
        $total_cat3 = array_sum($arr_cat3);
        
        //get the mean score for category 1
        $answer_cat3 = $total_cat3 / $row_cnt_cat3; 
        
        if($answer_cat3 == ''){
            array_push($report,'n/a');
            results_4();
        }else{
            array_push($report,number_format($answer_cat3,2));                 
            results_4();        
        }
                
}//end of Category 3 search

//Category 4 search, "Would Recommend"
    function results_4(){
        $instructorID = $_REQUEST['instructor'];
        global $db;        
        global $report;                

        //search Category 1, Organization & Preparedness
        $sql_cat4 = "SELECT answers.answer FROM questions INNER JOIN answers ON questions.fk_QuestionSetID = answers.fk_QuestionSetID AND questions.SOQnum = answers.SOQnum WHERE questions.fk_Category = 4 and answers.fk_InstructorID = $instructorID";
        $result_cat4 = mysqli_query($db, $sql_cat4);
        $row_cnt_cat4 = mysqli_num_rows($result_cat4);

        //push the query results into an array
        $arr_cat4 = array();
        while ($row_cat4 = mysqli_fetch_assoc($result_cat4)){
            array_push($arr_cat4, $row_cat4['answer']);            
            }
            
        //total up the array    
        $total_cat4 = array_sum($arr_cat4);
        
        //get the mean score for category 1
        $answer_cat4 = $total_cat4 / $row_cnt_cat4;          
        array_push($report,number_format($answer_cat4,2));         
        
        overall_mean();
                
}//end of Category 4 search

function overall_mean(){
    global $report;  
         
    if($report[2] === 'n/a'){
        $count = 3;
    }else{
        $count = 4;
    }
    
    $overall_mean = array_sum($report) / $count; 
    
    buildRpt($overall_mean);
}

//get the question details
function questionSet1($catID){
    global $db;  
    $questions1 = "SELECT c.Category, q.SOQnum, q.question, s.SetName FROM category c LEFT JOIN questions q on c.id = q.fk_Category LEFT JOIN QuestionSet s on q.fk_QuestionSetID = s.id WHERE q.fk_Category = $catID ORDER BY q.fk_QuestionSetID asc, SOQnum asc";
    $qResult1 = mysqli_query($db, $questions1);
    $setArray = array();
    
    while($qRow1 = mysqli_fetch_assoc($qResult1)){
        //array_push($setArray,$qRow1['SetName'].$qRow1['SOQnum'].$qRow1['question']); 
        echo $qRow1['SetName'].'&nbsp;'.$qRow1['SOQnum'].'&nbsp;'.$qRow1['question'].'<br/>';
    }
    //return $setArray;
    
    
}

function questionSet2(){
    
}

function questionSet3(){
    
}

function questionSet4(){
    
}

//build the report

    function buildRpt($overall_mean){
        global $db;
        global $report;
        
        //echo "<pre>".print_r ($overall)."<br/>";
        //echo "<pre>".print_r ($report);
        //echo "<pre>".print_r($report)."<br/>";
        //number_format((float)$report[0],2)
        
        //echo "<table class='results_table' border='1'><tr class='overall'><td>Overall Score:</td><td>".number_format((float)$overall_mean,2)."</td></tr>";
        //echo "<tr><td>Organization & Preparedness:</td><td>".$report[0]."</td></tr>";
        //echo "<tr><td>Effectivness & Helpfulness:</td><td>".$report[1]."</td></tr>";
        //echo "<tr><td>Grading Methods:</td><td>".$report[2]."</td></tr>";
        //echo "<tr><td>Would Recommend:</td><td>".$report[3]."</td></tr>";
        //echo "</table>";
        //echo "<p style='text-align: center;'>These scores are on a scale of one to five.</p>";

        
    echo "<div id='accordion'>";
    echo "<ul><li><a href='#one' class='overall'>Overall Score:&nbsp&nbsp".number_format((float)$overall_mean,2)."<span class='arrow'>&#x25BC;</span></a>";
        echo "<div id='one' class='accordion'>";
        echo "The Overall Score is calculated by taking the calculations from the four categories below and averaging.</div></li>";
        
    echo "<li><a href='#two'>Organization & Preparation:&nbsp&nbsp".$report[0]."<span class='arrow'>&#x25BC;</span></a>";
        echo "<div id='two' class='accordion'>";
        questionSet1(1);
        //echo "insert questions here</div></li>";
        
    echo "<li><a href='#three'>Effectiveness & Helpfulness:&nbsp&nbsp".$report[1]."<span class='arrow'>&#x25BC;</span></a>";
        echo "<div id='three' class='accordion'>";
        questionSet1(2);
        //echo "insert questions here</div></li>";
        
    echo "<li><a href='#four'>Grading Methods:&nbsp&nbsp".$report[2]."<span class='arrow'>&#x25BC;</span></a>";
        echo "<div id='four' class='accordion'>";
        questionSet1(3);
        //echo "insert questions here</div></li>";
        
    echo "<li><a href='#five'>Would Recommend:&nbsp&nbsp".$report[3]."<span class='arrow'>&#x25BC;</span></a>";
        echo "<div id='five' class='accordion'>";
        questionSet1(4);
        //echo "insert questions here</div></li>";
    
    echo "</ul>";
    echo "</div>";
        
        
    }//end of report build function

?>
<link href="http://soq.washtenawvoice.com/css/report.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="wrapper">
        <div id="header"><?php echo $PageData->headerText("Rate WCC Instructors");?></div>
        <?php echo $PageData->navBar(); ?>
        <div id="content">
            <h2>Search by Instructor</h2>
            <p></p>
            
        <form method='post' action='search_1_1.php'>
            <div class="table_center">
            <table class="search_box" border="1" cellpadding="4">     
                <!-- need to fix this form so that the selection is sticky -->
                <tr><td>Select Instructor:</td><td><select name="instructor"><option value=''>(select an instructor)</option>
                <?php 
                while($row = mysqli_fetch_assoc($result)){
                        $instructor = $row['lname'].", ".$row['fname'];//set the value to a var we can use later                        
                        $instructorID = $row['id'];
                        $selected = '';//create the selected variable as string
                        if($_REQUEST['lname'] == $key){
                            $selected = 'selected="selected"';//make it selected                            
                        }
                        echo "<option value='$instructorID'>$instructor</option>";
                }                 
                        ?>
                        </select></td>
                        <td><input type="submit" name="submit" value="Search" /></td></tr>         
            </table>
            </div>
        </form>
        <br/>
        <?php
        //on submit do the zip code error check
        //change this back to POST when done testing
        if (isset($_POST['submit'])){
            errChk();
        }
        ?>                        
        </div><!--end content wrapper-->
     </div>
     <?php echo $PageData->Footer(); ?>
     <?php include_once("analyticstracking.php") ?>
    </body>
</html>