<?php
/**
 *  Created by PhpStorm.
 *  User: Rock Melody
 *  on 3/6/2022.
 *  on 9:15 PM.
 */

session_start();
include('../config/db.php');
$project_id = $_GET['id'];
$query = "SELECT project_name,department_info.department_name,user_details.user_firstname,user_details.
user_lastname,project_info.project_fiscal_year
FROM project_info
JOIN user_details ON user_details.user_id=project_info.user_id
JOIN department_info ON department_info.department_id=project_info.department_id
WHERE project_info.project_id=$project_id";
$result = mysqli_query($conn, $query) or die("Error in sql : $query". mysqli_error($conn));

$queryBudget = "SELECT  * FROM project_budget WHERE project_id=$project_id";
$budgets = mysqli_query($conn, $queryBudget) or die("Error in sql : $query". mysqli_error($conn));
$total = 0;
if($budgets->num_rows > 0) {
    foreach ($budgets as $budget) {
        $total += $budget['quantity'] * $budget['price'];
    }
}

$total_thai = convert($total);
$result = $result->fetch_assoc();

$dept = $result['department_name'];
$project_name = $result['project_name'];
$year = $result['project_fiscal_year'];
$name = $result['user_firstname'].' '.$result['user_lastname'];

require_once 'PHPWord.php';
// Add var Word Document
$PHPWord = new PHPWord();
$templateProcessor = $PHPWord->loadTemplate(__dir__.'/project_template.docx');

/* fill data */
$templateProcessor->setValue('dept', $dept);
$templateProcessor->setValue('project_name', $project_name);
$templateProcessor->setValue('total', number_format($total));
$templateProcessor->setValue('total_thai', $total_thai);
$templateProcessor->setValue('year', $year);
$templateProcessor->setValue('name', $name);
$fileName = 'ขออนุมัติ'.$project_name/*.'-'.date('d-m-Y his')*/;
$templateProcessor->save('file_word/'.$fileName.'.docx');
$file = (__DIR__.'/file_word/'.$fileName.'.docx');
//$file = ('/file_word/'.$fileName.'.docx');

$file = preg_replace('/C:\\\\xampp\\\\htdocs/','',$file);
$file = preg_replace('/\\\\/','/',$file);


?>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title> Minimal Dropdown Menu</title>
    <!--    <link rel="stylesheet" href="css/style.css">-->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>


<style>
.report-container {
    height: 297mm;
    width: 210mm;
    margin-left: auto;
    margin-right: auto;
}

.report-img {
    width: 120px;
    height: 112px;
    align-items: left;
}

h1 {
    font-family: 'Sarabun', sans-serif;
    font-weight: bold;
    font-size: 48px;
}

strong.font-twenty {
    font-size: 20px;
}

.border-bottom {
    border-bottom: dashed 2px #000;
}

.center {
    text-align: center;
    justify-content: center;
    align-items: center;
}

p {
    font-family: 'Sarabun', sans-serif;
    /*font-weight: bold;*/
    font-size: 16px;
}

div.indent {
    text-indent: 50px;
    font: normal;
    /*กำหนดค่าย่อหน้า*/
}

u {
    font-family: 'Sarabun', sans-serif;
    font-weight: normal;
    font-size: 16px;
}

div.right {
    /* ข้อความชิดซ้าย */
    text-align: right;
}

div.inline {
    display: grid;
    grid-template-columns: auto auto;
}

div.inline {
    display: grid;
    grid-template-columns: auto auto;
}

.mb-diff-fifteen {
    margin-bottom: -15px;
}

.mb-fifty {
    margin-bottom: 50px
}
</style>

<!DOCTYPE html>
<html>
<h1 class="center">ตัวอย่างไฟล์ Document</h1>
<br />
<br />
<br />
<div class="report-container" id="exportContent">
    <div class="inline text-center">
        <img src="../img/kuthai.jpg" alt="logoReport" class="report-img d-inline" />
        <!--            <img src="http://localhost/lib_kps/HTML/img/kuthai.jpg" alt="logoReport" class="report-img d-inline" />-->
        <h1 style="text-align: left;">บันทึกข้อความ</h1>
    </div>
    <br />
    <div class="inline">
        <p><strong class="font-twenty">ส่วนงาน</strong>
            <u class="border-bottom d-inline">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<?php echo $dept?>
                สำนักหอสมุด กำแพงแสน โทร 0-3435-1884 ภายใน 3802&emsp;&emsp;&emsp;&emsp;</u>
        </p>
    </div>
    <div class="inline">
        <p class="d-inline"><strong class="font-twenty">ที่</strong><u class="border-bottom">&emsp; อว
                ๖๕๐๒.๐๘/&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u><strong
                class="font-twenty">วันที่</strong><u>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</u>
        </p>
    </div>
    <div class="inline">
        <p class="d-inline"><strong class="font-twenty">เรื่อง</strong>
            <u class="border-bottom ">ขออนุมัติจัด&emsp;<?php echo $project_name?>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
            </u>
        </p>

    </div>

    <div class="">เรียน ผู้อำนวยการสำนักหอสมุด กำแพงแสน</div>
    <br />
    <div class="indent">
        <p>ตามที่สำนักหอสมุด กำแพงแสน ได้กำหนดแผนปฎิบัติการประจำปีงบประมาณ พ.ศ. <?php echo $year?>
            เพื่อเป็นกรอบและทิศทางการดำเนินงานในปีงบประมาณ พ.ศ. <?php echo $year?>
            ของแต่ละหน่วยงานภายในสำนักหอสมุดกำแพงแสน
            อันจะนำไปสู่เป้าหมายและวิสัยทัศน์ที่กำหนดไว้ร่วมกัน
        </p>
    </div>
    <div class="indent">

        <p>
            ดังนั้น เพื่อให้การดำเนินงานเป็นไปตามแผนปฎิบัติการ ประจำปีงบประมาณ พ.ศ.
            <?php echo $year?>และบรรลุตามเป้าหมายที่กำหนดไว้ จึงใคร่ขออนุมัติจัด
            <?php echo $project_name?>
            โดยใช้เงินรายได้สำนักหอสมุดกำแพงแสน ภายในงบประมาณจำนวน <?php echo $total?> .- บาท
            (<?php echo $total_thai?>)
            ทั้งนี้ได้แนบรายละเอียดโครงการดังกล่าวมาด้วยแล้ว
        </p>
    </div>

    <div class="indent">
        <p> จึงเรียนมาเพื่อโปรดพิจารณาอนุมัติ</p>
    </div>

    <div class="">
        <p>
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(<?php echo $name?>)
            <br />
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;ผู้รับผิดชอบโครงการ
        </p>
    </div>
    <div>
        <p>
            เรียน หัวหน้า <?php echo $dept ?>
        </p>
    </div>
    <div class="indent">
        <p>
            เพื่อโปรดพิจารณาเสนอผู้อำนวยการสำนักฯ พิจารณาอนุมัติ
            ทั้งนี้โครงการดังกล่าวเป็นโครงการประจำภายใต้แผนปฎิบัติการประจำปีงบประมาณ
            พ.ศ.<?php echo $year ?> และได้ตรวจสอบรายละเอียดในเบื้องต้นแล้วเรียบร้อยแล้ว
        </p>
    </div>
    <div class="">
        <p>
            <br />
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;....................................................
            <br />
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;นักวิเคราะห์นโยบายและแผน
        </p>
    </div>
    <br />
    <div class="inline mb-diff-fifteen ">
        <div>
            <p>
                <strong>เรียน ผู้อำนวยการสำนักหอสมุด กำแพงแสน</strong>
            </p>
        </div>
        <div>
            <p>
                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<strong class="font-twenty">อนุมัติ</strong>
            </p>
        </div>
    </div>


    <div class="indent">
        <p>
            เพื่อโปรดพิจารณาลงนามอนุมัติ
        </p>
    </div>
    <br />
    <div class="inline mb-fifty">

        &emsp;&emsp;&emsp;&emsp;&emsp;........................................... <br>
        &emsp;&emsp;&emsp;&emsp;หัวหน้า <?php echo $dept?>
        <div class="">
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;)
            <br />
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;ผู้อำนวยการสำนักหอสมุดกำแพงแสน
            <br />
            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;........... /
            ............ / ..........</u>
        </div>
    </div>
    <br />
    <div class="container-button center">
        <button onclick="parent.location='project_manage_edit.php?id=<?php echo $project_id?>'" class="backButton btn btn-warning">กลับ
        </button>
        <button onclick="Download();" class="download-doc btn btn-success">ดาวน์โหลด </button>
        <?php
            unset($_SESSION['project_id']);
            ?>

    </div>
    <iframe id="my_iframe" style="display:none;"></iframe>
</div>

</html>
<script>
function Download() {
    window.open('<?php echo $file?>', '_self');
};
</script>
<?php



function convert($number)
{
    $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ');
    $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
    $number = str_replace(array(",", " ", "บาท"), "", $number);
    $number = explode(".",$number);
    if(count($number)>2){
        return false;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for($i=0;$i<$strlen;$i++){
        $n = substr($number[0], $i,1);
        if($n!=0){
            if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; }
            elseif($i==($strlen-2) AND $n==2){ $convert .= 'ยี่'; }
            elseif($i==($strlen-2) AND $n==1){ $convert .= ''; }
            else{ $convert .= $txtnum1[$n]; }
            $convert .= $txtnum2[$strlen-$i-1];
        }
    }
    $convert .= 'บาท';
    if( empty($number[1]) || $number[1]=='0' || $number[1]=='00' || $number[1]==''){
        $convert .= 'ถ้วน';
    }else{
        $strlen = strlen($number[1]);
        for($i=0;$i<$strlen;$i++){
            $n = substr($number[1], $i,1);
            if($n!=0){
                if($i==($strlen-1) AND $n==1){$convert .= 'เอ็ด';}
                elseif($i==($strlen-2) AND $n==2){$convert .= 'ยี่';}
                elseif($i==($strlen-2) AND $n==1){$convert .= '';}
                else{ $convert .= $txtnum1[$n];}
                $convert .= $txtnum2[$strlen-$i-1];
            }
        }
        $convert .= 'สตางค์';
    }
    return $convert;
}


?>