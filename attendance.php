<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-17
 * Time: 13:05
 */

$page_title = "All Attendance Schedules";
require_once 'config/core.php';
if (!is_lecturer_login()){
    redirect(base_url('lecturer.php'));
    return;
}

$staff_id = lecturer_details('id');


if (isset($_POST['add'])){
    $course_id = $_POST['course_id'];
    $date = explode(" - ",$_POST['start_date']);
    $start_date = $date[0];
    $end_date = $date[1];

    $error_count = count($error);
    if ($error_count == 0){

        $db->query("INSERT INTO attendance (staff_id,course_id,start_time,end_time)VALUES ('$staff_id','$course_id','$start_date','$end_date')");

        set_flash("Attendance Schedule has been created successfully","info");

    }else{
        $msg = ($error_count == 1) ? 'An error occurred' : 'Some error(s) occcurred';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}

require_once 'assets/head.php';
?>

<div id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
                <h4 id="myModalLabel" class="modal-title">Create Attendance Schedule</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">


                    <div class="form-group">
                        <label for="">Course</label>
                        <select name="course_id" class="form-control" required id="">
                            <option value="" selected disabled>Select</option>
                            <?php
                            $sql = $db->query("SELECT a.*, s.fname, s.username, c.title, c.code, c.level, d.name FROM assign_course a INNER JOIN course c ON a.course_id = c.id INNER JOIN departments d ON c.department = d.id INNER JOIN staff s ON a.staff_id = s.id WHERE a.staff_id ='$staff_id'");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <option value="<?= $rs['id'] ?>"><?= ucwords($rs['title']) ?> ( <?= ucwords($rs['name']) ?> - <?= strtoupper($rs['level']) ?>)</option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Attendance Range Date &amp; Time</label>
                        <input type="text" class="form-control" name="start_date" id="reservationtime">
                    </div>


                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary" value="Submit" id="">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $page_title ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">

            <button data-toggle="modal" style="margin-bottom: 20px;" data-target="#myModal" class="btn btn-primary ">Create Attendance Schedule</button>

            <?php flash() ?>

            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Start Of Attendance Date &amp; Time </th>
                        <th>End Of Attendance Date &amp; Time</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Title</th>
                        <th>Code</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Start Of Attendance Date &amp; Time </th>
                        <th>End Of Attendance Date &amp; Time</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sql = $db->query("SELECT a.*, c.title, c.code, c.level, d.name FROM attendance a INNER JOIN course c ON a.course_id = c.id INNER JOIN departments d ON c.department = d.id WHERE a.staff_id='$staff_id'");
                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><?= ucwords($rs['title']) ?></td>
                                <td><?= strtoupper($rs['code']) ?></td>
                                <td><?= ucwords($rs['name']) ?></td>
                                <td><?= strtoupper($rs['level']) ?></td>
                                <td><?= $rs['start_time'] ?></td>
                                <td><?= $rs['end_time'] ?></td>
                                <td><a href="" class="btn btn-primary btn-sm">View</a></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<?php require_once 'assets/foot.php'?>
