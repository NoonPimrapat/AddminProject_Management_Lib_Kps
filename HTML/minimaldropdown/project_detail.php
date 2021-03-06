<?php
    session_start(); 
    include('../config/db.php'); 
    $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM `user_details`"; 
        $result = mysqli_query($conn,$query);
        $query = "SELECT * FROM user_details WHERE user_id='$user_id'";
        $result = mysqli_query($conn, $query) or die("Error in sql : $query" . mysqli_error($conn));
        $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title> Minimal Dropdown Menu</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/eidit_check.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>

<body>
    <!-- <div class="logo-container">
        <div class="logo">
            <img src="../img/kuthai.jpg" alt="logo ku" class="mini-logo">
            <img src="../img/kueng.jpg" alt="logo ku" class="mini-logo-ku">
        </div>
        <div>

        </div>
        <div class="profile-logo">
            <img src="../img/kueng.jpg" alt="logo ku" class="profile">
            <div class="triangleBottom"></div>
        </div>
    </div> -->
    <header>
        <!-- partial:index.partial.html -->
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

        <div class="wrapper">
            <div class="navbar">
                <div class="navbar_left">
                    <div class="logo">
                        <img src="../img/kuthai.jpg" alt="logo ku" class="mini-logo">
                        <img src="../img/kueng.jpg" alt="logo ku" class="mini-logo-ku">
                    </div>
                </div>

                <div class="navbar_right">
                    <div class="profile">
                        <div class="icon_wrap">
                            <img src="<?php echo $row['user_pic']; ?>" alt="profile_pic">
                            <span class="name"><?php echo $row['user_firstname']; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <div class="profile_dd">
                            <ul class="profile_ul">
                                <!-- logged in user information เช็คว่ามีการล็อคอินเข้ามาไหม -->
                                <?php if (isset($_SESSION['email'])) : ?>
                                <?php endif ?>
                                <li class="profile_li"><a class="profile" href="profile.php"><span class="picon"><i
                                                class="fas fa-user-alt"></i>
                                        </span>Profile</a>
                                    <div class="btn">My Account</div>
                                </li>
                                <li><a class="logout" href="home.php?logout='1'"><span class="picon"><i
                                                class="fas fa-sign-out-alt"></i></span>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- partial -->
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
        <script src="script.js"></script>
    </header>
    <header>
        <div class="nav">
            <ul>
                <li class="a"><a href="operation_result.php"> สรุปการดำเนินงาน </a> </li>
                <li class="b"><a href="#"> จัดการบุคลากร </a>
                    <ul>
                        <li><a href="index.php">เพิ่มบุคลากร</a></li>
                        <li><a href="edituser.php">แก้ไข/ลบ บุคลากร</a></li>
                    </ul>
                </li>
                <li class="c"><a href="project_manage.php"> จัดการโครงการ </a> </li>
                <li class="d"><a href="project_detail.php"> จัดการรายละเอียดโครงการ </a> </li>
            </ul>
        </div>
    </header>
    <div class="bar">
        <span class="material-icons">checklist</span>
        <p class="titleBar">จัดการรายละเอียดโครงการ/</p><span class="material-icons">border_color</span>
        <p class="titleBar">แก้ไขรายละเอียด</p>
    </div>
    </br></br>
    <div class="">

        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <a href="edit_perdepart.php" class="detailButton"> &nbsp&nbsp&nbspแผนกบุคลากร&nbsp&nbsp&nbsp</a>&nbsp&nbsp
        <a href="edit_position.php" class="detailButton"> &nbsp&nbsp&nbspตำแหน่งบุคลากร&nbsp&nbsp&nbsp</a>&nbsp&nbsp
        <a href="edit_charact.php" class="detailButton"> &nbsp&nbsp&nbspลักษณะโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp
        <a href="edit_depart.php" class="detailButton"> &nbsp&nbsp&nbspฝ่ายงาน&nbsp&nbsp&nbsp&nbsp&nbsp</a>&nbsp&nbsp
        <a href="edit_director.php" class="detailButton">
            &nbsp&nbsp&nbspผู้อำนวยการ&nbsp&nbsp&nbsp&nbsp&nbsp</a>&nbsp&nbsp
    </div>



    </tbody>
    </table>
    <?php mysqli_close($conn); ?>
</body>

</html>