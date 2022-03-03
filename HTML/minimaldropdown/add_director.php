
<!DOCTYPE html>
<html>

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width-device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title> ADD Director</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>

<body>
    <div class="logo-container">
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
    </div>
    <header>
        <div class="nav">
            <ul>
                <li class="a"><a href="#"> สรุปการดำเนินงาน </a> </li>
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


    <p>&nbsp&nbsp<span class="material-icons">add_circle</span>เพิ่มผู้อำนวยการ</p>
    <form action="adddirector_db.php" method="post">
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
        <div class="grid-container">
            <div class="grid-item">
                <div class="row">
                    <div class="col-25">
                        <label for="fname"> ชื่อผู้อำนวยการ:</label>
                        <label for="Sname"> นามสกุลผู้อำนวยการ:</label>
                    </div>
                    <div class="col-75">
                        <input type="text" name="directorname" required></br></br>
                        <input type="text" name="directorlastname" required>
                    </div>
                </div>
                
            <div class="container-button">
                <button type="reset" value="reset" class="backButton">ล้าง </button>
                <button type="submit" name="Add_director" class="summitButton">เพิ่ม</button>
            </div>
        </div>
    </form>
</body>

</html>