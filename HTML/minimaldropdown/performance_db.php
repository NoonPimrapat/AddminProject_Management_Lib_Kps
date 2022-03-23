<?php

include('check_login.php');
include('../config/db.php');
include('service.php');

//echo '<pre>';
//var_export($_POST);
//exit();

$buffInsert = [];

$project_id = $_POST['project_id'];
$user_id = $_SESSION['user_id'];
$errors = [];
$buffInsert = $_POST;
unset($buffInsert['project_id']);
unset($buffInsert['project_sum_total']);

/* BUDGETS  */
$budgets = getBudgetFormat($_POST);





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
            $insert .= "{$buffInsert[$key]})";
        } else {
            $insert .= "{$buffInsert[$key]},";
        }
    }
    $insertValues .= $insert . ',';
}
if (!empty($insertValues)) {
    /* Delete first */
    $sqlDel = 'DELETE FROM report_budget where report_project_id=' . $project_id;
    $resDel = mysqli_query($conn, $sqlDel);

    $insertValues = substr($insertValues, 0, -1);
    $sqlInsert = "INSERT INTO report_budget(report_project_id,report_item,report_budget_group,report_quantity,report_price) VALUES {$insertValues};";
//        var_export($sqlInsert);exit;
    $resInsert = mysqli_query($conn, $sqlInsert);
    if (!$resInsert) {
        $_SESSION['error'] .= ' report budget not update.';
    }
}

/* ------------------------- */


/*------ Progress info  ------*/

$sqlProgress = "UPDATE progress_info SET progress_quarter={$_POST['progress_quarter']}
    ,user_id={$_POST['user_id']},progress_indicator_1='{$_POST['progress_indicator_1']}',progress_indicator_2='{$_POST['progress_indicator_2']}'
WHERE  project_id={$project_id}";
//        var_export($sqlProgress);exit;
$resProgress = mysqli_query($conn, $sqlProgress);
//        var_export($resProgress);exit;
if (!$resProgress) {
    $_SESSION['error'] .= ' Progress info not update.';
}
/*------ END Progress Info  ------*/

/*--------- PROJECT INFO --------*/


$sqlProjectInfo = "UPDATE project_info SET indicator_1='{$_POST['indicator_1']}',indicator_1_value='{$_POST['indicator_1_value']}',
indicator_2='{$_POST['indicator_2']}',indicator_2_value='{$_POST['indicator_2_value']}',project_sum_total={$_POST['project_sum_total']}
        WHERE  project_id={$project_id}";
//        var_export($sqlProjectInfo);exit;
$resProjectInfo = mysqli_query($conn, $sqlProjectInfo);
if (!$resProgress) {
    $_SESSION['error'] .= ' Progress info not update.';
}
/*--------- END PROJECT INFO --------*/

/*----------- PLANTS ---------- */
$plants = getPlantFormat($_POST);
if(!empty($plants)) {
    /* Delete first */
    $sqlDel = 'DELETE FROM report_plant where project_id=' . $project_id;
    $resDel = mysqli_query($conn, $sqlDel);


//var_export($plants);exit;
    $insertPlantsValues = '';
    foreach ($plants as $index => $item) {
        $insert = "({$project_id},";
        foreach ($item as $key => $value) {
            $buffInsert[$key] = mysqli_real_escape_string($conn, trim($value));
            if (empty($buffInsert[$key])) {
                $_SESSION['error'] = "something went wrong";
            }
            $buffInsert[$key] = (string)'"' . $buffInsert[$key] . '"';

            if (end($item) === $value) {
                $insert .= "{$buffInsert[$key]})";
            } else {
                $insert .= "{$buffInsert[$key]},";
            }
        }
        $insertPlantsValues .= $insert . ',';
    }
    if (!empty($insertPlantsValues)) {
        $insertPlantsValues = substr($insertPlantsValues, 0, -1);
        $sqlInsert = "INSERT INTO report_plant(project_id,report_detail,report_time,report_place) VALUES {$insertPlantsValues};";
        $resInsert = mysqli_query($conn, $sqlInsert);
//    var_export($resInsert);exit;
        if (!$resInsert) {
            $_SESSION['error'] .= ' report plant not update.';
        }
    }
}



/*-----------END PLANTS ---------- */

if(!empty($_SESSION['error'])){
    header('location: project_manage_edit_performance.php?id=' . $project_id);
}else{
    header('location: project_manage_edit_performance_report.php?id=' . $project_id);
}