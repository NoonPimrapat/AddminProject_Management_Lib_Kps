<?php 
    session_start();
    include('../config/db.php');
    // echo '<pre>';
    // print_r($_GET);
    // echo '</pre>';

    // echo '<hr>';
    
    // echo '<pre>';
    // var_dump($_GET);

    // echo '</pre>';
    // //exit;
     $errors = array();


    
    //รับค่าจาก method url $_GET//** */
        
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        

        $user_check_query = "SELECT * FROM user_details WHERE user_firstname = '$firstname' OR user_lastname = '$lastname' OR user_phone = '$phone' OR user_email = '$email'  LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        
//delete data
        // if (count($errors) == 0) {
        //     $password = md5($password);
            
            $sql = "DELETE FROM user_details WHERE user_id = $id "; 
                   
            mysqli_query($conn, $sql);
           
            if($result) {
                echo "<script type='text/javascript'>";
                    //echo "alert('DELETE Successfully');";
                    echo "window.location = 'edituser.php';";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>";
                //echo "alert('Error!!');";
                echo "window.location = 'edituser.php';";
            echo "</script>";
            }
            


?>