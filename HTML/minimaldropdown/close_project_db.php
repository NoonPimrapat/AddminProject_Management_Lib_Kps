<?php
/**
 *  Created by PhpStorm.
 *  User: Rock Melody
 *  on 3/17/2022.
 *  on 06:46 AM.
 */


include('check_login.php');
include('../config/db.php');

//echo '<pre>';
//var_export($_POST);
//exit();
include('service.php');


$project_id = $_POST['project_id'];
if(!isset($_POST['close_project'])) {
    $_SESSION['error'] = "is not a form \"Close project\"";
    header('location: project_manage_edit_close_project.php?id='.$project_id);
    exit();
}
date_default_timezone_set('Asia/Bangkok');
$date = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];
$errors = [];
$buffInsert = $_POST;
unset($buffInsert['project_id']);


/* ======= PROJECT INFO   ========*/

$pro_name = $_POST['project_name'];
$user_id = $_SESSION['user_id'];
$errors = [];
$buff_update = $_POST;
unset($buff_update['project_id']);
unset($buff_update['close_project']);
unset($buff_update['plant']);
unset($buff_update['responsible_man']);
unset($buff_update['compensation']);
unset($buff_update['cost']);
unset($buff_update['material']);
unset($buff_update['progress_indicator_1']);
unset($buff_update['progress_indicator_2']);
unset($buff_update['activity_pictures']);
$buff_update['submit_date'] = date("Y-m-d H:i:s");
// check  required
$update = '';
foreach ($buff_update as $key => $buff_value) {
    $buff_update[$key] = mysqli_real_escape_string($conn, trim($buff_value));
    if(empty($buff_update[$key])) {
        $errors[] = $key. ' is required';
        $_SESSION['error'] = "pro_name is required";
    }

    $update .= "{$key} = '{$buff_update[$key]}',";
}
$update = substr($update,0, -1);
$keys_update = array_keys($buff_update);
if(count($errors) > 0) {
    foreach ($errors as $value) {
        //Print the element out.
        echo("<br>Error:");
        echo $value;exit();
        '<br>';
    }
}else {
    $sql = ("UPDATE project_info set {$update} WHERE project_id=$project_id");
    $res = mysqli_query($conn, $sql);
    if($res){
        $_SESSION['pro_name'] = $buff_update['project_name'];
        $_SESSION['success'] = "You are save project name";
        $_SESSION['project_id'] = $project_id;
    }else{
        $_SESSION['error'] .= 'project info not update';
    }
}
/*  END PROJECT INFO */
/* ===============================*/

/* ------BUDGETS------- */
$budgets = getBudgetFormat($_POST);
//var_export($budgets);exit;


/* Delete first */
$sqlDel = 'DELETE FROM report_budget where report_project_id=' . $project_id;
$resDel = mysqli_query($conn, $sqlDel);


// check  required
$buffInsert = [];
$insertValues = '';
foreach ($budgets as $index => $item) {
    $insert = "({$project_id},";
    foreach ($item as $key => $value) {
        $buffInsert[$key] = mysqli_real_escape_string($conn, trim($value));
        if (empty($buffInsert[$key])) {
            $_SESSION['error'] = "something went wrong";
        }
        if ($key === 'report_quantity') {
            $buffInsert[$key] = (int)$buffInsert[$key];
        } else if ($key === 'report_price') {
            $buffInsert[$key] = (float)$buffInsert[$key];
        } else {
            $buffInsert[$key] = (string)'"' . $buffInsert[$key] . '"';
        }
        if (end($item) === $value) {
            $insert .= "{$buffInsert[$key]},'$date')";
        } else {
            $insert .= "{$buffInsert[$key]},";
        }
    }
    $insertValues .= $insert . ',';
}
if (!empty($insertValues)) {
    $insertValues = substr($insertValues, 0, -1);
    $sqlInsert = "INSERT INTO report_budget(report_project_id,report_item,report_budget_group,report_quantity,report_price,report_submit_date) VALUES {$insertValues};";
    $resInsert = mysqli_query($conn, $sqlInsert);
    if (!$resInsert) {

        $_SESSION['error'] .= "  report budget not update";
        echo 111;exit();
    }
}

/* ------ END BUDGETS------- */


/*------ Progress info  ------*/

$sqlProgress = "UPDATE progress_info SET progress_indicator_1='{$_POST['progress_indicator_1']}',progress_indicator_2='{$_POST['progress_indicator_2']}'
WHERE  project_id={$project_id}";
//        var_export($sqlProgress);exit;
$resProgress = mysqli_query($conn, $sqlProgress);
//        var_export($resProgress);exit;
if (!$resProgress) {
    $_SESSION['error'] .= "progress info not update";
}

/*------ END Progress info  ------*/

/* redirect page */
if(empty($_SESSION['error'])) {
    header('location: project_manage_edit_close_project_report.php?id='.$project_id);
}else{
    header('location: project_manage_edit_close_project.php?id='.$project_id);
}





