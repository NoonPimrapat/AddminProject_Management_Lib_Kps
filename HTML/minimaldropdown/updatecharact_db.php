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

    if (isset($_POST['Update_charact'])) {
        isset($_REQUEST['charactname']) ? $charactname = $_REQUEST['charactname'] : $charactname = '';
    echo $charactname;
    
        $charactname = mysqli_real_escape_string($conn, $_POST['charactname']);
        
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        if (empty($charactname)) {
            array_push($errors, "charactname is required");
            $_SESSION['error'] = "charactname is required";
        }
        

        $user_check_query = "SELECT * FROM project_style_info WHERE project_style_name = '$charactname' LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        // if ($result) { // if user exists
        //     if ($result['user_firstname'] === $firstname) {
        //         array_push($errors, "Firstname already exists");
        //     }
        //     if ($result['user_lastname'] === $lastname) {
        //         array_push($errors, "Lastname already exists");
        //     }
        //     if ($result['user_position'] === $type_sex) {
        //         array_push($errors, "Type_sex already exists");
        //     }
        //     if ($result['user_position'] === $position) {
        //         array_push($errors, "Position already exists");
        //     }
        //     if ($result['user_department'] === $department) {
        //         array_push($errors, "Department already exists");
        //     }
        //     if ($result['user_phone'] === $phone) {
        //         array_push($errors, "Phone already exists");
        //     }
        //     if ($result['user_email'] === $email) {
        //         array_push($errors, "Email already exists");
        //     }
        //     if ($result['user_password'] === $password) {
        //         array_push($errors, "Password already exists");
        //     }
        // }

        if (count($errors) == 0) {
            
            
            $sql = "UPDATE project_style_info SET
            
            project_style_name='$charactname' 
                
                
                WHERE project_style_id = $id
                 
                 
                "; 
                   
            mysqli_query($conn, $sql);
           
            if($result) {
                echo "<script type='text/javascript'>";
                    echo "alert('Error!!');";
                    echo "window.location = 'edit_charact.php';";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>";
                echo "alert('Update Successfully');";
                echo "window.location = 'edit_charact.php';";
            echo "</script>";
            }
            

            // if (mysqli_query($conn, $sql)) {
            //     echo "New record created successfully";
            //   } else {
            //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            //   }
           // $_SESSION['user_email'] = $email;
            //$_SESSION['success'] = "You are now logged in";
            // header('location: .../minimaldropdown/chek_user.php');
        } 
    }

?>