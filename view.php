<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 2:28 PM
 */

require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}

$student_id = $_GET['id'];
if (!isset($student_id) or empty($student_id)){
    redirect(base_url('404.php'));
    return;
}

$sql = $db->query("SELECT s.*, d.name as dept FROM students s 
        LEFT JOIN departments d
            ON s.dept = d.id
        WHERE s.id='$student_id'");

if ($sql->rowCount() == 0){
    redirect(base_url('404.php'));
    return;
}

$data = $sql->fetch(PDO::FETCH_ASSOC);

$page_title = strtoupper($data['matric'])." - Dashboard";

require_once 'libs/head.php';
?>

<div class="col-lg-12 col-sm-12 col-xs-12 col-md-12">

    <?php flash(); ?>

    <div class="box box-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header bg-blue-gradient">
            <h3 class="widget-user-username"><?= ucwords($data['fname']) ?></h3>
            <h5 class="widget-user-desc">Level : <?= ucwords($data['level']) ?></h5>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="https://www.federalpolyede.edu.ng/passport/Reg<?=$data['matric']?>.jpg" style="width: 80px; height: 80px;" alt="User Avatar">
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= ucwords($data['gender']) ?></h5>
                        <span class="description-text" style="text-transform: capitalize">Gender</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= ucwords($data['dept']) ?></h5>
                        <span class="description-text" style="text-transform: capitalize">Department</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                    <div class="description-block">
                        <h5 class="description-header"><?= $data['email'] ?></h5>
                        <span class="description-text" style="text-transform: capitalize">Email Address</span>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.widget-user -->
</div>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Student Details</a></li>
            <li><a href="#tab_2" data-toggle="tab">Attendance</a></li>
            <li><a href="#tab_3" data-toggle="tab">Student ID - Card</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td>Matric No</td>
                            <td><?= strtoupper($data['matric']) ?></td>
                        </tr>
                        <tr>
                            <td>Student Name</td>
                            <td><?= ucwords($data['fname']) ?></td>
                        </tr>
                        <tr>
                            <td>Level</td>
                            <td><?= strtoupper($data['level']) ?></td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td><?= ucwords($data['dept']) ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td><?= $data['phone'] ?></td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td><?= $data['email'] ?></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td><?= ucwords($data['gender']) ?></td>
                        </tr>
                    </table>


                </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">

                <div class="table-responsive">
                    <table class="table-bordered table" id="example1">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Attendance Date</th>
                            <th>Course Title</th>
                            <th>Course Code</th>
                            <th>Department</th>
                            <th>Lecturer In-Charge</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>SN</th>
                            <th>Attendance Date</th>
                            <th>Course Title</th>
                            <th>Course Code</th>
                            <th>Department</th>
                            <th>Lecturer In-Charge</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        <?php
                            $sn =1;
                            $sql = $db->query("SELECT s_a.*, c.title, c.code, d.name, s.fname  FROM student_attendance s_a INNER JOIN attendance a ON s_a.attendance_id = a.id INNER JOIN course c ON a.course_id = c.id INNER JOIN staff s ON a.staff_id = s.id INNER JOIN departments d ON c.department = d.id WHERE s_a.student_id='$student_id'");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <tr>
                                    <td><?= $sn++ ?></td>
                                    <td><?= $rs['created_at']?></td>
                                    <td><?= $rs['title'] ?></td>
                                    <td><?= $rs['code'] ?></td>
                                    <td><?= $rs['name'] ?></td>
                                    <td><?= ucwords($rs['fname']) ?></td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="tab-pane" id="tab_3">

                <?php require_once 'card.php'?>
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- nav-tabs-custom -->
</div>

<?php require_once 'libs/foot.php';?>
