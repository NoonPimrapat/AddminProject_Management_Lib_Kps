<?php
/**
 *  Created by PhpStorm.
 *  User: Rock Melody
 *  on 3/5/2022.
 *  on 19:41 AM.
 */

    session_start();
    include('../config/db.php');
<<<<<<< HEAD
    $project_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM project_info 
=======

    if(!empty($_GET['id'])) {
        $project_id = $_GET['id'];
        $query = "SELECT * FROM project_info 
>>>>>>> 2c061f10bc8384f6842c3919544baa834b33c355
JOIN user_details
    ON user_details.user_id=project_info.user_id
WHERE project_info.project_id=$project_id";
        $result = mysqli_query($conn, $query) or die("Error in sql : $query". mysqli_error($conn));
        $row = mysqli_fetch_array($result);

<<<<<<< HEAD
     $queryde = "SELECT * FROM department_info" or die("Error:" . mysqli_error());
     $departments = mysqli_query($conn, $queryde);
=======
        $queryde = "SELECT * FROM department_info" or die("Error:" . mysqli_error());
        $departments = mysqli_query($conn, $queryde);

        $queryStyle = "SELECT * FROM project_style_info ORDER BY project_style_id asc" or die("Error:" . mysqli_error());
        // เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
        $styles = mysqli_query($conn, $queryStyle);
>>>>>>> 2c061f10bc8384f6842c3919544baa834b33c355

        $queryPlan = "SELECT * FROM project_plant WHERE project_id=$project_id";
        $plans = mysqli_query($conn, $queryPlan);
    }


     //3. query ข้อมูลจากตาราง user_details:
$queryProject = "SELECT * FROM project_info WHERE user_id = '$user_id'" or die("Error:" . mysqli_error());
//เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
$result_Project = mysqli_query($conn, $queryProject);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title> Minimal Dropdown Menu</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/project_edit.css" rel="stylesheet">


</head>

<body>

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
                            <img src="../img/kueng.jpg" alt="profile_pic">
                            <span
                                class="name"><?php if(!empty($_SESSION['user_email'])) echo $_SESSION['user_email'];?></span>
                            <i class="fas fa-chevron-down"></i>
                        </div>

                        <div class="profile_dd">
                            <ul class="profile_ul">
                                <!-- logged in user information เช็คว่ามีการล็อคอินเข้ามาไหม -->
                                <?php if (isset($_SESSION['email'])) :?>
                                <?php endif?>
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
    <p>&nbsp&nbsp<span class="material-icons">assignment</span>จัดการโครงการ/<span
            class="material-icons">upload_file</span>แก้ไขรายละเอียดโครงการ</p>


    <div class="grid-edit">
        <div class="grid-item">
            <?php foreach ($result_Project as $value) { ?>
            <br>
            <a href="project_manage_edit.php?id=" $project_id class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br><br>
            <a href="project_manage_edit_performance.php?id=<?php echo $value['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspรายงานผลการดำเนินงาน&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br>
            <br>
            <a href="edit_perdepart.php" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติปรับแผนโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br><br>
            <a href="edit_perdepart.php" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติเบิกจ่ายรายครั้ง&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br><br>
            <a href="edit_perdepart.php" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติปิดโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <?php } ?>
        </div>
        <div class="grid-item-line">
            <form method="post" id="form" enctype="multipart/form-data" action="project_manage_edit_db.php">
                <?php include('errors.php'); ?>
                <?php if (isset($_SESSION['error'])) : ?>
                <div class="error">
                    <h3>
                        <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
<<<<<<< HEAD
                    </h3>
                </div>
                <?php endif ?>
=======
                </h3>
            </div>
        <?php endif ?>


        <div class="grid-container">
            <?php if(empty($project_id) || empty($row)) :?>
                <div><h2>ไม่พบข้อมูล Project</h2></div>
            <?php exit(); endif; ?>
            <div class="grid-item">
>>>>>>> 2c061f10bc8384f6842c3919544baa834b33c355
                <input type="hidden" name="project_id" value="<?php echo $_GET['id'];?>">
                <div class="row">
                    <div class="col-25">
                        <label class="topic" for="project_name"> โครงการ:</label>
                    </div>
                    <div class="col-65">
                        <input type="text" class="inputFill-Information" name="project_name" required
                            value="<?php echo $row['project_name'];?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label class="topic" for="project_fiscal_year"> ตามแผนปฏิบัติการประจำปีงบประมาณ
                            พ.ศ.:</label>
                    </div>
                    <div class="col-65">
                        <select name="project_fiscal_year" class="inputFill-Information mt-30" required>
                            <?php for($i=$row['project_fiscal_year'];$row['project_fiscal_year'] - $i <= 4;$i--): ?>
                            <option value="<?php echo $i ?>"><?php echo $i?></option>
                            <?php   endfor ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label class="topic" for="project_style"> ลักษณะโครงการ:</label>
                    </div>
                    <div class="col-65 mt-10">
                        <?php if(($styles->num_rows > 0)): ?>
                        <?php foreach ($styles as $style): ?>
                        <?php if($row['project_style'] === $style['project_style_id']): ?>
                        <input name="project_style" class="radio-project-edit"
                            id="radio_<?php echo $style['project_style_id'] ?>" type="radio"
                            value="<?php echo $style['project_style_id'] ?>" checked>
                        <?php else: ?>
                        <input name="project_style" class="radio-project-edit"
                            id="radio_<?php echo $style['project_style_id'] ?>" type="radio"
                            value="<?php echo $style['project_style_id'] ?>" required>
                        <?php endif; ?>
                        <label class="form-check-label" for="radio_<?php echo $style['project_style_id'] ?>">
                            <?php echo $style['project_style_name'] ?>
                        </label>

                        <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label class="topic" for="project_strategy"> ภายใต้แผนยุทธศาสตร์:</label>
                    </div>
                    <div class="col-65 mt-10">
                        <input type="text" class="inputFill-Information" name="project_strategy" required
                            value="<?php  if(!empty($row['project_strategy'])) echo $row['project_strategy'];?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label class="topic" for="routine_plan"> ภายใต้แผนงานประจำ:</label>
                    </div>
                    <div class="col-65">
                        <input type="text" class="inputFill-Information" name="routine_plan" required
                            value="<?php if(!empty($row['routine_plan']))echo $row['routine_plan'];?>">
                    </div>
                </div>
                <div class="row mb-20">
                    <div class="col-25">
                        <label class="topic" for="department_id"> ฝ่ายงาน:</label>
                    </div>
                    <div class="col-65">
                        <select class="inputFill-Information" name="department_id" required>
                            <?php if($departments->num_rows > 0):
//                                echo $row['department_id'];exit;
                                foreach($departments as $department): ?>
                            <?php if($department['department_id'] === $row['department_id']): ?>
                            <option selected value="<?php echo $department['department_id'] ?>">
                                <?php echo $department['department_name']?></option>
                            <?php else: ?>
                            <option value="<?php echo $department['department_id'] ?>">
                                <?php echo $department['department_name']?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label class="topic" for="reason"> หลักการและเหตุผล:</label>
                    </div>
                    <div class="col-65">
                        <textarea class="inputFill-Information-large" name="reason" rows="4" cols="50" required>
                            <?php echo $row['reason'] ?>
                        </textarea>
                    </div>
                </div>
                <div class="row mb-10">
                    <div class="col-25">
                        <label class="topic" for="objective"> วัตถุประสงค์:</label>
                    </div>
                    <div class="col-65">
                        <input class="inputFill-Information" name="objective" type="text"
                            value="<?php if(!empty($row['objective'])) echo $row['objective'] ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="operation" class="topic">ลักษณะการดำเนินงาน : </label>
                    </div>
                    <div class="col-65">
                        <textarea name="operation" rows="4" cols="50" class="inputFill-Information-large" required>
                        <?php if(!empty($row['operation'])) echo $row['operation'] ?>
                    </textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="period_op" class="topic">ระยะเวลาดำเนินการ : </label>
                    </div>
                    <div class="col-65 mt-30">
                        <input type="date" id="dateStart" name="period_op" class="inputFill-Information-Datepicker"
                            required value="<?php echo $row['period_op'] ?>">
                        <label-inline class="topic">ถึง</label-inline>

                        <input type="date" id="dateEnd" name="period_ed" class="inputFill-Information-Datepicker"
                            required value="<?php echo $row['period_ed'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label class="topic" for="project_place"> สถานที่:</label>
                    </div>
                    <div class="col-65">
                        <input class="inputFill-Information" type="text" name="project_place"
                            value="<?php echo $row['project_place'] ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="ตัวชี้วัดโครงการ" class="topic">ตัวชี้วัดโครงการ : </label>
                    </div>
                    <div class="col-65">
                    </div>
                </div>
                <div class="row">
                    <div class="col-65">
                        <label for="indicator_1" class="topic">1. </label>
                        <input type="text" id="project_name" name="indicator_1" class="inputFill-Information"
                            value="<?php if(!empty($row['indicator_1'])) echo $row['indicator_1'] ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-65">
                        <label for="indicator_1_value" class="topic">ค่าเป้าหมาย : </label>
                        <input type="text" id="project_name" name="indicator_1_value"
                            class="inputFill-Information-Datepicker"
                            value="<?php if(!empty($row['indicator_1_value'])) echo $row['indicator_1_value'] ?>"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-65">
                        <label for="indicator_2" class="topic">2. </label>
                        <input type="text" id="project_name" name="indicator_2" class="inputFill-Information"
                            value="<?php if(!empty($row['indicator_2'])) echo $row['indicator_2'] ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-65">
                        <label for="indicator_2_value" class="topic">ค่าเป้าหมาย : </label>
                        <input type="text" id="project_name" name="indicator_2_value"
                            class="inputFill-Information-Datepicker"
                            value="<?php if(!empty($row['indicator_2_value'])) echo $row['indicator_2_value'] ?>"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="responsible_man" class="topic">ผู้รับผิดชอบโครงการ : </label>
                    </div>
                    <div class="col-65 mt-20">
                        <input type="text" name="responsible_man"
                            value="<?php if(!empty($row['user_firstname'])) echo $row['user_firstname'] .' '. $row['user_lastname'] ?>"
                            class="inputFill-Information" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                        <label for="ลักษณะโครงการ : " class="topic">แผนการดำเนินงาน : </label>
                    </div>
                    <div class="col-65 section-table">
                        <table class="table" style="margin-top: 25px;">
                            <thead>
                                <tr>
                                    <th>กิจกรรม</th>
                                    <th>ระยะเวลาดำเนินการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(($plans->num_rows > 0)) : ?>
                                <?php foreach ($plans as $plan) : ?>
                                <?php ?>
                                <tr class="box-input checked">
                                    <td>
                                        <input type="text" name="plant[<?php echo $plan['pid']?>][plant_detail]"
                                            value="<?php echo $plan['plant_detail']?>">
                                        <span class="textplant_detail"></span>
                                    </td>
                                    <td>
                                        <input type="text" name="plant[<?php echo $plan['pid']?>][plant_time]"
                                            value="<?php echo $plan['plant_time']?>">
                                        <span class="textplant_time"></span>
                                    </td>
                                </tr>
                                <?php ?>
                                <?php endforeach;?>
                                <?php else: ?>
                                <td>
                                    <span class="textplant_detail">ไม่มีรายการ แผนการดำเนินงาน</span>
                                </td>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container-button">
                    <button type="reset" value="reset" class="backButton" onclick="parent.location='index.php'">Back
                    </button>
                    <button type="submit" name="Update_Project" class="summitButton">Submit</button>
                </div>
            </form>
        </div>

    </div>

    </br>
    <?php mysqli_close($conn); ?>

</body>

</html>