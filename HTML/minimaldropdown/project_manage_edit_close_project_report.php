<?php
session_start();

include('../config/db.php');
$project_id = $_SESSION['project_id'];
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

//1. query ข้อมูลจากตาราง user_details:
$queryproject = "SELECT * FROM project_info WHERE project_id = '64'" or die("Error:" . mysqli_error());
//เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result_project = mysqli_query($conn, $queryproject);

foreach ($result_project as $values) {
    $project_name = $values["project_name"];
    $project_fiscal_year = $values["project_fiscal_year"]; //งบประมาณ
    $user_id = $values["user_id"]; //ผู้รับผิดชอบโครงการ
    $department_id = $values["department_id"]; //ไอดีฝ่าย
    $project_fiscal_year = $values["project_fiscal_year"]; //ชื่อผู้อำนวยการ
    $submit_date = $values["submit_date"]; //วันที่
    $project_sum_total=$values["project_sum_total"];
    $project_sum_thai;
    
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
        <div class="inline">

            <img src="../img/imgReport.jpg" alt="logoReport" class="report-img" />
            <strong>บันทึกข้อความ</strong>


        </div>

        <p>
            <strong>

            </strong>
        </p>
        <div class="inline">
            <p>ส่วนงาน <u
                    class="border-bottom"><?php echo $Derpartment_name?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </p>
            <div class="right">
                <u class="border-bottom"> สำนักหอสมุด กำแพงแสน โทร 0-3435-1884 ภายใน 3802</u>
            </div>

        </div>
        <div class="inline">
            <p> ที่<u class="border-bottom">&emsp; อว
                    ๖๕๐๒.๐๘/&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </p>
            <div class="right">
                <p>วันที่<u
                        class="border-bottom">&emsp;<?php echo $strDate?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
                </p>
            </div>
        </div>
        <div class="inline">
            <p>เรื่อง<u class="border-bottom"> ขออนุมัติเบิกจ่ายค่าใช้จ่ายและปิดโครงการ
                    <?php echo $project_name?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </p>

        </div>

        <p>
            เรียน<strong> </strong> <u>ผู้อำนวยการสำนักหอสมุด กำแพงแสน</u>
            <br />
        <div class="indent">
            <u>
                ตามที่ได้ขออนุมัติจัด <?php echo $project_name?>
                ภายในวงเงิน จำนวน <?php echo $project_sum_total?> .-บาท<?php echo $project_fiscal_year?> (
                <?$project_sum_thai?>)
                ตามบันทึกที่ อว ๖๕๐๒.๐๘/ ลงวันที่และได้รับอนุมัติแล้วนั้น
            </u>
        </div>
        <div class="indent">

            <u>
                บัดนี้ ได้ดำเนินการจิกกรรมดังกล่าวเสร็จเรียบร้อยแล้ว
                โดยมีค่าใช้จ่ายรวมเป็นเงินทั้งสิ้น<?php echo $project_sum_total?> .-บาท (
                <?$project_sum_thai?>) ดังนั้น จึงขออนุมัติเบิกจ่ายค่าใช้จ่ายและปิดโครงการดังกล่าว
                ทั้งนี้มีรายละเอียดตามเอกสารดังแนบ
            </u>
        </div>
        </p>

        <u> จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ</u>
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