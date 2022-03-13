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

     $queryde = "SELECT * FROM department_info" or die("Error:" . mysqli_error());
     $departments = mysqli_query($conn, $queryde);

     $queryStyle = "SELECT * FROM project_style_info ORDER BY project_style_id asc" or die("Error:" . mysqli_error());
    // เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
     $styles = mysqli_query($conn, $queryStyle);

     $queryPlan = "SELECT * FROM project_plant WHERE project_id=$project_id";
     $plans = mysqli_query($conn, $queryPlan);
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
            <form action="approval_db.php" method="post">
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
                            <select name="pro_name" class="inputFill-Information" id="pro_name" required>
                                <option value=""> กรุณาเลือก </option>
                                <?php foreach ($result_ProjectName as $results) { ?>
                                <option value="<?php echo $results["project_id"]; ?>">
                                    <?php echo $results["project_name"]; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ลักษณะโครงการ" class="topic">ลักษณะโครงการ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="pro_style" class="inputFill-Information" id="pro_style">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ภายใต้ยุทธศาสตร์" class=" topic">ภายใต้ยุทธศาสตร์ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="pro_strategy" class="inputFill-Information" id="pro_strategy">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ภายใต้แผนงานประจำ" class="topic">ภายใต้แผนงานประจำ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="pro_routine" class="inputFill-Information" id="routine_plan">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ฝ่ายงาน" class="topic">ฝ่ายงาน : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="pro_department" class="inputFill-Information" id="department">

                        </div>
                    </div>
                    <div class=" row">
                        <div class="col-25">
                            <label for="วัตถุประสงค์" class="topic">วัตถุประสงค์ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="pro_objective" class="inputFill-Information" id="pro_objective"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ลักษณะการดำเนินงาน" class="topic">รายละเอียดจัดโครงการ : </label>
                        </div>
                        <div class="col-65">
                            <textarea name="pro_operation" rows="4" cols="50" class="inputFill-Information-large"
                                id="reason" required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="ระยะเวลาดำเนินการ" class="topic">ระยะเวลาดำเนินการ : </label>
                        </div>
                        <div class="col-65">

                            <input type="date" id="dateStart" name="pro_dateStart"
                                class="inputFill-Information-Datepicker" required>
                            <label-inline class="topic">ถึง</label-inline>

                            <input type="date" id="dateEnd" name="pro_dateEnd" class="inputFill-Information-Datepicker"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="สถานที่ " class="topic">สถานที่ : </label>
                        </div>
                        <div class="col-65">
                            <input type="text" name="pro_place" class="inputFill-Information" id="pro_place" required>
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
                                    <!-- <tr class="box-input act-input">
                                    <td class="text-left">
                                        <input type="text" name="compensation[item][]" id="compensation[item][]">
                                        <span for="" class="item" id="compensation[item][]"></span>
                                    </td>
                                    <td>
                                        <input type="number" name="compensation[quantity][]">
                                        <span for="" class="quantity"></span>
                                    </td>
                                    <td>
                                        <input type="number" class="input-price" name="compensation[price][]">
                                        <span for="" class="price"></span>
                                        <a href="#" data-action="clone" data-target="compensation"><i class="fa fa-plus"
                                                aria-hidden="true"></i></a>
                                        <a href="#" data-action="remove"><i class="fa fa-minus"
                                                aria-hidden="true"></i></a>
                                    </td>
                                </tr> -->
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
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">เป้าหมายที่กำหนดไว้ : </label>
                            <input type="text" id="indicator_1_value" name="indicator_1_value"
                                class="inputFill-Information-Datepicker" required>
                        </div>
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการดำเนินงาน : </label>
                            <input type="text" id="indicator_performance1" name="indicator_performance1"
                                class="inputFill-Information-Datepicker" required>
                        </div>

                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการประเมินความสำเร็จของโครงการ
                                <br> (ผลการดำเนินงานเทียบกับค่าเป้าหมาย) : </label>
                            <select type="text" id="indicator_success1" name="indicator_success1"
                                class="inputFill-Information-Datepicker" required>
                                <option value=""> กรุณาเลือก </option>
                                <option value="1"> สำเร็จ </option>
                                <option value="2"> ไม่สำเร็จ </option>
                            </select>
                        </div>


                    </div>
                    <div class="row">

                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">2. </label>
                            <input type="text" id="indicator_2" name="indicator_2" class="inputFill-Information"
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">เป้าหมายที่กำหนดไว้ : </label>
                            <input type="text" id="indicator_2_value" name="indicator_1_value"
                                class="inputFill-Information-Datepicker" required>
                        </div>
                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการดำเนินงาน : </label>
                            <input type="text" id="indicator_performance1" name="indicator_performance2"
                                class="inputFill-Information-Datepicker" required>
                        </div>

                        <div class="col-65">
                            <label for="ลักษณะโครงการ : " class="topic">ผลการประเมินความสำเร็จของโครงการ
                                <br> (ผลการดำเนินงานเทียบกับค่าเป้าหมาย) : </label>
                            <select type="text" id="indicator_success2" name="indicator_success2"
                                class="inputFill-Information-Datepicker" required>
                                <option value=""> กรุณาเลือก </option>
                                <option value="1"> สำเร็จ </option>
                                <option value="2"> ไม่สำเร็จ </option>
                            </select>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="ลักษณะโครงการ : " class="topic">ผู้รับผิดชอบโครงการ : </label>
                        </div>
                        <div class="col-65">

                            <input type="text" name="responsible_man"
                                value="<?php echo $row["user_firstname"]; ?> &nbsp; <?php echo $row["user_lastname"] ?> "
                                class="inputFill-Information" readonly>

                        </div>
                    </div>
                    <div class="information-container">
                        <label-1 for="ลักษณะโครงการ" class="topic">เอกสารแนบ </label>
                    </div>
                    <div class="information-container">
                        <label-1 for="ลักษณะโครงการ" class="topic">1.ภาพกิจกรรม (3-5 ภาพ) </label>
                            <input id="file-upload" name="activity_pictures" type="file" accept="image/*" multiple />
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
    var priceAll = 0;
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
        if (item.length == 0 || quantity.length == 0 || price.length == 0) {
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