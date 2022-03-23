<?php

    include('check_login.php');
    include('../config/db.php');
    $project_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM project_info 
JOIN user_details
    ON user_details.user_id=project_info.user_id
WHERE project_info.project_id=$project_id";
    $result = mysqli_query($conn, $query) or die("Error in sql : $query". mysqli_error($conn));
    $row = mysqli_fetch_array($result);

     $queryde = "SELECT * FROM department_info" or die("Error:" . mysqli_error($conn));
     $departments = mysqli_query($conn, $queryde);
     $department_name = $departments->fetch_assoc()['department_name'];

     $queryStyle = "SELECT * FROM project_style_info"  or die("Error:" . mysqli_error($conn));
     $styles = mysqli_query($conn, $queryStyle);


    $queryProgress = "SELECT * FROM progress_info WHERE project_id=$project_id";
    $progress_info = mysqli_query($conn, $queryProgress);
//    var_export(iterator_to_array($progress_info));exit;
    $progress_info = $progress_info->fetch_assoc();


//     $queryPlan = "SELECT * FROM project_plant WHERE project_id=$project_id";
//     $plans = mysqli_query($conn, $queryPlan);
     include('service_query.php');
     list($groupBudget,$sum) = queryReportBudgets($project_id);
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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/project_edit.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css?v=<?php echo time(); ?>">

    <!-- plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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
    <p>&nbsp&nbsp<span class="material-icons">assignment</span>จัดการโครงการ/<span
            class="material-icons">upload_file</span>แก้ไขรายละเอียดโครงการ</p>


    <div class="grid-edit">
        <div class="grid-item">
            <br>
            <a href="project_manage_edit.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br><br>
            <a href="project_manage_edit_performance.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspรายงานผลการดำเนินงาน&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br>
            <br>
            <a href="project_manage_edit_adjust_project.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติปรับแผนโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br><br>
            <a href="project_manage_edit_disbursement.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติเบิกจ่ายรายครั้ง&nbsp&nbsp&nbsp</a>&nbsp&nbsp
            <br><br>
            <a href="project_manage_edit_close_project.php?id=<?php echo $row['project_id']; ?>" class="detailButton">
                &nbsp&nbsp&nbspขออนุมัติปิดโครงการ&nbsp&nbsp&nbsp</a>&nbsp&nbsp

        </div>
        <div class="grid-item-line">
            <form action="close_project_db.php" method="post">
                <?php include('errors.php'); ?>
                <?php if (isset($_SESSION['error'])) : ?>
                <div class="error">
                    <h3>
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    </h3>
                </div>
                <?php endif ?>
                <div class="grid-item">
                    <div class="row">
                        <div class="col-25">
                            <label for="โครงการ" class="topic">โครงการ:</label>
                        </div>

                        <div class="col-65">
                            <input type="hidden" name="project_id" value="<?php echo $row['project_id'];?>">
                            <input type="text" class="inputFill-Information" name="project_name" required
                                value="<?php echo $row['project_name'];?>" readonly>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ลักษณะโครงการ" class="topic">ลักษณะโครงการ : </label>
                        </div>
                        <div class="col-65">
                            <?php foreach ($styles as $style): ?>
                            <?php if((string) $row['project_style'] === (string) $style['project_style_id']): ?>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ภายใต้ยุทธศาสตร์" class=" topic">ภายใต้ยุทธศาสตร์ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="project_strategy" class="inputFill-Information"
                                id="project_strategy"
                                value="<?php  if(!empty($row['project_strategy'])) echo $row['project_strategy'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ภายใต้แผนงานประจำ" class="topic">ภายใต้แผนงานประจำ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="routine_plan" class="inputFill-Information" id="routine_plan"
                                value="<?php if(!empty($row['routine_plan']))echo $row['routine_plan'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ฝ่ายงาน" class="topic">ฝ่ายงาน : </label>
                        </div>
                        <div class="col-65">
                            <select class="inputFill-Information" name="department_id" required>
                                <?php if($departments->num_rows > 0):
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
                    <div class=" row">
                        <div class="col-25">
                            <label for="วัตถุประสงค์" class="topic">วัตถุประสงค์ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="objective" class="inputFill-Information" id="project_objective"
                                required value="<?php if(!empty($row['objective'])) echo $row['objective'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ลักษณะการดำเนินงาน" class="topic">รายละเอียดจัดโครงการ : </label>
                        </div>
                        <div class="col-65">
                            <textarea name="operation" rows="4" cols="50" class="inputFill-Information-large"
                                id="reason"
                                required><?php if(!empty($row['operation'])) echo $row['operation'] ?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ระยะเวลาดำเนินการ" class="topic">ระยะเวลาดำเนินการ : </label>
                        </div>
                        <div class="col-65">

                            <input type="date" id="dateStart" name="period_op" class="inputFill-Information-Datepicker"
                                required value="<?php echo $row['period_op'] ?>">
                            <label-inline class="topic">ถึง</label-inline>

                            <input type="date" id="dateEnd" name="period_ed" class="inputFill-Information-Datepicker"
                                required value="<?php echo $row['period_ed'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="สถานที่ " class="topic">สถานที่ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="project_place" class="inputFill-Information" id="project_place"
                                required value="<?php echo $row['project_place'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="งบประมาณ " class="topic">งบประมาณ : </label>
                        </div>
                        <div class="col-65">

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="งบประมาณ " class="topic">1. ค่าตอบแทน : </label>
                        </div>
                        <div class="col-65 section-table">
                            <table class="budget table">
                                <thead>
                                    <tr>
                                        <th>รายการ</th>
                                        <th>จำนวน</th>
                                        <th>ราคา</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyCompensation">
                                    <?php if(!empty($groupBudget['compensation'])): ?>
                                    <?php foreach ($groupBudget['compensation'] as $index => $budget) : ?>
                                    <tr class="box-input">
                                        <input type="hidden" name="compensation[budget_id][]"
                                            value="<?php echo $budget['report_budget_id']?>">
                                        <td class="text-left">
                                            <input type="text" class="hiden"
                                                value="<?php echo $budget['report_item'] ?>" name="compensation[item][]"
                                                required>
                                            <span for="" class="item "><?php echo $budget['report_item'] ?></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-quantity hiden"
                                                value="<?php echo $budget['report_quantity'] ?>"
                                                name="compensation[quantity][]" required>
                                            <span for=""
                                                class="quantity"><?php echo $budget['report_quantity'] ?></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-price hiden" min="0"
                                                value="<?php echo $budget['report_price'] ?>"
                                                name="compensation[price][<?php /*echo $index*/ ?>]" required>
                                            <span for="" class="price"><?php echo $budget['report_price'] ?></span>
                                            <?php if(end($groupBudget['compensation']) === $budget)  /* last element*/ :?>
                                            <a href="#" data-action="clone" data-target="compensation"><i
                                                    class="fa fa-plus" aria-hidden="true"></i></a>
                                            <a href="#" data-action="remove"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                            <?php else: ?>
                                            <a href="#" data-action="remove"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                    <?php endif; ?>
                                    <tr class="box-input act-input">
                                        <td class="text-left">
                                            <input type="text" name="compensation[item][]">
                                            <span for="" class="item"></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-quantity "
                                                name="compensation[quantity][]">
                                            <span for="" class="quantity"></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-price" name="compensation[price][]">
                                            <span for="" class="price"></span>
                                            <a href="#" data-action="clone" data-target="compensation"><i
                                                    class="fa fa-plus" aria-hidden="true"></i></a>
                                            <a href="#" data-action="remove"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="งบประมาณ" class="topic">2. ค่าใช้สอย : </label>
                        </div>
                        <div class="col-65 section-table">
                            <table class="budget table">
                                <thead>
                                    <tr>
                                        <th>รายการ</th>
                                        <th>จำนวน</th>
                                        <th>ราคา</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyCost">
                                    <?php if(!empty($groupBudget['cost'])): ?>
                                    <?php foreach ($groupBudget['cost'] as $index => $budget) : ?>
                                    <tr class="box-input">
                                        <input type="hidden" name="cost[budget_id][]"
                                            value="<?php echo $budget['report_budget_id']?>">
                                        <td class="text-left">
                                            <input type="text" class="hiden"
                                                value="<?php echo $budget['report_item'] ?>" name="cost[item][]"
                                                required>
                                            <span for="" class="item "><?php echo $budget['report_item'] ?></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-quantity hiden"
                                                value="<?php echo $budget['report_quantity'] ?>" name="cost[quantity][]"
                                                required>
                                            <span for=""
                                                class="quantity"><?php echo $budget['report_quantity'] ?></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-price hiden" min="0"
                                                value="<?php echo $budget['report_price'] ?>"
                                                name="cost[price][<?php /*echo $index*/ ?>]" required>
                                            <span for="" class="price"><?php echo $budget['report_price'] ?></span>
                                            <?php if(end($groupBudget['cost']) === $budget)  /* last element*/ :?>
                                            <a href="#" data-action="clone" data-target="compensation"><i
                                                    class="fa fa-plus" aria-hidden="true"></i></a>
                                            <a href="#" data-action="remove"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                            <?php else: ?>
                                            <a href="#" data-action="remove"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                    <?php endif; ?>
                                    <tr class="box-input act-input">
                                        <td class="text-left">
                                            <input type="text" name="cost[item][]">
                                            <span for="" class="item"></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-quantity" name="cost[quantity][]">
                                            <span for="" class="quantity"></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-price" name="cost[price][]">
                                            <span for="" class="price"></span>
                                            <a href="#" data-action="clone" data-target="cost"><i class="fa fa-plus"
                                                    aria-hidden="true"></i></a>
                                            <a href="#" data-action="remove"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="งบประมาณ" class="topic">3. ค่าวัสดุ : </label>
                        </div>
                        <div class="col-65 section-table">
                            <table class="budget table">
                                <thead>
                                    <tr>
                                        <th>รายการ</th>
                                        <th>จำนวน</th>
                                        <th>ราคา</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyMaterial">
                                    <?php if(!empty($groupBudget['material'])): ?>
                                    <?php foreach ($groupBudget['material'] as $index => $budget) : ?>
                                    <tr class="box-input">
                                        <input type="hidden" name="material[budget_id][]"
                                            value="<?php echo $budget['report_budget_id']?>">
                                        <td class="text-left">
                                            <input type="text" class="hiden"
                                                value="<?php echo $budget['report_item'] ?>" name="material[item][]"
                                                required>
                                            <span for="" class="item "><?php echo $budget['report_item'] ?></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-quantity hiden"
                                                value="<?php echo $budget['report_quantity'] ?>"
                                                name="material[quantity][]" required>
                                            <span for=""
                                                class="quantity"><?php echo $budget['report_quantity'] ?></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-price hiden" min="0"
                                                value="<?php echo $budget['report_price'] ?>"
                                                name="material[price][<?php /*echo $index*/ ?>]" required>
                                            <span for="" class="price"><?php echo $budget['report_price'] ?></span>
                                            <?php if(end($groupBudget['material']) === $budget)  /* last element*/ :?>
                                            <a href="#" data-action="clone" data-target="compensation"><i
                                                    class="fa fa-plus" aria-hidden="true"></i></a>
                                            <a href="#" data-action="remove"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                            <?php else: ?>
                                            <a href="#" data-action="remove"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                    <?php endif; ?>
                                    <tr class="box-input act-input">
                                        <td class="text-left">
                                            <input type="text" name="material[item][]">
                                            <span for="" class="item"></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-quantity" name="material[quantity][]">
                                            <span for="" class="quantity"></span>
                                        </td>
                                        <td>
                                            <input type="number" class="input-price" name="material[price][]">
                                            <span for="" class="price"></span>
                                            <a href="#" data-action="clone" data-target="material"><i class="fa fa-plus"
                                                    aria-hidden="true"></i></a>
                                            <a href="#" data-action="remove"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">

                        </div>
                        <div class="col-65 sum-total">
                            <div for="รวม" class="topic p-right">
                                รวม : <span class="pull-right" id="sum-total">0.00.- บาท</span>
                                <div id="bahttex" class="topic p-right text-right">(.......บาทถ้วน)</div>
                                <input type="hidden" name="project_sum_total" value="0" id="sum_total">
                            </div>
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
                            <label for="ตัวชี้วัดโครงการ" class="topic">1. </label>
                            <input type="text" id="indicator_1" name="indicator_1" class="inputFill-Information"
                                required value="<?php if(!empty($row['indicator_1'])) echo $row['indicator_1'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">เป้าหมายที่กำหนดไว้ : </label>
                            <input type="text" id="indicator_1_value" name="indicator_1_value"
                                class="inputFill-Information-Datepicker" required
                                value="<?php if(!empty($row['indicator_1_value'])) echo $row['indicator_1_value'] ?>">
                        </div>
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการดำเนินงาน : </label>
                            <input type="text" id="progress_indicator_1" name="progress_indicator_1"
                                class="inputFill-Information-Datepicker" required
                                value="<?php if(!empty($progress_info['progress_indicator_1'])) echo $progress_info['progress_indicator_1'] ?>">
                        </div>

                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการประเมินความสำเร็จของโครงการ
                                <br> (ผลการดำเนินงานเทียบกับค่าเป้าหมาย) : </label>
                            <select type="text" id="indicator_success1" name="indicator_success1"
                                class="inputFill-Information-Datepicker" required>
                                <option value=""> กรุณาเลือก </option>
                                <option value="สำเร็จ"
                                    <?php if($row['indicator_success1'] === 'สำเร็จ') echo 'selected'?>> สำเร็จ
                                </option>
                                <option value="ไม่สำเร็จ"
                                    <?php if($row['indicator_success1'] === 'ไม่สำเร็จ') echo 'selected'?>> ไม่สำเร็จ
                                </option>
                            </select>
                        </div>


                    </div>
                    <div class="row">

                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">2. </label>
                            <input type="text" id="indicator_2" name="indicator_2" class="inputFill-Information"
                                required value="<?php if(!empty($row['indicator_2'])) echo $row['indicator_2'] ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">เป้าหมายที่กำหนดไว้ : </label>
                            <input type="text" id="indicator_2_value" name="indicator_2_value"
                                class="inputFill-Information-Datepicker" required
                                value="<?php if(!empty($row['indicator_2_value'])) echo $row['indicator_2_value'] ?>">
                        </div>
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการดำเนินงาน : </label>
                            <input type="text" id="progress_indicator_2" name="progress_indicator_2"
                                class="inputFill-Information-Datepicker" required
                                value="<?php if(!empty($progress_info['progress_indicator_2'])) echo $progress_info['progress_indicator_2'] ?>">
                        </div>

                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการประเมินความสำเร็จของโครงการ
                                <br> (ผลการดำเนินงานเทียบกับค่าเป้าหมาย) : </label>
                            <select type="text" id="indicator_success2" name="indicator_success2"
                                class="inputFill-Information-Datepicker" required>
                                <option value=""> กรุณาเลือก </option>
                                <option value="สำเร็จ"
                                    <?php if($row['indicator_success2'] === 'สำเร็จ') echo 'selected'?>> สำเร็จ
                                </option>
                                <option value="ไม่สำเร็จ"
                                    <?php if($row['indicator_success2'] === 'ไม่สำเร็จ') echo 'selected'?>> ไม่สำเร็จ
                                </option>
                            </select>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="ลักษณะโครงการ : " class="topic">ผู้รับผิดชอบโครงการ : </label>
                        </div>
                        <div class="col-65">

                            <input type="text" name="responsible_man"
                                value="<?php echo $row["user_firstname"]; ?> &nbsp; <?php echo $row["user_lastname"] ?>"
                                class="inputFill-Information" readonly>

                        </div>
                    </div>

                    <div class="container-button">
                        <button onclick="parent.location='home.php'" class="backButton">Back </button>
                        <button type="submit" name="close_project" class="summitButton">Submit</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

    </br>
    <?php mysqli_close($conn); ?>
    <script src="./bahttex.js"></script>
    <script>
    var quantityAll = 0;
    // var priceAll = 0;
    let priceAll = <?php echo $sum ?>;
    let priceTotal = priceAll.toFixed(2)
    //var priceTotal = <?php //echo $sum ?>//;
    var group = $(this).data('target');
    $('#sum-total').html(`${priceTotal}.- บาท`);
    $('#sum_total').val(priceTotal);
    $('#bahttex').html('(' + ThaiBaht(priceAll.toFixed(2)) + ')')
    $(document).on('click', 'a[data-action="clone"]', function(e) {
        e.preventDefault();
        var err = false;
        var section, tr, item, quantity, price;
        var group = $(this).data('target');
        section = $(this).closest('.section-table');
        tr = $(this).closest('.box-input');

        item = $(tr).find('input[name="' + group + '[item][]"]').val();
        quantity = $(tr).find('input[name="' + group + '[quantity][]"]').val();
        price = $(tr).find('input[name="' + group + '[price][]"]').val();

        // remove message pop
        $(section).find('.message-box').remove();

        // has error = true -- message alert pop
        if (item.length === 0 || quantity.length === 0 || price.length === 0) {
            $(section).append(
                `<div class="message message-box"><div class="error"><h3>Enter is required</h3></div></div>`
            )
            return;
        }

        $(tr).find('input').addClass('hiden');

        $(tr).find('span.item').text(item);
        $(tr).find('span.quantity').text(quantity);
        $(tr).find('span.price').text(price);

        $(tr).removeClass('act-input');

        var dup = `<tr class="box-input act-input">
                            <td class="text-left"><input type="text" name="${group}[item][]"><span for="" class="item"></span></td>
                            <td><input type="number" class="input-quantity" name="${group}[quantity][]"><span for="" class="quantity"></span></td>
                            <td>
                                <input type="number" class="input-price" name="${group}[price][]">
                                <span for="" class="price"></span>
                                <a href="#" data-action="remove"><i class="fa fa-minus" aria-hidden="true"></i></a>
                                <a href="#" data-action="clone" data-target="${group}">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>`;

        priceAll += parseFloat(price * quantity);
        $(section).find('table > tbody').append(dup);
        var priceTotal = priceAll.toFixed(2);
        $('#sum-total').html(`${priceTotal}.- บาท`);
        $('#sum_total').val(priceTotal);
        $('#bahttex').html('(' + ThaiBaht(priceAll.toFixed(2)) + ')')
    })

    $(document).on('click', 'a[data-action="remove"]', function(e) {
        e.preventDefault();
        // get element tr 
        var tr = $(this).closest('.box-input');
        // get price from span
        var price = $(tr).find('.input-price').val();
        var quantity = $(tr).find('.input-quantity').val()
        if (price !== "undefined") {
            priceAll = parseFloat(priceAll) - parseFloat(price * quantity);
            priceAll = priceAll < 0 ? 0 : priceAll;
            $(this).closest('tr').remove();
            $('#sum-total').html(`${priceAll.toFixed(2)}.- บาท`);
            $('#bahttex').html('(' + ThaiBaht(priceAll.toFixed(2)) + ')')
        }
    })
    </script>
</body>

</html>