<?php
session_start();

include('../config/db.php');
// $project_id = $_GET['id'];
$project_id = 65;
$user_id = $_SESSION['user_id'];
// ถ้าไม่loginก็จะเข้าหน้านี้ไม่ได้
if (!isset($_SESSION['user_email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_email']);
    header('location: login.php');
}

$queryproject = "SELECT * FROM project_info 
JOIN user_details JOIN project_style_info JOIN progress_info
ON user_details.user_id=project_info.user_id
AND project_info.project_style=project_style_info.project_style_id
AND progress_info.project_id=project_info.project_id
WHERE project_info.project_id=$project_id";
$result_project = mysqli_query($conn, $queryproject) or die("Error in sql : $query". mysqli_error($conn));
$row = mysqli_fetch_array($result_project);


 $queryde = "SELECT * FROM department_info" or die("Error:" . mysqli_error());
 $departments = mysqli_query($conn, $queryde);

 $queryStyle = "SELECT * FROM project_style_info ORDER BY project_style_id asc" or die("Error:" . mysqli_error());
// เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
 $styles = mysqli_query($conn, $queryStyle);

 $queryPlan = "SELECT * FROM project_plant WHERE project_id=$project_id";
 $plans = mysqli_query($conn, $queryPlan);

foreach ($result_project as $values) {
    $project_name = $values["project_name"];
    $project_fiscal_year = $values["project_fiscal_year"]; //งบประมาณ
    $user_id = $values["user_id"]; //ผู้รับผิดชอบโครงการ
    $department_id = $values["department_id"]; //ไอดีฝ่าย
    $project_fiscal_year = $values["project_fiscal_year"]; //ชื่อผู้อำนวยการ
    $submit_date = $values["submit_date"]; //วันที่
    $project_sum_total=$values["project_sum_total"];
    $project_sum_thai;
    $project_style_name=$values["project_style_name"];
  
    
    // list($y,$m,$d,$h,$mi)=explode('-',':',$submit_date);
    // // echo$d.'/'.$m.'/'.$y;
    // $date=$d.'/'.$m.'/'.$y;
    // $format = "d/m/Y";
    // echo $date=$format(submit_date);
    // echo DATE_FORMAT($submit_date,'d/m/Y');
   
	function DateThai($submit_date)
	{
		$strYear = date("Y",strtotime($submit_date))+543;
		$strMonth= date("n",strtotime($submit_date));
		$strDay= date("j",strtotime($submit_date));
		$strHour= date("H",strtotime($submit_date));
		$strMinute= date("i",strtotime($submit_date));
		$strSeconds= date("s",strtotime($submit_date));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
         return "$strDay $strMonthThai $strYear";
        //  return "$strDay $strMonthThai $strYear, $strHour:$strMinute";
	}

	 $strDate = DateThai($submit_date);



}

//1. query ข้อมูลจากตาราง user_details:
$queryDerpartment = "SELECT * FROM department_info WHERE department_id = '$department_id'" or die("Error:" . mysqli_error());
//เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result_Derpartment = mysqli_query($conn, $queryDerpartment);
foreach ($result_Derpartment as $values) {
    $Derpartment_name = $values["department_name"]; //ชื่อฝ่าย
}

//1. query ข้อมูลจากตาราง user_details:
$queryUser = "SELECT * FROM user_details WHERE user_id = '$user_id'" or die("Error:" . mysqli_error());
//เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result_user = mysqli_query($conn, $queryUser);
foreach ($result_user as $values) {
    $firstname = $values["user_firstname"]; //ชื่อ
    $lastname = $values["user_lastname"]; //นามสกุล
}
// สร้างword
// header("Content-Type: application/msword");
// header('Content-Disposition: attachment; filename="filename.doc"');



?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สำนักงานหอสมุดกำแพงแสน</title>
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@200;400;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- custom css -->

    <link rel="stylesheet" href="css/wordReport.css">
    <link rel="stylesheet" href="css/custom.css?v=<?php echo time(); ?>">

    <!-- plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="./bahttex.js"></script>
</head>

<body>
    <header>


    </header>
    <div class="report-container">
        <h1 class="center">ตัวอย่างไฟล์ Document</h1>
        <div class="center">


            <strong>รายงานผลการจัดการโครงการ</strong>
            <p>โครงการ <u> <?php  
                    echo $project_name ?>
                </u>
            </p>
            <p>รายงาน ณ ไตรมาสที่ <u> <?php  
                    echo $row["progress_quarter"] ?>
                </u>
            </p>

        </div>

        <p>
            <strong>

            </strong>
        </p>
        <div>

            <p>ลักษณะโครงการ <u class="border-bottom"> <?php  
                    echo $project_style_name ?>
                </u>
            </p>




            <p> ภายใต้ยุทศาสตร์
            </p>



            <p> ภายใต้แผนงานประจำ
            </p>


            <p> ฝ่ายงาน
            </p>
            <p> วัตถุประสงค์โครงการ
            </p>
            <p> รายละเอียดการจัดการโครงการ
            </p>
            <p> ระยะเวลาดำเนินการ
            </p>
            <p> สถานที่
            </p>
            <p> งบประมาณ
            </p>
            <!-- ตาราง -->
            <p>ตัวชี้วัดโครงการ</p>
            <div class="indent">
                <p>1. <?php echo $row["indicator_1"]?></p>
                <p>เป้าหมายที่กำหนดไว้ <?php echo $row["indicator_1_value"]?></p>
                <p>ผลการดำเนินงาน <?php echo $row["indicator_1_value"]?></p>
                <p>1. <?php echo $row["indicator_2"]?></p>
                <p>เป้าหมายที่กำหนดไว้ <?php echo $row["indicator_2_value"]?></p>
                <p>ผลการดำเนินงาน <?php echo $row["indicator_2_value"]?></p>
            </div>
        </div>




        <div class="right">
            <u>
                (<?php echo $firstname?>&nbsp;<?php echo $lastname?>)
                <br />
                ผู้รับผิดชอบโครงการ
            </u>
        </div>

        <div class="container-button">
            <button onclick="parent.location='home.php'" class="backButton">Back </button>
            <?php
            unset($_SESSION['project_id']);
            ?>

        </div>
    </div>
</body>

</html>