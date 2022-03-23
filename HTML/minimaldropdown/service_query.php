<?php

function queryBudgets($project_id) {
    include('../config/db.php');
    $budgetQuery = "SELECT budget_id,budget_group,item,quantity,price FROM project_budget WHERE project_id=$project_id";
    $budgets = mysqli_query($conn, $budgetQuery) or die("Error in sql : $budgetQuery". mysqli_error($conn));
    $budgets = (iterator_to_array($budgets));
    $groupBudget = [];
    $sum = 0;
    foreach ($budgets as $budget) {
        // set for check group budget
        if($budget['budget_group']) {
            $groupBudget[$budget['budget_group']][] = $budget;
            $sum = $sum + $budget['quantity'] * $budget['price'];
        }
    }
    return [$groupBudget,$sum];
}

function queryReportBudgets($project_id) {
    include('../config/db.php');
    $budgetQuery = "SELECT report_budget_id,report_budget_group,report_item,report_quantity,report_price FROM report_budget WHERE report_project_id=$project_id";
    $budgets = mysqli_query($conn, $budgetQuery) or die("Error in sql : $budgetQuery". mysqli_error($conn));
    $budgets = (iterator_to_array($budgets));
    $groupBudget = [];
    $sum = 0;
    foreach ($budgets as $budget) {
        // set for check group budget
        if($budget['report_budget_group']) {
            $groupBudget[$budget['report_budget_group']][] = $budget;
            $sum = $sum + $budget['report_quantity'] * $budget['report_price'];
        }
    }
    return [$groupBudget,$sum];
}

function queryProjectInfo($project_id) {
    include('../config/db.php');
    $query = "SELECT * FROM project_info WHERE project_id=$project_id";
    $project = mysqli_query($conn, $query) or die("Error in sql : $query". mysqli_error($conn));
    $project = (iterator_to_array($project));
    return $project;
}

function queryUser($user_id){
    include('../config/db.php');
    $query = "SELECT * FROM user_details WHERE user_id=$user_id";
    $user = mysqli_query($conn, $query) or die("Error in sql : $query". mysqli_error($conn));
    $user = (iterator_to_array($user));
    return $user;
}

function queryFiles($project_id)
{
    include('../config/db.php');
    $query = "SELECT * FROM project_files WHERE project_id=$project_id";
    $files = mysqli_query($conn, $query) or die("Error in sql : $query". mysqli_error($conn));
    $files = (iterator_to_array($files));
    return $files;

}

function queryImage($file_id) {
    include('../config/db.php');
    $query = "SELECT * FROM project_files WHERE file_id=$file_id";
    $files = mysqli_query($conn, $query) or die("Error in sql : $query". mysqli_error($conn));
    $files = (iterator_to_array($files));
    return $files;
}