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

        

        $user_check_query = "SELECT * FROM department_info WHERE department_name = '$departname'  LIMIT 1";
        $query = mysqli_query($conn, $user_check_query);
        $result = mysqli_fetch_assoc($query);

        
//delete data
        // if (count($errors) == 0) {
        //     $password = md5($password);
            
            $sql = "DELETE FROM department_info WHERE department_id = $id "; 
                   
            mysqli_query($conn, $sql);
           
            if($result) {
                echo "<script type='text/javascript'>";
                    //echo "alert('DELETE Successfully');";
                    echo "window.location = 'edit_depart.php';";
                echo "</script>";
            }else{
                echo "<script type='text/javascript'>";
                //echo "alert('Error!!');";
                echo "window.location = 'edit_depart.php';";
            echo "</script>";
            }
            


?>