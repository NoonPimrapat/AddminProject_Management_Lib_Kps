<?php 
    session_start();
    include('../config/db.php');
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';

    // echo '<hr>';
    
    // echo '<pre>';
    // var_dump($_POST);

    // echo '</pre>';
    //exit;
    $errors = array();

    if (isset($_POST['Add_User'])) {

    // isset($_REQUEST['firstname']) ? $firstname = $_REQUEST['firstname'] : $firstname = '';
    // //echo $firstname;
    // isset($_REQUEST['lastname']) ? $lastname = $_REQUEST['lastname'] : $lastname = '';
    // //echo $lastname;
    // isset($_REQUEST['type_sex']) ? $type_sex = $_REQUEST['type_sex'] : $type_sex = '';
    // //echo $type_sex;
    // isset($_REQUEST['position']) ? $position = $_REQUEST['position'] : $position = '';
    // //echo $position;
    // isset($_REQUEST['type_user']) ? $type_user = $_REQUEST['type_user'] : $type_user = '';
    // //echo $type_user;
    // isset($_REQUEST['department']) ? $department = $_REQUEST['department'] : $department = '';
    // //echo $department;
    // isset($_REQUEST['tel']) ? $phone = $_REQUEST['tel'] : $phone = '';
    // //echo $phone;
    // isset($_REQUEST['email']) ? $email = $_REQUEST['email'] : $email = '';
    // //echo $email;
    // isset($_REQUEST['password']) ? $password = $_REQUEST['password'] : $password = '';
    // //echo $password;
    // isset($_REQUEST['fileToUpload']) ? $pic = $_REQUEST['fileToUpload'] : $pic = '';
    // //echo $pic;
       
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $type_sex = mysqli_real_escape_string($conn, $_POST['type_sex']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $type_user = mysqli_real_escape_string($conn, $_POST['type_user']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $phone = mysqli_real_escape_string($conn, $_POST['tel']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $profile_Upload = mysqli_real_escape_string($conn, $_POST['profile_Upload']);
        // $pic = mysqli_real_escape_string($conn, $_POST['fileToUpload']);
        
        // if (empty($firstname)) {
        //     array_push($errors, "Firstname is required");
        //     $_SESSION['error'] = "Firstname is required";
        // }
        // if (empty($lastname)) {
        //     array_push($errors, "Lastname is required");
        //     $_SESSION['error'] = "Lastname is required";
        // }
        // if (empty($position)) {
        //     array_push($errors, "Position is required");
        //     $_SESSION['error'] = "Position is required";
        // }
        // if (empty($department)) {
        //     array_push($errors, "Department is required");
        //     $_SESSION['error'] = "Department is required";
        // }
        // if (empty($phone)) {
        //     array_push($errors, "Phone is required");
        //     $_SESSION['error'] = "Phone is required";
        // }
        // if (empty($email)) {
        //     array_push($errors, "Email is required");
        //     $_SESSION['error'] = "Email is required";
        // }
        // if (empty($password)) {
        //     array_push($errors, "Password is required");
        //     $_SESSION['error'] = "Password is required";
        // }
        // if (empty($pic)) {
        //     array_push($errors, "fileToUpload is required");
        //     $_SESSION['error'] = "fileToUpload is required";
        // }

        $user_check_query = "SELECT * FROM user_details WHERE user_firstname = '$firstname' OR user_lastname = '$lastname' OR user_phone = '$phone' OR user_email = '$email'  LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        if ($result) { // if user exists
            if ($result['user_firstname'] === $firstname) {
                array_push($errors, "Firstname already exists");
                echo "<script type='text/javascript'>";
                    echo "alert('Firstname already exists!!');";
                    echo "window.location = 'index.php';";
                echo "</script>";
            }
            if ($result['user_lastname'] === $lastname) {
                array_push($errors, "Lastname already exists");
                echo "<script type='text/javascript'>";
                    echo "alert('Lastname already exists!!');";
                    echo "window.location = 'index.php';";
                echo "</script>";
            }
            if ($result['user_position'] === $type_sex) {
                array_push($errors, "Type_sex already exists");
            }
            if ($result['user_position'] === $position) {
                array_push($errors, "Position already exists");
            }
            if ($result['user_department'] === $department) {
                array_push($errors, "Department already exists");
            }
            if ($result['user_phone'] === $phone) {
                array_push($errors, "Phone already exists");
                echo "<script type='text/javascript'>";
                    echo "alert('Phone already exists!!');";
                    echo "window.location = 'index.php';";
                echo "</script>";
            }
            if ($result['user_email'] === $email) {
                array_push($errors, "Email already exists");
                echo "<script type='text/javascript'>";
                    echo "alert('Email already exists!!');";
                    echo "window.location = 'index.php';";
                echo "</script>";
            }
            if ($result['user_password'] === $password) {
                array_push($errors, "Password already exists");
                echo "<script type='text/javascript'>";
                    echo "alert('Password already exists!!');";
                    echo "window.location = 'index.php';";
                echo "</script>";
            }
        }

        

        

        

        if (count($errors) == 0) {
            //$password = md5($password);
            
            $sql = "INSERT INTO user_details (user_firstname, user_lastname,user_typeSex, user_position,user_status,user_department,user_phone,user_email,user_password,user_pic) VALUES ('$firstname', '$lastname','$type_sex', '$position','$type_user','$department','$phone','$email','$password','$profile_Upload')";
            mysqli_query($conn, $sql);

            if($result) {
                echo "<script type='text/javascript'>";
                    echo "alert('Error!!');";
                    echo "window.location = 'edituser.php';";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>";
                echo "alert('ADD Successfully');";
                echo "window.location = 'edituser.php';";
            echo "</script>";
            }
            
            $_SESSION['user_email'] = $email;
            $_SESSION['success'] = "You are now logged in";
             //header('location: edituser.php');
        } 
    }

?>