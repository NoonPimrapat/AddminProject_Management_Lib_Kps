<?php



include('check_login.php');
include('../config/db.php');
include('service.php');
include('service_query.php');
require_once("vendor/autoload.php");
// $project_id = $_GET['id'];
$project_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$queryproject = "SELECT * FROM project_info 
JOIN user_details JOIN project_style_info JOIN progress_info
ON user_details.user_id=project_info.user_id
AND project_info.project_style=project_style_info.project_style_id
AND progress_info.project_id=project_info.project_id
WHERE project_info.project_id=$project_id";
$result_project = mysqli_query($conn, $queryproject) or die("Error in sql : $query". mysqli_error($conn));
$row = mysqli_fetch_array($result_project);
//echo '<pre>';
//var_export($row);exit;

 $queryde = "SELECT * FROM department_info" or die("Error:" . mysqli_error());
 $departments = mysqli_query($conn, $queryde);

 $queryStyle = "SELECT * FROM project_style_info ORDER BY project_style_id asc" or die("Error:" . mysqli_error());
// เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
 $styles = mysqli_query($conn, $queryStyle);


$queryPlan = "SELECT * FROM report_plant WHERE project_id=$project_id";
$plans = mysqli_query($conn, $queryPlan);
$plans = iterator_to_array($plans);

$queryBudget = "SELECT * FROM report_budget WHERE report_project_id=$project_id";
$budgets = mysqli_query($conn, $queryBudget);
$budgets = iterator_to_array($budgets);
if(!empty($budgets)) {
    foreach ($budgets as $key => $item) {
        $buffBudgets[$item['report_budget_group']][] = $item;
    }
    $budgets = $buffBudgets;
}

$queryPlant = "SELECT * FROM report_plant WHERE project_id=$project_id";
$plant = mysqli_query($conn, $queryPlant);
$plant = iterator_to_array($plant);

$queryProgress = "SELECT * FROM progress_info WHERE project_id=$project_id";
$progress = mysqli_query($conn, $queryProgress);
$progress = iterator_to_array($progress)[0];


$project_name = $row["project_name"];
$year = $row["project_fiscal_year"]; //งบประมาณ
$user_id = $row["user_id"]; //ผู้รับผิดชอบโครงการ
$department_id = $row["department_id"]; //ไอดีฝ่าย
//    $project_fiscal_year = $row["project_fiscal_year"]; //ชื่อผู้อำนวยการ
$submit_date = $row["submit_date"]; //วันที่
$project_sum_total=$row["project_sum_total"];
$project_sum_thai = convert($project_sum_total);
$project_style_name=$row["project_style_name"];


$strDate = DateThai($submit_date);

//1. query ข้อมูลจากตาราง user_details:
$queryDerpartment = "SELECT * FROM department_info WHERE department_id = '$department_id'" or die("Error:" . mysqli_error());
//เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result_Derpartment = mysqli_query($conn, $queryDerpartment);
foreach ($result_Derpartment as $values) {
    $derpartment_name = $values["department_name"]; //ชื่อฝ่าย
}

//1. query ข้อมูลจากตาราง user_details:
$queryUser = "SELECT * FROM user_details WHERE user_id = '$user_id'" or die("Error:" . mysqli_error());
//เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result_user = mysqli_query($conn, $queryUser);
foreach ($result_user as $values) {
    $firstname = $values["user_firstname"]; //ชื่อ
    $lastname = $values["user_lastname"]; //นามสกุล
    $name = $firstname. ' '.$lastname;
}
// สร้างword
// header("Content-Type: application/msword");
// header('Content-Disposition: attachment; filename="filename.doc"');

$phpWord = new \PhpOffice\PhpWord\PhpWord();

$templateProcessor = $phpWord->loadTemplate(__dir__ . '/template_word/performance_project.docx');

/* todo: set row report_plant  */
if(!empty($plans)) {
        $templateProcessor->cloneRow('report_detail',count($plans));
        $templateProcessor->cloneRow('report_time',count($plans));
        $templateProcessor->cloneRow('report_place',count($plans));
    foreach ($plans as $key => $value) {
//        $templateProcessor->setValue('report_detail#' . ($key+1), ($key+1) .'.'. htmlspecialchars($value['report_detail'], ENT_COMPAT, 'UTF-8'));
        $templateProcessor->setValue('report_detail#' . ($key+1), ($key+1) .'. '.$value['report_detail']);
        $templateProcessor->setValue('report_time#' . ($key+1), ($key+1) .'. '.$value['report_time']);
        $templateProcessor->setValue('report_place#' . ($key+1), ($key+1) .'. '.$value['report_place']);
    }
}


/* todo: set row report_budget*/
if(!empty($budgets)) {

    foreach ($budgets as $group => $lists) {
        foreach ($lists as $key => $item) {
            if($key === 0) {
                $templateProcessor->cloneRow($group.'_item',count($budgets[$group]));
            }
            if($group === 'compensation') {
                $no = '1.'.($key+1).' ';
            }elseif($group === 'cost'){
                $no = '2.'.($key+1).' ';
            }else{
                $no = '3.'.($key+1).' ';
            }
            $templateProcessor->setValue($group.'_item#' . ($key+1),$no.$item['report_item']);
            $search = substr($group,'0','4').'_total#';
            $total = $item['report_quantity'] * $item['report_price'];
            $templateProcessor->setValue($search . ($key+1), number_format($total));

        }
    }
}


$files = queryFiles($project_id);
if(!empty($files)) {
    $templateProcessor->cloneBlock('block_image', count($files), true, true);
    foreach ($files as $key => $file){
        $path = (__DIR__.'/');
        $path = preg_replace('/C:\\\\xampp\\\\htdocs/','',$path);
        $path = preg_replace('/\\\\/','/',$path);
//    var_export($path.'view_image.php?file_id='.$file['file_id']);exit;
//    $templateProcessor->setImageValue('image#'.($key+1),  'data:image/jpg;charset=utf8;base64,'. base64_encode($file['file']));
        $templateProcessor->setImageValue('image#'.($key+1),
            [
                'path' => 'data:image/jpg;charset=utf8;base64,'. base64_encode($file['file']),
                'width' => 200,
                'height' => 200,
                'ratio' => true
            ]
        );
    }

}

$total_thai = convert($row['project_sum_total']);
$date = DateThai(date('Y-mp-d'));
$templateProcessor->setValue('project_name', $row['project_name'] );
$templateProcessor->setValue('total', number_format($row['project_sum_total']));
$templateProcessor->setValue('total_thai', $total_thai);
$templateProcessor->setValue('progress_indicator_1', $progress['progress_indicator_1']);
$templateProcessor->setValue('progress_indicator_2', $progress['progress_indicator_2']);
$templateProcessor->setValue('indicator_1', $row['indicator_1']);
$templateProcessor->setValue('indicator_2', $row['indicator_1']);
$templateProcessor->setValue('indicator_1_value', $row['indicator_1_value']);
$templateProcessor->setValue('indicator_2_value', $row['indicator_2_value']);
$templateProcessor->setValue('indicator_1', $row['indicator_1_value']);
$templateProcessor->setValue('indicator_2', $row['indicator_2_value']);
$templateProcessor->setValue('quarter', $progress['progress_quarter']);
$templateProcessor->setValue('name', $name);
$fileName = 'การรายงานความก้าวหน้า_' . $row['project_name']/*. '-' . date('d-m-Y his')*/;
$templateProcessor->saveAs('file_word/' . $fileName . '.docx');
$fileDoc = (__DIR__.'/file_word/'.$fileName.'.docx');
//$file = ('/file_word/'.$fileName.'.docx');
$fileDoc = preg_replace('/C:\\\\xampp\\\\htdocs/','',$fileDoc);
$fileDoc = preg_replace('/\\\\/','/',$fileDoc);
//echo("<script>window.open('$file', '_blank');</script>");

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
    <link rel="stylesheet" href="css/project_edit.css">
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

        <div class="mt-20">
            <?php if (empty($plant->num_rows) > 0): ?>
                <table class="table mt-15">
                    <thead>
                        <th>
                            ผลการดำเนินงาน
                        </th>
                    </thead>
                    <tbody>
                    <?php foreach($plant as $key => $value) : ?>

                    <tr class="box-input">
                        <td>
                            <span><?php echo '&nbsp;&nbsp;&nbsp;'.($key+1) .'. '. $value['report_detail']?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <table class="table mt-15">
                    <thead>
                    <th>
                        ระยะเวลาดำเนินงาน
                    </th>
                    </thead>
                    <tbody>
                    <?php foreach($plant as $key => $value) : ?>
                        <tr class="box-input">
                            <td>
                                <span><?php echo '&nbsp;&nbsp;&nbsp;'.($key+1) .'. '. $value['report_time']?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <table class="table mt-15">
                    <thead>
                    <th>
                        สถานที่
                    </th>
                    </thead>
                    <tbody>
                    <?php foreach($plant as $key => $value) : ?>
                        <tr class="box-input">
                            <td>
                                <span><?php echo '&nbsp;&nbsp;&nbsp;'.($key+1) .'. '. $value['report_place']?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="mt-20">
            <p> งบประมาณ</p>
            <?php if (empty($budgets->num_rows) > 0): ?>
                <?php $noPlant = (array_flip(array_keys($budgets))); // run number of array ?>
                <?php foreach($budgets as $group => $budget) :?>
                    <table class="table mt-15">
                        <thead>
                            <th>
                                <?php if($group === 'compensation') : echo ($noPlant[$group]+1)?>
                                    . ค่าตอบแทน
                                <?php elseif($group === 'cost') : echo ($noPlant[$group]+1)?>
                                    . ค่าใช้สอย
                                <?php elseif($group === 'material') : echo ($noPlant[$group]+1)?>
                                    . ค่าวัสดุ
                                <?php endif; ?>
                            </th>
                        </thead>
                        <tbody>
                        <?php foreach($budget as $key => $value) : ?>
                            <tr class="box-input">
                                <td class="width-75">
                                    <span><?php echo '&nbsp;&nbsp;&nbsp;'.($noPlant[$group]+1).'.'.($key+1).' '.$value['report_item']?></span>
                                </td>
                                <td class="" colspan="2" style="text-align: right;">
                                    <?php echo number_format($value['report_quantity'] * $value['report_price']) ?>
                                </td>
                                <td style="text-align: right;">
                                    บาท
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if(array_key_last($budgets) === $group) : ?>
                            <tr>
                                <td colspan="2" style="text-align: right;">
                                    รวม
                                </td>
                                <td style="text-align: right;">
                                    <?php echo number_format($row['project_sum_total'])?>
                                </td>
                                <td style="text-align: right;">
                                    บาท
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">
                                    <?php echo $total_thai ?>
                                </td>
                                <td style="text-align: right;">
                                    บาท
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    <?php ?>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>


        <div>
            <!-- ตาราง -->
            <p>ตัวชี้วัดโครงการ</p>
            <div class="indent">
                <p>1. <?php echo $row["indicator_1"]?></p>
                <p>เป้าหมายที่กำหนดไว้ <?php echo $row["indicator_1_value"]?></p>
                <p>ผลการดำเนินงาน <?php echo $row["progress_indicator_1"]?></p>
                <p>1. <?php echo $row["indicator_2"]?></p>
                <p>เป้าหมายที่กำหนดไว้ <?php echo $row["indicator_2_value"]?></p>
                <p>ผลการดำเนินงาน <?php echo $row["progress_indicator_2"]?></p>
            </div>
        </div>




        <div class="left mt-30 mb-20">
            <u>
                (<?php echo $firstname?>&nbsp;<?php echo $lastname?>)
                <br />
                ผู้รับผิดชอบโครงการ
            </u>
        </div>

        <div class="mb-20 mt-30">
            <p>
                เอกสารแนบ
            </p>
            <div>1. ภาพกิจกรรม 3 ไฟล์</div>

        </div>
        <div class="col-md-12 mb-20 mb-20">
            <ul class="center">
                <?php foreach ($files as $file):?>
                    <li class="col-md-12 block-img">
                        <?php if($file['type'] === 'image'): ?>
                            <img src="view_image.php?file_id=<?php echo $file['file_id']?>" alt="<?php echo $files[0]['name']?>">
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="container-button mt-30 center">
            <button onclick="parent.location='project_manage_edit_performance.php?id=<?php echo $project_id ?>'" class="backButton">Back </button>
            <button onclick="Download();" class="backButton btn-success">Download </button>
            <?php
            unset($_SESSION['project_id']);
            ?>

        </div>
    </div>
</body>
<script>
    function Download() {
        window.open('<?php echo $fileDoc?>', '_self');
    };
</script>
</html>