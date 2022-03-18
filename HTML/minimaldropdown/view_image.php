<?php
/**
 *  Created by PhpStorm.
 *  User: Rock Melody
 *  on 3/18/2022.
 *  on 12:02 PM.
 */


//
include('../config/db.php');
include('service_query.php');
$file_id = $_GET['file_id'];
header("Content-type: image/jpg");
$image = queryImage($file_id);
echo $image[0]['file'];