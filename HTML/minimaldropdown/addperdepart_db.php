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

    if (isset($_POST['Add_perdepart'])) {

    isset($_REQUEST['perdepartname']) ? $perdepartname = $_REQUEST['perdepartname'] : $perdepartname = '';
    echo $perdepartname;
    
       
        $perdepartname = mysqli_real_escape_string($conn, $_POST['perdepartname']);
        
        
        $user_check_query = "SELECT * FROM perdepartment_info WHERE perdepartment_name = '$perdepartname'  LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);
        
        if ($result) { // if user exists
            if ($result['perdepartment_name'] === $perdepartname) {
                array_push($errors, "perdepartment_name already exists");
            }
            
        }

        if (empty($perdepartname)) {
            array_push($errors, "perdepartname is required");
            $_SESSION['error'] = "perdepartname is required";
        }
        

        

        

        if (count($errors) == 0) {
            
            
            $sql = "INSERT INTO perdepartment_info (perdepartment_name) VALUES ('$perdepartname')";
            mysqli_query($conn, $sql);

            if($result) {
                echo "<script type='text/javascript'>";
                    echo "alert('Error!!');";
                    echo "window.location = 'edit_perdepart.php';";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>";
                echo "alert('Update Successfully');";
                echo "window.location = 'edit_perdepart.php';";
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