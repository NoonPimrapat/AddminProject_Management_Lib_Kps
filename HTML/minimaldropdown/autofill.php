<?php
include('config/db.php');
 $id=$_POST['id'];
//  $id=64;
 $arrayData=[];
 $user_check_query = "SELECT * FROM project_info AS p1 INNER JOIN project_style_info AS p2 INNER JOIN department_info AS p3 INNER JOIN project_budget AS p4 ON (p1.project_style=p2.project_style_id) AND (p1.department_id=p3.department_id) AND (p1.project_id=p4.project_id) WHERE p1.project_id = '$id' ";
 $query = mysqli_query($conn, $user_check_query);


// print_pre($result) ; //ส่งค่ากลับไปหน้าที่เรียก

while ( $result = mysqli_fetch_assoc($query)) {
    # code...
    // print_pre($result);
    $arrayData[]=$result;
    
}
// print_pre($arrayData);
 echo json_encode($arrayData); //ส่งค่ากลับไปหน้าที่เรียก