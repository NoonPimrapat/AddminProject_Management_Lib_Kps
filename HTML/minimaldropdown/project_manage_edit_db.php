<?php
/**
 *  Created by PhpStorm.
 *  User: Rock Melody
 *  on 3/6/2022.
 *  on 2:56 PM.
 */

session_start();
include('../config/db.php');

if (isset($_POST['Update_Project'])) {
    $project_id = $_POST['project_id'];
    $pro_name = $_POST['project_name'];
    $user_id = $_SESSION['user_id'];
    $errors = [];
    $buff_update = $_POST;
    unset($buff_update['project_id']);
    unset($buff_update['Update_Project']);
    unset($buff_update['plant']);
    unset($buff_update['responsible_man']);
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
            // แผนการดำเนินงาน
            if(!empty($_POST['plant'])) {
                foreach ($_POST['plant'] as $pid => $plant) {
                    $values = "'{$plant['plant_detail']}','{$plant['plant_time']}'";
                    $sql = "UPDATE project_plant SET plant_detail = '{$plant['plant_detail']}', plant_time = '{$plant['plant_time']}' WHERE pid = $pid";
                    $resPlant = mysqli_query($conn, $sql);
                }
            }
            // send line noti
            line_noti("\nมีการแก้ไขอนุมัติโครงการ\nโครงการ: {$_POST['project_name']}\nเริ่ม: {$_POST['period_op']}\nสิ้นสุด: {$_POST['period_ed']}");
            echo("<script>window.open('project_manage_edit_report.php?id={$project_id}','_self');</script>");

        }
        echo("<script>window.open('project_manage_edit.php?id={$project_id}','_self');</script>");
    }
}

function line_noti($msn)
{
    $status = false;
    $message = "404 error.";
    if ($msn) :

        $curl = curl_init();
        $LINE_API_KEY = "LIBWf00oYPIzo4pUDKherAXCQfCiS5NLnE6b8i409eH";//ใส่Key
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://notify-api.line.me/api/notify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "message={$msn}",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer {$LINE_API_KEY}",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $message = "cURL Error #:" . $err;
        } else {
            $status = true;
            $message = "Success";
        }
    endif;
    echo json_encode(array('status' => $status, 'message' => $message, 'response' => $response));
}
