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

    if (isset($_POST['Add_charact'])) {

    isset($_REQUEST['charactname']) ? $charactname = $_REQUEST['charactname'] : $charactname = '';
    echo $charactname;
    
       
        $charactname = mysqli_real_escape_string($conn, $_POST['charactname']);
        
        
        $user_check_query = "SELECT * FROM project_style_info WHERE project_style_name = '$charactname'  LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);
        
        if ($result) { // if user exists
            if ($result['project_style_name'] === $charactname) {
                array_push($errors, "charactname already exists");
            }
            
        }

        if (empty($charactname)) {
            array_push($errors, "charactname is required");
            $_SESSION['error'] = "charactname is required";
        }
        

        

        

        if (count($errors) == 0) {
            
            
            $sql = "INSERT INTO project_style_info (project_style_name) VALUES ('$charactname')";
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
            // $_SESSION['success'] = "You are now logged in";
            // header('location: .../minimaldropdown/chek_user.php');
        } 
    }

?>