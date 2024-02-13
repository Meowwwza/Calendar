<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- theme meta -->
    <meta name="theme-name" content="quixlab" />

    <title>ระบบเพิ่มรายชื่อนิสิต</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Pignose Calender -->
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    require_once '../controller/connection_connect.php';

    //get checkCons
    $checkcons = [];
    $checkconSQL = "SELECT * FROM checkcon";
    $result = $conn->query($checkconSQL);
    while ($my_row = $result->fetch_assoc()) {
        $checkcons[] = $my_row;
    }


    //get checkrests
    $checkrests = [];
    $checkrestSQL = "SELECT * FROM checkrest";
    $result = $conn->query($checkrestSQL);
    while ($my_row = $result->fetch_assoc()) {
        $checkrests[] = $my_row;
    }

    //get dayofweeks
    $dayofweek = [];
    $dayofweekSQL = "SELECT * FROM dayofweek";
    $result = $conn->query($dayofweekSQL);
    while ($my_row = $result->fetch_assoc()) {
        $dayofweeks[] = $my_row;
    }

    //get nameof
    $nameofs = [];
    $nameofSQL = "SELECT * FROM nameof";
    $result = $conn->query($nameofSQL);
    while ($my_row = $result->fetch_assoc()) {
        $nameofs[] = $my_row;
    }


    //get noweek
    $noweeks = [];
    $noweekSQL = "SELECT * FROM noweek";
    $result = $conn->query($noweekSQL);
    while ($my_row = $result->fetch_assoc()) {
        $noweeks[] = $my_row;
    }

    //get typerests
    $typerests = [];
    $typerestSQL = "SELECT * FROM typerest";
    $result = $conn->query($typerestSQL);
    while ($my_row = $result->fetch_assoc()) {
        $typerests[] = $my_row;
    }


    require_once '../controller/connection_close.php';
    ?>

    
    <?php include('./layout.php'); ?>

    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">

        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-10" style="display: block; justify-content: center; align-items: center;">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">เพิ่มปฏิทิน</h5>
                            <div class="form-validation">
                                <form class="form-valide" action="../controller/createCalendar.php" method="post"
                                    enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-email">รหัสนิสิต<span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="studentId" name="studentId" required />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-username">คำนำหน้าชื่อ <span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="type" name="title" required>
                                                <option value="นาย">นาย</option>
                                                <option value="นาง">นาง</option>
                                                <option value="นางสาว">นางสาว</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-email">ชื่อ - นามสกุล<span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <input type="text" class="form-control" id="name" name="name" required />
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="name">เพศ<span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="genderId" name="genderId" required>
                                            <?php
                                                
                                                foreach($genders as $gender){

                                                
                                                
                                                ?>
                                                <option value="<?php echo $gender["genderId"]?>"><?php echo $gender["genderTh"]?></option>
                                                <?php
                                                
                                                
                                                    
                                                }
                                                
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-suggestions">ภาควิชา <span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="departmentId" name="departmentId"
                                                required>
                                                <?php
                                                
                                                foreach($departments as $department){

                                                
                                                
                                                ?>
                                                <option value="<?php echo $department["departmentId"]?>"><?php echo $department["departmentTh"]?></option>
                                                <?php
                                                
                                                
                                                    
                                                }
                                                
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label" for="val-suggestions">รุ่น <span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control" id="generetionId" name="generetionId"
                                                required>
                                                <?php
                                                
                                                foreach($generetions as $generetion){

                                                
                                                
                                                ?>
                                                <option value="<?php echo $generetion["generetionId"]?>"><?php echo $generetion["generetion"]?></option>
                                                <?php
                                                
                                                
                                                    
                                                }
                                                
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    



                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <!-- <button type="submit" class="btn btn-primary" name="send" value="save">บันทึก</button> -->
                                            
                                            <button type="submit" class="btn btn-success" name="send"
                                                value="send">บันทึก</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- #/ container -->
    </div>
    <!--**********************************
            Content body end
        ***********************************-->


    <!--**********************************
            Footer start
        ***********************************-->

    <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="./plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="./plugins/d3v3/index.js"></script>
    <script src="./plugins/topojson/topojson.min.js"></script>
    <script src="./plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="./plugins/raphael/raphael.min.js"></script>
    <script src="./plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="./plugins/chartist/js/chartist.min.js"></script>
    <script src="./plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>



    <script src="./js/dashboard/dashboard-1.js"></script>

</body>

</html>