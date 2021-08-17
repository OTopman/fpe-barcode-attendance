<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-12
 * Time: 15:15
 */

$page_title = "All Assigned Course";
require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}

if (isset($_POST['add'])){
    $course_id = $_POST['course_id'];
    $staff_id = $_POST['staff_id'];

    $sql = $db->query("SELECT * FROM assign_course WHERE staff_id='$staff_id' and course_id='$course_id'");

    if ($sql->rowCount() >= 1){
        $error[] = "Course has already assigned";
    }

    $error_count = count($error);
    if ($error_count ==  0){

        $in = $db->query("INSERT INTO assign_course (staff_id,course_id)VALUES ('$staff_id','$course_id')");

        set_flash("Course has been assigned successfully","info");

    }else{
        $msg = ($error_count == 1) ? 'An error occurred' : 'Some error(s) occcurred';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}

require_once 'libs/head.php';
?>

<div id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
                <h4 id="myModalLabel" class="modal-title">Assign Course</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post">

                    <div class="form-group">
                        <label for="">Lecturer</label>
                        <select name="staff_id" id="" class="form-control">
                            <option value="" selected disabled>Select</option>
                            <?php
                                $sql = $db->query("SELECT * FROM staff ORDER BY fname");
                                while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                    ?>
                                    <option value="<?= $rs['id'] ?>"> <?= ucwords($rs['fname']) ?> (<?= strtoupper($rs['username']) ?>)</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Course</label>
                        <select name="course_id" class="form-control" required id="">
                            <option value="" selected disabled>Select</option>
                            <?php
                            $sql = $db->query("SELECT c.*, d.name FROM course c INNER JOIN departments d ON c.department = d.id ORDER BY title");
                            while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                <option value="<?= $rs['id'] ?>"><?= ucwords($rs['title']) ?> ( <?= ucwords($rs['name']) ?> - <?= strtoupper($rs['level']) ?>)</option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>


                    <div class="form-group">
                        <input type="submit" name="add" class="btn btn-primary" value="Submit" id="">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">

    <!-- Default box -->
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

            <button data-toggle="modal" style="margin-bottom: 20px;" data-target="#myModal" class="btn btn-primary ">Assign Course</button>

            <?php flash() ?>

            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Lecturer In-charge</th>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Department</th>
                        <th>Level</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Lecturer In-charge</th>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Department</th>
                        <th>Level</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $sql = $db->query("SELECT a.*, s.fname, s.username, c.title, c.code, c.level, d.name FROM assign_course a INNER JOIN course c ON a.course_id = c.id INNER JOIN departments d ON c.department = d.id INNER JOIN staff s ON a.staff_id = s.id ORDER BY a.id DESC");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= ucwords($rs['fname']) ?> (<?= strtoupper($rs['username']) ?>)</td>
                            <td><?= ucwords($rs['title']) ?></td>
                            <td><?= strtoupper($rs['code']) ?></td>
                            <td><?= ucwords($rs['name']) ?></td>
                            <td><?= strtoupper($rs['level']) ?></td>
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



<?php require_once 'libs/foot.php';?>
