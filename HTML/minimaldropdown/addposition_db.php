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

    if (isset($_POST['Add_position'])) {

    isset($_REQUEST['positionname']) ? $positionname = $_REQUEST['positionname'] : $positionname = '';
    echo $positionname;
    
       
        $positionname = mysqli_real_escape_string($conn, $_POST['positionname']);
        
        
        $user_check_query = "SELECT * FROM perposition_info WHERE perposition_name = '$positionname'  LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);
        
        if ($result) { // if user exists
            if ($result['perposition_name'] === $positionname) {
                array_push($errors, "positionname already exists");
            }
            
        }

        if (empty($positionname)) {
            array_push($errors, "charactname is required");
            $_SESSION['error'] = "charactname is required";
        }
        

        

        

        if (count($errors) == 0) {
            
            
            $sql = "INSERT INTO perposition_info (perposition_name) VALUES ('$positionname')";
            mysqli_query($conn, $sql);

            if($result) {
                echo "<script type='text/javascript'>";
                    echo "alert('Error!!');";
                    echo "window.location = 'edit_position.php';";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>";
                echo "alert('Update Successfully');";
                echo "window.location = 'edit_position.php';";
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