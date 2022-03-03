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

    if (isset($_POST['Add_director'])) {

    isset($_REQUEST['directorname']) ? $directorname = $_REQUEST['directorname'] : $directorname = '';
    echo $directorname;
    isset($_REQUEST['directorlastname']) ? $directorlastname = $_REQUEST['directorlastname'] : $directorlastname = '';
    echo $directorlastname;
    
       
        $directorname = mysqli_real_escape_string($conn, $_POST['directorname']);
        $directorlastname = mysqli_real_escape_string($conn, $_POST['directorlastname']);
        
        
        $user_check_query = "SELECT * FROM director_info WHERE director_name = '$directorname' OR director_lastname = '$directorlastname'   LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);
        
        if ($result) { // if user exists
            if ($result['director_name'] === $directorname) {
                array_push($errors, "director_name already exists");
            }
            if ($result['director_lastname'] === $directorlastname) {
                array_push($errors, "director_lastname already exists");
            }
            
        }

        if (empty($directorname)) {
            array_push($errors, "directorname is required");
            $_SESSION['error'] = "directorname is required";
        }
        if (empty($directorlastname)) {
            array_push($errors, "directorlastname is required");
            $_SESSION['error'] = "directorlastname is required";
        }
        

        

        

        if (count($errors) == 0) {
            
            
            $sql = "INSERT INTO director_info (director_name, director_lastname ) VALUES ('$directorname','$directorlastname')";
            mysqli_query($conn, $sql);

            if($result) {
                echo "<script type='text/javascript'>";
                    echo "alert('Error!!');";
                    echo "window.location = 'edit_director.php';";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>";
                echo "alert('Update Successfully');";
                echo "window.location = 'edit_director.php';";
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