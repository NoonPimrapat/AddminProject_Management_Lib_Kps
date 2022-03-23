<?php
include('../config/db.php');

/**
 * @param array $data
 * @return array
 */

function getBudgetFormat($data = []) {
    $budgets = [];
    foreach ($data as $key => $value) {
        if(in_array($key,['compensation','cost','material'])){
            $buffBudgets = [];
            foreach($value as $sk => $sv){
//                var_export($value);
//                exit;
                if(in_array($sk,['item','quantity','price'])){
//                    var_export(count($value));exit;
                    foreach ($sv as $index => $val) {
                        if(trim($val) !== '') {
                            $buffBudgets[$index][$sk] = $sv[$index];
                            if(empty($buffBudgets[$index]['budget_group'])) {
                                $buffBudgets[$index]['budget_group'] = $key;
                            }
                        }else{
                            unset($buffBudgets[$index]);
                            break;
                        }

                    }
                }
            }
            $budgets = array_merge($budgets,$buffBudgets);
        }
    }
    return $budgets;
}


function getPlantFormat($data = []){
    $plants =[];
    foreach ($data as $key => $value) {
        if(in_array($key,['plant_detail','plant_time','plant_location'])) {
            foreach ($value as $index => $val) {
                if(trim($val) !== '') {
                    $plants[$index][$key] = $val;
                }
            }
        }

    }
    return $plants;
}

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

$monthArrayTh = array(
    'มกราคม',
    'กุมภาพันธ์',
    'มีนาคม',
    'เมษายน',
    'พฤษภาคม',
    'มิถุนายน',
    'กรกฎาคม',
    'สิงหาคม',
    'กันยายน',
    'ตุลาคม',
    'พฤศจิกายน',
    'ธันวาคม'
  );
  
  $target = @$_POST['target'];
  switch ($target) {
    case 'ProjectDetail':
      $pid = $_POST['project_id'];
      GetProjectDetail($pid);
      break;
    case 'RequestApprovalChoiceProjectPlan':
      $pid = $_POST['project_id'];
      GetRequestApprovalChoiceProjectPlan($pid);
      break;
    case 'ReportProject':
      GetReportProject();
      break;
    default:
      echo json_encode(array('error' => true, 'errorMessage' => '404 function not found.'));
      break;
  }
  
  
  function GetProjectDetail($pid = "")
  {
    global $conn;
    $data = array();
    $error = true;
    $errorMessage = "400 Bad Request. [project_id] not empty.";
    if ($pid) {
      $queryString = "SELECT * FROM `project_info` WHERE project_id = {$pid}";
      $result = $conn->query($queryString);
      $data = $result->fetch_assoc();
      $error = false;
      $errorMessage = "Success";
    }
    echo json_encode(array('error' => $error, 'data' => $data, 'errorMessage' => $errorMessage));
  }
  
  function GetRequestApprovalChoiceProjectPlan($pid = "")
  {
    global $conn;
    global $monthArrayTh;
    $data = array();
    $error = true;
    $errorMessage = "400 Bad Request. [project_id] not empty.";
    if ($pid) {
      $queryString = "SELECT * FROM `project_info` WHERE project_id = {$pid}";
      $result = $conn->query($queryString);
      $query = $result->fetch_assoc();
      if ($query) {
        list($yop, $mop, $dop) = explode("-", $query['period_op']);
        list($yed, $med, $ded) = explode("-", $query['period_ed']);
        $year = $yed + 543;
        $processing_time = "เวลาดำเนินการ : {$dop} {$monthArrayTh[(int)$mop]} - {$ded} {$monthArrayTh[(int)$med]} พ.ศ. {$year}";
        $indicator_1 = "ตัวชี้วัด 1: {$query['indicator_1']}";
        $indicator_2 = "ตัวชี้วัด 2: {$query['indicator_2']}";
        $indicator_1_value = "ค่าเป้าหมาย: {$query['indicator_1_value']}";
        $indicator_2_value = "ค่าเป้าหมาย: {$query['indicator_2_value']}";
        $budget = number_format($query['project_sum_total'], 2);
        $data = array(
          'time' => $processing_time,
          'indicator_1' => $indicator_1,
          'indicator_2' => $indicator_2,
          'indicator_1_value' => $indicator_1_value,
          'indicator_2_value' => $indicator_2_value,
          'budget' => $budget
        );
      }
      $error = false;
      $errorMessage = "Success";
    }
    echo json_encode(array('error' => $error, 'data' => $data, 'errorMessage' => $errorMessage));
  }
  
  function GetReportProject()
  {
    global $conn;
    $error = false;
    $errorMessage = "Success";
    $type = $_POST['type'];
    $year = $_POST['year'];
    $queryString = "SELECT * FROM project_info JOIN project_style_info JOIN department_info JOIN user_details 
    ON project_info.user_id=user_details.user_id 
    AND project_info.project_style=project_style_info.project_style_id
    AND project_info.department_id=department_info.department_id WHERE project_style = '{$type}'";
  
    if ($year) $queryString .= " AND project_fiscal_year = '{$year}'";
  
    $result = $conn->query($queryString);
    $data   = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $data[] = $row;
    }
    echo json_encode(array('error' => $error, 'data' => $data, 'errorMessage' => $errorMessage));
  }
  