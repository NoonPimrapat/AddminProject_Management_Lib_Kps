<?php
/**
 *  Created by PhpStorm.
 *  User: Rock Melody
 *  on 3/16/2022.
 *  on 3:33 PM.
 */

session_start();
include('../config/db.php');

echo '<pre>';
//var_export($_POST);
//exit();
include('service.php');



$buffInsert = [];


$project_id = $_POST['project_id'];
$user_id = $_SESSION['user_id'];
$errors = [];
$buffInsert = $_POST;
unset($buffInsert['project_id']);
unset($buffInsert['disbursement']);
unset($buffInsert['project_sum_total']);

/* BUDGETS  */
$budgets = getBudgetFormat($_POST);


/* Delete first */
$sqlDel =  'DELETE FROM report_budget where report_project_id='.$project_id;
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
        if($key === 'report_quantity') {
            $buffInsert[$key] = (int) $buffInsert[$key];
        }else if($key === 'report_price') {
            $buffInsert[$key] = (float) $buffInsert[$key];
        }else{
            $buffInsert[$key] = (string) '"'.$buffInsert[$key].'"';
        }
        if(array_key_last($item) === $key) {
            $insert .= "{$buffInsert[$key]})";
        }else{
            $insert .= "{$buffInsert[$key]},";
        }
    }
    $insertValues .= $insert.',';
}
if(!empty($insertValues)) {
    $insertValues = substr($insertValues,0, -1);
    $sqlInsert = "INSERT INTO report_budget(report_project_id,report_item,report_budget_group,report_quantity,report_price) VALUES {$insertValues};";
//        var_export($sqlInsert);exit;
    $resInsert = mysqli_query($conn, $sqlInsert);
    if($resInsert) {
//            var_export($resInsert);exit;
        //todo : something;
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
if($resProgress) {
    //todo : something;
}

/*--------- PROJECT INFO --------*/


$sqlProjectInfo = "UPDATE project_info SET indicator_1='{$_POST['indicator_1']}',indicator_1_value='{$_POST['indicator_1_value']}',
indicator_2='{$_POST['indicator_2']}',indicator_2_value='{$_POST['indicator_2_value']}'
        WHERE  project_id={$project_id}";
//        var_export($sqlProjectInfo);exit;
$resProjectInfo = mysqli_query($conn, $sqlProjectInfo);
if($resProgress) {
    //todo : something;
}



/*----------- PLANTS ---------- */

// TODO : Maybe delete
/* Delete first */
$sqlDel =  'DELETE FROM report_plant where project_id='.$project_id;
$resDel = mysqli_query($conn, $sqlDel);

$plants = getPlantFormat($_POST);

//var_export($plants);exit;
$insertPlantsValues = '';
foreach ($plants as $index => $item) {
    $insert = "({$project_id},";
    foreach ($item as $key => $value) {
        $buffInsert[$key] = mysqli_real_escape_string($conn, trim($value));
        if (empty($buffInsert[$key])) {
            $_SESSION['error'] = "something went wrong";
        }
        $buffInsert[$key] = (string) '"'.$buffInsert[$key].'"';

        if(array_key_last($item) === $key) {
            $insert .= "{$buffInsert[$key]})";
        }else{
            $insert .= "{$buffInsert[$key]},";
        }
    }
    $insertPlantsValues .= $insert.',';
}
if(!empty($insertPlantsValues)) {
    $insertPlantsValues = substr($insertPlantsValues,0, -1);
    $sqlInsert = "INSERT INTO report_plant(project_id,report_detail,report_time,report_place) VALUES {$insertPlantsValues};";
    $resInsert = mysqli_query($conn, $sqlInsert);
//    var_export($resInsert);exit;
    if($resInsert) {
        //todo : something;
    }
}

header('location: project_manage_edit_performance.php?id='.$project_id);





