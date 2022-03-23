<?php
include('check_login.php');
include('../config/db.php');
include('service.php');
include('service_query.php');
require_once("vendor/autoload.php");

$project_id = $_POST['project_id'];
//echo '<pre>';
//var_export($_POST);
//exit();
if(isset($_POST['adjust_edit'])) {

    /* PROJECT INFO */
    $sqlProject = ("UPDATE project_info set project_fiscal_year={$_POST['project_fiscal_year']} WHERE project_id=$project_id");
    $resProject = mysqli_query($conn, $sqlProject);
    if(!$resProject) {
        $_SESSION['error'] = 'project info not update.';
    }

    /* END PROJECT  */

    /* PROJECT REVISION */
    $sqlRevision = ("UPDATE project_revision set revision_number={$_POST['revision_number']} WHERE project_id=$project_id");
    $revision = mysqli_query($conn, $sqlRevision);
    if(!$revision) {
        $_SESSION['error'] = 'project revision not update.';
    }
    /* END PROJECT REVISION */


    if(empty($_SESSION['error'])) {
        header('location: project_manage_edit_adjust_report.php?id='.$project_id);
    }else{
        header('location: project_manage_edit_adjust_project.php?id='.$project_id);
    }
}