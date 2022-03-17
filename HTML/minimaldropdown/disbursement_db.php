<?php
/**
 *  Created by PhpStorm.
 *  User: Rock Melody
 *  on 3/10/2022.
 *  on 12:07 PM.
 */


include('check_login.php');
include('../config/db.php');
include('service.php');
include('service_query.php');
require_once("vendor/autoload.php");

if (isset($_POST['disbursement'])) {
    $project_id = $_POST['project_id'];

    $user_id = $_SESSION['user_id'];
    $errors = [];
    $buffInsert = $_POST;
    unset($buffInsert['project_id']);
    unset($buffInsert['disbursement']);

    $budgets = [];
    foreach ($buffInsert as $key => $value) {
        if(in_array($key,['compensation','cost','material'])){
            $buffBudgets = [];
            foreach($value as $sk => $sv){

                if(in_array($sk,['item','quantity','price'])){
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

    $buffInsert = [];
    /* Delete first */
    $sqlDel =  'DELETE FROM report_budget where report_project_id='.$project_id;
    $resDel = mysqli_query($conn, $sqlDel);


    // check  required
    $insertValues = '';
    foreach ($budgets as $key => $item) {
        $buffReport[$item['budget_group']][] = $item;
    }

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
            if(end($item) === $value) {
                $insert .= "{$buffInsert[$key]})";
            }else{
                $insert .= "{$buffInsert[$key]},";
            }
        }
        $insertValues .= $insert.',';
    }
    if(!empty($insertValues)) {


        /*  ---    PROJECT INFO   ----*/
        $sqlProject = "UPDATE project_info SET project_sum_total='{$_POST['project_sum_total']}' WHERE  project_id={$project_id}";
        $resProject = mysqli_query($conn, $sqlProject);
        if (!$resProject) {
            $_SESSION['error'] .= "project info not update";
        }
        /* END PROJECT INFO*/

        $insertValues = substr($insertValues, 0, -1);
        $sqlInsert = "INSERT INTO report_budget(report_project_id,report_item,report_budget_group,report_quantity,report_price) VALUES {$insertValues};";
//        var_export($sqlInsert);exit;
        $resInsert = mysqli_query($conn, $sqlInsert);

        if (!$resInsert) {
            $_SESSION['error'] = 'report budget not update.';
        }

        $projectInfo = queryProjectInfo($project_id)[0];
        $userInfo = queryUser($projectInfo['user_id'])[0];

        // Add var Word Document
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $templateProcessor = $phpWord->loadTemplate(__dir__ . '/disbursement_project.docx');
        if(!empty($buffReport)) {
            foreach ($buffReport as $group => $list) {
                foreach ($list as $key => $item) {
                    if($key === 0) {
                        $templateProcessor->cloneRow($group.'_item',count($buffReport[$group]));
                    }
                    $templateProcessor->setValue($group.'_item#' . ($key+1), htmlspecialchars($item['item'], ENT_COMPAT, 'UTF-8'));
                    $templateProcessor->setValue($group.'_quantity#' . ($key+1), htmlspecialchars($item['quantity'], ENT_COMPAT, 'UTF-8'));
                    $templateProcessor->setValue($group.'_price#' . ($key+1), htmlspecialchars($item['price'], ENT_COMPAT, 'UTF-8'));

                }
            }


        }
        $date = DateThai(date('Y-mp-d'));
        $templateProcessor->setValue('date', $date);
        $templateProcessor->setValue('year', $projectInfo['project_fiscal_year']);
        $templateProcessor->setValue('name', $userInfo['user_firstname'] .' '. $userInfo['user_lastname'] );
        $templateProcessor->setValue('dept', $userInfo['user_department']);
        $templateProcessor->setValue('project_name', $projectInfo['project_name'] );
        $templateProcessor->setValue('total', number_format($projectInfo['project_sum_total']));
        $templateProcessor->setValue('total_thai', convert($projectInfo['project_sum_total']) );
        $fileName = 'ขออนุมัตเบิกจ่ายเงินโครงการตามแผนปฏิบัติการประจำปี_' . $projectInfo['project_name']/*. '-' . date('d-m-Y his')*/;
        $templateProcessor->saveAs('file_word/' . $fileName . '.docx');
        $file = (__DIR__.'/file_word/'.$fileName.'.docx');
        //$file = ('/file_word/'.$fileName.'.docx');
        $file = preg_replace('/C:\\\\xampp\\\\htdocs/','',$file);
        $file = preg_replace('/\\\\/','/',$file);
        echo("<script>window.open('$file', '_blank');</script>");

    }else{
        $_SESSION['error'] .= 'report budget not update';
    }
    echo("<script>window.open('project_manage_edit_disbursement.php?id={$project_id}','_self');</script>");
}





