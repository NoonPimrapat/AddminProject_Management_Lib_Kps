<?php
/**
 *  Created by PhpStorm.
 *  User: Rock Melody
 *  on 3/18/2022.
 *  on 5:24 PM.
 */

include('check_login.php');
include('../config/db.php');
include ('service.php');
$project_id = $_GET['id'];
$user_id = $_SESSION['user_id'];


//1. query ข้อมูลจากตาราง user_details:
$queryproject = "SELECT * FROM project_info WHERE project_id = $project_id" or die("Error:" . mysqli_error($conn));
//เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result_project = mysqli_query($conn, $queryproject);
$project = iterator_to_array($result_project);
if(!empty($project)) {
    $project = $project[0];
}

$project_name = $project['project_name'];
$year = $project['project_fiscal_year']; //งบประมาณ
$user_id = $project["user_id"]; //ผู้รับผิดชอบโครงการ
$project_sum_total = $project["project_sum_total"];
$project_sum_thai = convert($project_sum_total);

$sqlUser = "SELECT * FROM user_details WHERE user_id = {$user_id}" or die("Error:" . mysqli_error($conn));
$user = mysqli_query($conn, $sqlUser);
$user = iterator_to_array($user)[0];

$sqlRevision = "SELECT * FROM project_revision WHERE project_id = {$project_id}" or die("Error:" . mysqli_error($conn));
$revision = mysqli_query($conn, $sqlRevision);
$revision = iterator_to_array($revision)[0];
$revision_number = $revision['revision_number'];

$firstname = $user["user_firstname"];
$lastname = $user["user_lastname"];
$name = $firstname .' '.$lastname;
$deptname_user = $user['user_department'];
$strDate = DateThai(date('Y-m-d'));

require_once("vendor/autoload.php");
// Add var Word Document
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$templateProcessor = $phpWord->loadTemplate(__dir__.'/template_word/adjust_project.docx');

/* fill data */
$templateProcessor->setValue('dept', $deptname_user);
$templateProcessor->setValue('project_name', $project_name);
$templateProcessor->setValue('year', $year);
$templateProcessor->setValue('name', $name);
$templateProcessor->setValue('date', $strDate);
$templateProcessor->setValue('no', $revision_number);

$fileName = 'ขออนุมัติปรับแผนปฏิบัติการประจำปี_'.$project_name/*.'-'.date('d-m-Y his')*/;
$templateProcessor->saveAs('file_word/'.$fileName.'.docx');
$file = (__DIR__.'/file_word/'.$fileName.'.docx');
//$file = ('/file_word/'.$fileName.'.docx');

$file = preg_replace('/C:\\\\xampp\\\\htdocs/','',$file);
$file = preg_replace('/\\\\/','/',$file);



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
    <link rel="stylesheet" href="css/project_edit.css">
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
        <h1 class="center mt-30">ตัวอย่างไฟล์ Document</h1>

        <div class="row">
            <div class="col-md-6 left">ปรับแผนงบประมาณ ครั้งที่ <?php echo $revision_number?> /<?php echo $year?></div>
            <div class="col-md-6 right">ปรับแผนงบประมาณ ครั้งที่ <?php echo $revision_number?> /<?php echo $year?></div>
        </div>
        <h3 class="center mt-60">ขออนุมัติปรับแผนปฏิบัติการประจำปี สำนักหอสมุด กำแพงแสน</h3>

        <div class="inline">
            <p>ส่วนงาน <u class="border-bottom"><?php echo $deptname_user?>ส่วนงาน สำนักหอสมุด กำแพงแสน โทร 0-3435-1884
                    ภายใน 3802 </u></p>

        </div>
        <div class="inline">
            <p> ที่<u class="border-bottom">&emsp; อว
                    ๖๕๐๑.๐๘/&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
            </p>
            <div class="right">
                <p>วันที่<u
                        class="border-bottom">&emsp;<?php echo $strDate?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
                </p>
            </div>
        </div>
        <div class="inline">
            <p>เรื่อง<u class="border-bottom"> ขออนุมัติปรับแผนปฎิบัติการประจำปีงบประมาณ พ.ศ.
                    <?php echo $year?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                </u>
            </p>

        </div>

        <p>
            เรียน<strong> </strong> <u>ผู้อำนวยการสำนักหอสมุด กำแพงแสน</u>
            <br />
        <div class="indent">
            <u>
                ข้าพเจ้า <?php echo $name?> ฝ่าย <?php echo $deptname_user?>
                ผู้รับผิดชอบโครงการ <?php echo $project_name?> ขออนุญาตปรับรายละเอียดโครงการดังนี้
            </u>
        </div>
        <div class="indent">
            <u>
                จากที่กำหนดไว้คือ&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
            </u>
        </div>
        <div class="indent">
            <u>
                ขอเปลี่ยนเป็น&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;
            </u>
        </div>
        <div class="indent">
            <u>
                โดยมีเหตุผลในการขอปรับดังนี้&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
            </u>
        </div>
        </p>

        <u> จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ</u>
        <div class="right">
            <u>
                ลงชื่อ.........................
                <br />
                (<?php echo $name ?>)
                <br />
                ผู้รับผิดชอบโครงการ
            </u>
        </div>

        <div class="container-button center mt-30">
            <button onclick="parent.location='project_manage_edit_adjust_project.php?id=<?php echo $project_id ?>'"
                class="backButton">Back </button>
            <button onclick="Download();" class="summitButton btn-success">Download</button>
            <?php
        unset($_SESSION['project_id']);
        ?>
        </div>
    </div>
</body>

</html>
<script>
function Download() {
    window.open('<?php echo $file?>', '_self');
};
</script>