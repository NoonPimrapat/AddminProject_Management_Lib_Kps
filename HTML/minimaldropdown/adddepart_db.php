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

    if (isset($_POST['Add_depart'])) {

    isset($_REQUEST['departname']) ? $departname = $_REQUEST['departname'] : $departname = '';
    echo $departname;
    
       
        $departname = mysqli_real_escape_string($conn, $_POST['departname']);
        
        
        $user_check_query = "SELECT * FROM department_info WHERE department_name = '$departname'  LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);
        
        if ($result) { // if user exists
            if ($result['department_name'] === $departname) {
                array_push($errors, "department_name already exists");
            }
            
        }

        if (empty($departname)) {
            array_push($errors, "departname is required");
            $_SESSION['error'] = "departname is required";
        }
        

        

        

        if (count($errors) == 0) {
            
            
            $sql = "INSERT INTO department_info (department_name) VALUES ('$departname')";
            mysqli_query($conn, $sql);

            if($result) {
                echo "<script type='text/javascript'>";
                    echo "alert('Error!!');";
                    echo "window.location = 'edit_depart.php';";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>";
                echo "alert('Update Successfully');";
                echo "window.location = 'edit_depart.php';";
            echo "</script>";
            }
  
            // if (mysqli_query($conn, $sql)) {
            //     echo "New record created successfully";
            //   } else {
            //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            //   }
            $_SESSION['user_email'] = $email;
            $_SESSION['success'] = "You are now logged in";
            // header('location: .../minimaldropdown/chek_user.php');
        } 
    }

?>