<!-- <Button onclick="myFunction()" class="menuButton2">รายงานสถานะการดำเนินโครงการ</Button> -->
<select id="chart-plant-type" class="inputFill-Information" style="background: #E5E5E5;margin-left: -50%;">
    <option value="1" selected>รายงานสถานะการดำเนินโครงการ</option>
    <option value="2">รายงานตัวชี้วัดการดำเนินโครงการ</option>
</select>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<div class="root-script"></div>
<div id="container"></div>
<div id="containerbar" style="max-width: 1200px; margin: auto;margin-top: 35px"></div>
<script>
    function loadChart() {
        $.ajax({
            type: "POST",
            url: "barjs.php",
            data: {
                type: $('#report-plant-type').val(),
                year: $('#change-report-year').val(),
                option: $('#chart-plant-type').val()
            },
            dataType: "html",
            success: function(response) {
                $('.root-script').html(response);
            }
        });
    }
    loadChart();

    $(document).on('change', '#chart-plant-type', function(e) {
        loadChart();
    })
</script>