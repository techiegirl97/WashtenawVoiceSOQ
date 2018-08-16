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
//$sql = "SELECT * FROM questions ORDER BY fk_QuestionSetID asc, SOQnum asc";
//$sql = "SELECT c.*, q.* from category c left join questions q on c.id = q.fk_Category ORDER BY q.fk_QuestionSetID asc, SOQnum asc";
//need to left join the question set ID now
$sql = "SELECT c.Category, q.SOQnum, q.question, s.SetName FROM category c LEFT JOIN questions q on c.id = q.fk_Category LEFT JOIN QuestionSet s on q.fk_QuestionSetID = s.id ORDER BY q.fk_QuestionSetID asc, SOQnum asc";
$result = mysqli_query($db, $sql);
?>
</head>
<body>
    <div id="wrapper">
        <div id="header"><?php echo $PageData->headerText("SOQ Search");?></div>
        <?php echo $PageData->navBar(); ?>
        <div id="content">
            <h2>SOQ Survey Questions</h2>
    
    <table border="1">
        <thead>
        <th style="width: 13%;">Question Set</th>
        <th style="width: 13%;">Category</th>
        <th>Question Num</th>
        <th>Question Text</th>
        <th>Edit...</th>
        </thead>             
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
        <tr>
            <td><?= $row['SetName']; ?></td>
            <td><?= $row['Category']; ?></td>
            <td><?= $row['SOQnum']; ?></td>            
            <td><?= $row['question']; ?></td>
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