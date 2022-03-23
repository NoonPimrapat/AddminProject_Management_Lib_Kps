<?php
    session_start();
    include('../config/db.php');

    $errors = array();
    if (isset($_POST['Login'])) {
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);

        if (empty($email)) {
            array_push($errors,"Email is required");
        }

        if (empty($password)) {
            array_push($errors,"Password is required");
        }

        if (count($errors)==0) {
            //$password = md5($password);
            $query = "SELECT * FROM user_details WHERE user_email = '$email' AND user_password = '$password'";
            $result = mysqli_query($conn,$query);
            $row = mysqli_fetch_array($result);
            // echo $row . "\n";
            // foreach($row as $rows){
            //     // echo $row . "\n";
            //     echo("<script>console.log('result ".$row."');</script>");
            // };
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['user_email']=$email;
                $_SESSION['user_id']=$row["user_id"];
                if ($row["user_status"]==2) {
                $_SESSION['success']='Your are now loggen in';
                header("location: sum_plan.php");
                }else{
                array_push($errors, "Wrong Username or Password");
                $_SESSION['error'] = "Wrong Username or Password!";
                header("location: login.php");
                }
                
                // $_SESSION['success']='Your are now loggen in';
                // header("location: home.php");
                }else {
                array_push($errors, "Wrong Username or Password");
                $_SESSION['error'] = "Wrong Username or Password!";
                header("location: login.php");
                // echo "Wrong Username or Password!";
                }
     
        }
        else{
            array_push($errors,"Wrong email/password combination");
    }

}
?>