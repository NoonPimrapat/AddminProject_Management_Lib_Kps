<?php


    session_start();
    include('../config/db.php');
    $project_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM project_info 
JOIN user_details
    ON user_details.user_id=project_info.user_id
WHERE project_info.project_id=$project_id";
    $result = mysqli_query($conn, $query) or die("Error in sql : $query". mysqli_error($conn));
    $row = mysqli_fetch_array($result);
//    var_export($row);exit;

     $queryde = "SELECT * FROM department_info" or die("Error:" . mysqli_error());
     $departments = mysqli_query($conn, $queryde);

    $queryProgress = "SELECT * FROM progress_info WHERE project_id=$project_id";
    $progress_info = mysqli_query($conn, $queryProgress);
    $progress_info = $progress_info->fetch_assoc();
//    var_export($progress_info);exit;

    $queryPlants = "SELECT * FROM report_plant WHERE project_id=$project_id";
    $plants = mysqli_query($conn, $queryPlants);
//    var_export(iterator_to_array($plants));exit;
     include('service_query.php');
     list($groupBudget,$sum) = queryReportBudgets($project_id);
//     var_export($groupBudget);exit;
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
            <form action="performance_db.php" method="post">
                <input type="hidden" name="project_id" value="<?php echo $project_id?>">
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
                    <label for="โครงการ" class="topic center">การรายงานความก้าวหน้า</label>
                    <div class="row">
                        <div class="col-25">
                            <label for="โครงการ" class="topic">โครงการ:</label>
                        </div>

                        <div class="col-65">
                            <input type="text" class="inputFill-Information" name="project_name" id="pro_name" readonly
                                value="<?php echo $row['project_name'];?>">

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="โครงการ" class="topic">รายงาน ณ ไตรมาส ที่:</label>
                        </div>
                        <div class="col-65">
                            <select name="progress_quarter" class="inputFill-Information-small mt 30" id="project_name"
                                    required>
                                <?php if(!empty($progress_info['progress_quarter'])): ?>

                                    <?php for($i=1;$i<=4;$i++): ?>
                                        <option value="<?php echo $i?>" <?php if( (int)$progress_info['progress_quarter'] === $i) echo 'selected' ?>><?php echo $i ?> </option>
                                    <?php endfor; ?>
                                <?php else: ?>
                                    <option value=""> กรุณาเลือก </option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                <?php endif; ?>

                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการดำเนินงาน : </label>
                        </div>
                        <div class="col-65 section-table">
                            <table class="table" style="margin-top: 25px;">
                                <thead>
                                    <tr>
                                        <th>กิจกรรม</th>
                                        <th>ระยะเวลาดำเนินการ</th>
                                        <th>สถานที่</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($plants->num_rows > 0): ?>
                                        <?php foreach($plants as $plant) :?>
                                            <tr class="box-input">
                                                <td>
                                                    <input type="text" name="plant_detail[]" class="hiden">
                                                    <span class="textplant_detail"><?php echo $plant['report_detail']?></span>
                                                </td>
                                                <td>
                                                    <input type="text" name="plant_time[]" class="hiden">
                                                    <span class="textplant_time"><?php echo $plant['report_time']?></span>
                                                </td>
                                                <td>
                                                    <input type="text" name="plant_location[]" class="hiden">
                                                    <span class="textplant_location"><?php echo $plant['report_place']?></span>
                                                    <a href="#" data-action="remove-plant"><i class="fa fa-minus"
                                                        aria-hidden="true"></i></a>
                                                    <a href="#" data-action="clone-plant" data-target="plant"><i
                                                        class="fa fa-plus" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <tr class="box-input act-input">
                                        <td>
                                            <input type="text" name="plant_detail[]">
                                            <span class="textplant_detail"></span>
                                        </td>
                                        <td>
                                            <input type="text" name="plant_time[]">
                                            <span class="textplant_time"></span>
                                        </td>
                                        <td>
                                            <input type="text" name="plant_location[]">
                                            <span class="textplant_location"></span>
                                            <a href="#" data-action="remove-plant"><i class="fa fa-minus"
                                                    aria-hidden="true"></i></a>
                                            <a href="#" data-action="clone-plant" data-target="plant"><i
                                                    class="fa fa-plus" aria-hidden="true"></i></a>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="งบประมาณ " class="topic">ค่าใช้จ่าย : </label>
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
                                            <input type="hidden" name="compensation[budget_id][]" value="<?php echo $budget['report_budget_id']?>">
                                            <td class="text-left">
                                                <input type="text" class="hiden" value="<?php echo $budget['report_item'] ?>" name="compensation[item][]" required>
                                                <span for="" class="item "><?php echo $budget['report_item'] ?></span>
                                            </td>
                                            <td>
                                                <input type="number" class="input-quantity hiden" value="<?php echo $budget['report_quantity'] ?>" name="compensation[quantity][]" required>
                                                <span for="" class="quantity"><?php echo $budget['report_quantity'] ?></span>
                                            </td>
                                            <td>
                                                <input type="number" class="input-price hiden" min="0" value="<?php echo $budget['report_price'] ?>" name="compensation[price][<?php /*echo $index*/ ?>]" required>
                                                <span for="" class="price"><?php echo $budget['report_price'] ?></span>
                                                <?php if(end($groupBudget['cost']) === $budget)  /* last element*/ :?>
                                                    <a href="#" data-action="clone" data-target="compensation"><i
                                                                class="fa fa-plus" aria-hidden="true"></i></a>
                                                    <a href="#" data-action="remove"><i class="fa fa-minus"
                                                                                        aria-hidden="true"></i></a>
                                                <?php else: ?>
                                                    <a href="#" data-action="remove"><i class="fa fa-minus" aria-hidden="true"></i></a>
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
                                            <input type="hidden" name="cost[budget_id][]" value="<?php echo $budget['report_budget_id']?>">
                                            <td class="text-left">
                                                <input type="text" class="hiden" value="<?php echo $budget['report_item'] ?>" name="cost[item][]" required>
                                                <span for="" class="item "><?php echo $budget['report_item'] ?></span>
                                            </td>
                                            <td>
                                                <input type="number" class="input-quantity hiden" value="<?php echo $budget['report_quantity'] ?>" name="cost[quantity][]" required>
                                                <span for="" class="quantity"><?php echo $budget['report_quantity'] ?></span>
                                            </td>
                                            <td>
                                                <input type="number" class="input-price hiden" min="0" value="<?php echo $budget['report_price'] ?>" name="cost[price][<?php /*echo $index*/ ?>]" required>
                                                <span for="" class="price"><?php echo $budget['report_price'] ?></span>
                                                <?php if(end($groupBudget['cost']) === $budget)  /* last element*/ :?>
                                                    <a href="#" data-action="clone" data-target="compensation"><i
                                                                class="fa fa-plus" aria-hidden="true"></i></a>
                                                    <a href="#" data-action="remove"><i class="fa fa-minus"
                                                                                        aria-hidden="true"></i></a>
                                                <?php else: ?>
                                                    <a href="#" data-action="remove"><i class="fa fa-minus" aria-hidden="true"></i></a>
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
                                            <input type="hidden" name="material[budget_id][]" value="<?php echo $budget['report_budget_id']?>">
                                            <td class="text-left">
                                                <input type="text" class="hiden" value="<?php echo $budget['report_item'] ?>" name="material[item][]" required>
                                                <span for="" class="item "><?php echo $budget['report_item'] ?></span>
                                            </td>
                                            <td>
                                                <input type="number" class="input-quantity hiden" value="<?php echo $budget['report_quantity'] ?>" name="material[quantity][]" required>
                                                <span for="" class="quantity"><?php echo $budget['report_quantity'] ?></span>
                                            </td>
                                            <td>
                                                <input type="number" class="input-price hiden" min="0" value="<?php echo $budget['report_price'] ?>" name="material[price][<?php /*echo $index*/ ?>]" required>
                                                <span for="" class="price"><?php echo $budget['report_price'] ?></span>
                                                <?php if(end($groupBudget['cost']) === $budget)  /* last element*/ :?>
                                                    <a href="#" data-action="clone" data-target="compensation"><i
                                                                class="fa fa-plus" aria-hidden="true"></i></a>
                                                    <a href="#" data-action="remove"><i class="fa fa-minus"
                                                                                        aria-hidden="true"></i></a>
                                                <?php else: ?>
                                                    <a href="#" data-action="remove"><i class="fa fa-minus" aria-hidden="true"></i></a>
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
                    <div class="information-container">
                        <label-1 for="ลักษณะโครงการ" class="topic">รายงานผลการดำเนินงานตามตัวชี้วัด : </label>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label> </label>
                        </div>
                        <div class="col-65">

                        </div>
                    </div>
                    <div class="row">

                        <div class="col-65">
                            <label for="ตัวชี้วัดโครงการ" class="topic">1. </label>
                            <input type="text" id="indicator_1" name="indicator_1" class="inputFill-Information"
                                required value="<?php echo $row['indicator_1'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ค่าเป้าหมาย : </label>
                            <input type="text" id="indicator_1_value" name="indicator_1_value"
                                class="inputFill-Information-Datepicker" required value="<?php echo $row['indicator_1_value'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการดำเนินงาน : </label>
                            <input type="text" id="project_name" name="progress_indicator_1"
                                class="inputFill-Information-Datepicker" required value="<?php if(!empty($progress_info['progress_indicator_1'])) echo $progress_info['progress_indicator_1'] ?>">
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">2. </label>
                            <input type="text" id="indicator_2" name="indicator_2" class="inputFill-Information"
                                required value="<?php echo $row['indicator_2'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ค่าเป้าหมาย : </label>
                            <input type="text" id="indicator_2_value" name="indicator_2_value"
                                class="inputFill-Information-Datepicker" required value="<?php echo $row['indicator_2_value'];?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการดำเนินงาน : </label>
                            <input type="text" id="project_name" name="progress_indicator_2"
                                class="inputFill-Information-Datepicker" required value="<?php if(!empty($progress_info['progress_indicator_2'])) echo $progress_info['progress_indicator_2'] ?>">
                        </div>
                    </div>
                    <div class="information-container">
                        <label-1 for="ลักษณะโครงการ" class="topic">เอกสารแนบ </label>
                    </div>
                    <div class="information-container">
                        <label-1 for="ลักษณะโครงการ" class="topic">1.ภาพกิจกรรม(5-10 ไฟล์) </label>
                            <input id="file-upload" name="activity_pictures" type="file" accept="image/*" multiple />
                    </div>
                    <div class=" information-container">
                        <label-1 for="ลักษณะโครงการ" class="topic">
                            2.รายงานผลการประเมินความพึงพอใจ/การนำความรู้ไปใช้ประโยชน์(ถ้ามี)(3-5 ไฟล์) </label>
                            <input id="file-upload" name="assessment" type="file" accept="file_extension" multiple />
                    </div>
                    <div class="information-container">
                        <label-1 for="ลักษณะโครงการ" class="topic">3.เอกสารการลงทะเบียนเข้าร่วมกิจกรรม(ถ้ามี)(3-5 ไฟล์)
                            </label>
                            <input id="file-upload" name="registration" type="file" accept="file_extension" multiple />
                    </div>
                    <div class="row">
                        <input type="hidden" name="user_id" value="<?php echo $row["user_id"] ?>">
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
                        <button type="reset" value="reset" class="backButton" onclick="parent.location='home.php'">Back
                        </button>
                        <button type="submit" name="performance_report" class="summitButton">Submit</button>
                    </div>
                </div>
                <!-- ส่วนแสดงภาพที่อัพโหลดเข้าไป -->
                <div id='preview'>
                </div>

                <form id="imageform" method="post" enctype="multipart/form-data" action='ajaxImageUpload.php'
                    style="clear:both">

                    <div id='imageloadstatus' style='display:none'>
                        <!-- <img src="loading.gif" alt="Uploading...." /> -->
                        <div id="container">
                            <svg viewBox="0 0 100 100">
                                <defs>
                                    <filter id="shadow">
                                        <feDropShadow dx="0" dy="0" stdDeviation="1.5" flood-color="#00766a" />
                                    </filter>
                                </defs>
                                <circle id="spinner"
                                    style="fill:transparent;stroke:#00766a;stroke-width: 7px;stroke-linecap: round;filter:url(#shadow);"
                                    cx="50" cy="50" r="45" />
                            </svg>
                        </div>
                    </div>
                    <div id='imageloadbutton'>
                        <!-- เลือกได้หลายๆไฟล์ในครั้งเดียว   name="photos[]"  multiple="true"  -->
                        <br>
                        เลือกไฟล์ภาพ :
                        <input type="file" name="photos[]" id="photoimg" multiple="true" />
                    </div>

                </form>
        </div>

    </div>

    </br>
    <?php mysqli_close($conn); ?>
    <script src="./bahttex.js"></script>
    <script>
    var quantityAll = 0;
    let priceAll = <?php echo $sum ?>;
    let priceTotal = priceAll.toFixed(2)
    var group = $(this).data('target');
    $('#sum-total').html(`${priceTotal}.- บาท`);
    $('#sum_total').val(priceTotal);
    $('#bahttex').html('(' + ThaiBaht(priceAll.toFixed(2)) + ')');

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


    $(document).on('click', 'a[data-action="clone-plant"]', function(e) {
        e.preventDefault();
        var err = false;
        var section, tr, textplant_detail, textplant_time, textplant_location;
        var group = $(this).data('target');
        section = $(this).closest('.section-table');
        tr = $(this).closest('.box-input');

        textplant_detail = $(tr).find('input[name="plant_detail[]"]').val();
        textplant_time = $(tr).find('input[name="plant_time[]"]').val();
        textplant_location = $(tr).find('input[name="plant_location[]"]').val();
        // remove message pop
        $(section).find('.message-box').remove();

        // has error = true -- message alert pop
        if (textplant_detail.length === 0 || textplant_time.length === 0 || textplant_location.length === 0) {
            $(section).append(
                `<div class="message message-box"><div class="error"><h3>Enter is required</h3></div></div>`
            )
            return;
        }

        $(tr).find('input').addClass('hiden');

        $(tr).find('span.textplant_detail').text(textplant_detail);
        $(tr).find('span.textplant_time').text(textplant_time);
        $(tr).find('span.textplant_location').text(textplant_location);

        $(tr).removeClass('act-input');

        var dup = `<tr class="box-input act-input">
                <td class="text-left"><input type="text" name="plant_detail[]"><span for="" class="textplant_detail"></span></td>
                <td><input class="textplant_time" name="plant_time[]"><span for="" class="textplant_time"></span></td>
                <td>
                    <input type="text" class="" name="plant_location[]">
                    <span for="" class="textplant_location"></span>
                    <a href="#" data-action="remove-plant"><i class="fa fa-minus" aria-hidden="true"></i></a>
                    <a href="#" data-action="clone-plant" data-target="plant">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>`;

        // priceAll += parseFloat(price * quantity);
        $(section).find('table > tbody').append(dup);
        // var priceTotal = priceAll.toFixed(2);
        // $('#sum-total').html(`${priceTotal}.- บาท`);
        // $('#sum_total').val(priceTotal);
        // $('#bahttex').html('(' + ThaiBaht(priceAll.toFixed(2)) + ')')
    })

    $(document).on('click', 'a[data-action="remove-plant"]', function(e) {
        e.preventDefault();
        // get element tr
        var tr = $(this).closest('.box-input');
        // get price from span
        var textplant_location = $(tr).find('.textplant_location').val();
        var textplant_time = $(tr).find('.textplant_time').val()
        if (textplant_location !== "undefined") {
            $(this).closest('tr').remove();
        }
    })


    </script>
</body>

</html>