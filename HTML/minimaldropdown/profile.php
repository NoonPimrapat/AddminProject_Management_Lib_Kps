<?php
        session_start(); 
        include('../config/db.php');
        $user_email = $_SESSION['user_email'];
        $user_id = $_SESSION['user_id'];
        //2. query ข้อมูลจากตาราง tb_member:
        $querydepartment = "SELECT * FROM department_info ORDER BY department_id asc" or die("Error:" . mysqli_error());
        //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
        $resultdepartment = mysqli_query($conn, $querydepartment);
         
            $query = "SELECT * FROM user_details WHERE user_email = '$user_email'" or die("Error:" . mysqli_error());
            $result = mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สำนักงานหอสมุดกำแพงแสน</title>

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@200;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- custom css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">

    <!-- plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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
    <div class="logo-container">
        <div class="color-small-bar"></div>
    </div>


    </div>
    <div class="grid-container">
        <div class="grid-item">
            <table id="profile">
                <?php foreach ($result as $value) { ?>
                <tr>
                    <td class="Profiletopic">ชื่อ :</td>
                    <td>
                        <p class="detail"> <?php echo $value['user_firstname']; ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="Profiletopic">นามสกุล :</th>
                    <td>
                        <p class="detail"> <?php echo $value['user_lastname']; ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="Profiletopic">เพศ :</th>
                    <td>
                        <p class="detail"> <?php echo $value['user_typeSex']; ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="Profiletopic">ตำแหน่ง :</th>
                    <td>
                        <p class="detail"> <?php echo $value['user_position']; ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="Profiletopic">แผนก :</th>
                    <td>
                        <p class="detail"> <?php echo $value['user_department']; ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="Profiletopic">โทรศัพท์ :</th>
                    <td>
                        <p class="detail"> <?php echo $value['user_phone']; ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="Profiletopic">E-mail :</th>
                    <td>
                        <p class="detail"> <?php echo $value['user_email']; ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="Profiletopic">Password :</th>
                    <td>

                        <input type="password" name="password" value="<?php echo $value['user_password']; ?> "
                            autocomplete="current-password" required="" id="id_password" class="detail"
                            style="border:0px" readonly>

                    </td>
                    <td>
                        <i class="far fa-eye" id="togglePassword" style="margin-left: 30px; cursor: pointer;"></i>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <div class="grid-item-center">
            <img id="output" src=" <?php echo $value['user_pic'];?>" class="show-profile" />


        </div>

    </div>

    <div class="container-button">
        <button type="reset" class="backButton" onclick="parent.location='index.php'">Back
        </button>
    </div>
    <script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#id_password');
    togglePassword.addEventListener('click', function(e) {
        // toggle the type attribute
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        // toggle the eye slash icon
        this.classList.toggle('fa-eye-slash');
    });
    </script>
</body>

</html>