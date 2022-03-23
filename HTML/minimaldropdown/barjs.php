<?php
session_start();
include('../config/db.php');

$type = $_POST['type'];
$year = $_POST['year'];
$option = $_POST['option'];

$project_query = "SELECT * FROM project_info JOIN perdepartment_info JOIN project_style_info
JOIN department_info JOIN user_details 
ON project_info.user_id=user_details.user_id 
AND project_info.project_style=project_style_info.project_style_id
AND project_info.department_id=department_info.department_id";

if ($type) $project_query .= " AND project_style = '{$type}'";
if ($year) $project_query .= " AND project_fiscal_year = '{$year}'";

$query = mysqli_query($conn, $project_query);
$result = mysqli_fetch_assoc($query);

function gen_chart_value_op1($department_id, $status)
{
  global $conn;
  global $type;
  global $year;
  $query  = "SELECT * FROM `project_info` WHERE department_id = '{$department_id}' AND status_project = '$status'";
  if ($type) $query .= " AND project_style = '{$type}'";
  if ($year) $query .= " AND project_fiscal_year = '{$year}'";
  $query = mysqli_query($conn, $query);
  return mysqli_num_rows($query);
}

function gen_chart_value_op2($department_id, $status)
{
  global $conn;
  global $type;
  global $year;
  $query  = "SELECT * FROM `project_info` WHERE department_id = '{$department_id}' AND indicator_success2 = '$status'";
  if ($type) $query .= " AND project_style = '{$type}'";
  if ($year) $query .= " AND project_fiscal_year = '{$year}'";
  $query = mysqli_query($conn, $query);
  return mysqli_num_rows($query);
}

if ($option == 1) {

  $data = array();
  $job_done_query = array();
  $job_progress_query = array();
  $job_unprogress_query = array();
  $department_query = "SELECT * FROM `department_info` ";
  $queryDepartment = mysqli_query($conn, $department_query);
  while ($row = mysqli_fetch_array($queryDepartment, MYSQLI_ASSOC)) {
    $data[] = "'{$row['department_name']}'";
    $department_id = $row['department_id'];
    $job_opp1[] = gen_chart_value_op1($department_id, 'ขออนุมัติโครงการ');
    $job_opp2[] = gen_chart_value_op1($department_id, 'รายงานผลการดำเนินงาน');
    $job_opp3[] = gen_chart_value_op1($department_id, 'ขออนุมัติปรับแผนโครงการ');
    $job_opp4[] = gen_chart_value_op1($department_id, 'ขออนุมัติเบิก-จ่าย รายครั้ง');
    $job_opp5[] = gen_chart_value_op1($department_id, 'ขอนุมัติปิดโครงการ');
    $job_opp6[] = gen_chart_value_op1($department_id, 'สรุปการดำเนินงานตามแผน');
    $job_opp7[] = gen_chart_value_op1($department_id, 'แก้ไข/ตรวจสอบสถานะโครงการ');
  }
?>
<script type="text/javascript">
$(function() {
    $('#containerbar').highcharts({

        chart: {
            type: 'column'
        },

        title: {
            text: 'รายงานสถานะโครงการ'
        },

        xAxis: {
            categories: [<?php echo join(',', $data) ?>]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'จำนวนโครงการ'
            }
        },

        tooltip: {
            formatter: function() {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },

        series: [{
            name: 'ขออนุมัติโครงการ',
            data: [<?php echo join(',', $job_opp1) ?>]
        }, {
            name: 'รายงานผลการดำเนินงาน',
            data: [<?php echo join(',', $job_opp2) ?>]
        }, {
            name: 'ขออนุมัติปรับแผนโครงการ',
            data: [<?php echo join(',', $job_opp3) ?>]
        }, {
            name: 'ขออนุมัติเบิก-จ่าย รายครั้ง',
            data: [<?php echo join(',', $job_opp4) ?>]
        }, {
            name: 'ขอนุมัติปิดโครงการ',
            data: [<?php echo join(',', $job_opp5) ?>]
        }, {
            name: 'สรุปการดำเนินงานตามแผน',
            data: [<?php echo join(',', $job_opp6) ?>]
        }, {
            name: 'แก้ไข/ตรวจสอบสถานะโครงการ',
            data: [<?php echo join(',', $job_opp7) ?>]
        }]
    });
});
</script>
<? } else {

  $data = array();
  $job_done_query = array();
  $job_progress_query = array();
  $job_unprogress_query = array();
  $department_query = "SELECT * FROM `department_info` ";
  $queryDepartment = mysqli_query($conn, $department_query);
  while ($row = mysqli_fetch_array($queryDepartment, MYSQLI_ASSOC)) {
    $data[] = "'{$row['department_name']}'";
    $department_id = $row['department_id'];
    $job_opp1[] = gen_chart_value_op2($department_id, 'สำเร็จ');
    $job_opp2[] = gen_chart_value_op2($department_id, 'ไม่สำเร็จ');
  }
?>
<script type="text/javascript">
$(function() {
    $('#containerbar').highcharts({

        chart: {
            type: 'column'
        },

        title: {
            text: 'รายงานสถานะตัวชี้วัดโครงการโครงการ'
        },

        xAxis: {
            categories: [<?php echo join(',', $data) ?>]
        },

        yAxis: {
            allowDecimals: false,
            min: 0,
            title: {
                text: 'จำนวนโครงการ'
            }
        },

        tooltip: {
            formatter: function() {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' +
                    'Total: ' + this.point.stackTotal;
            }
        },

        plotOptions: {
            column: {
                stacking: 'normal'
            }
        },

        series: [{
            name: 'สำเร็จ',
            data: [<?php echo join(',', $job_opp1) ?>],
            stack: 'done'
        }, {
            name: 'ไม่สำเร็จ',
            data: [<?php echo join(',', $job_opp2) ?>],
            stack: 'unprocessed.'
        }]
    });
});
</script>
<?php } ?>