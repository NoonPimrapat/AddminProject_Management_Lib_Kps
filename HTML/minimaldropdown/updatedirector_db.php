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

    if (isset($_POST['Update_director'])) {
        isset($_REQUEST['directorname']) ? $directorname = $_REQUEST['directorname'] : $directorname = '';
    echo $directorname;
        isset($_REQUEST['directorlastname']) ? $directorlastname = $_REQUEST['directorlastname'] : $directorlastname = '';
    echo $directorlastname;
    
        $directorname = mysqli_real_escape_string($conn, $_POST['directorname']);
        $directorlastname = mysqli_real_escape_string($conn, $_POST['directorlastname']);
        
        $id = mysqli_real_escape_string($conn, $_POST['id']);

        if (empty($directorname)) {
            array_push($errors, "directorname is required");
            $_SESSION['error'] = "directorname is required";
        }
        if (empty($directorlastname)) {
            array_push($errors, "directorlastname is required");
            $_SESSION['error'] = "directorlastname is required";
        }
        

        $user_check_query = "SELECT * FROM director_info WHERE director_name = '$directorname' OR director_lastname = '$directorlastname'   LIMIT 1";
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
            
            
            $sql = "UPDATE director_info SET
            
            director_name='$directorname',
            director_lastname='$directorlastname' 
                
                
                WHERE director_id = $id
                 
                 
                "; 
                   
            mysqli_query($conn, $sql);
           
            if($result) {
                echo "<script type='text/javascript'>";
                    echo "alert('Update Successfully');";
                    echo "window.location = 'edit_director.php';";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>";
                echo "alert('Error!!');";
                echo "window.location = 'edit_director.php';";
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