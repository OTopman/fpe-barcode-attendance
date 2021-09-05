<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-09-05
 * Time: 17:20
 */
$page_title = "Student Attendance";
require_once 'config/core.php';
if (!is_lecturer_login()){
    redirect(base_url('lecturer.php'));
    return;
}

$attendance_id = $_GET['id'];
if (!isset($attendance_id) && empty($attendance_id)){
    redirect(base_url('account.php'));
    return;
}

$sql = $db->query("SELECT * FROM attendance WHERE id='$attendance_id'");
if ($sql->rowCount() == 0){
    redirect(base_url('account.php'));
    return;
}
require_once 'assets/head.php';
?>

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

            <div class="table-responsive">
                <table class="table-bordered table" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Matric Number</th>
                        <th>Level</th>
                        <th>Department</th>
                        <th>Course Title</th>
                        <th>Course Code</th>
                        <th>Attendance Date</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Full Name</th>
                        <th>Matric Number</th>
                        <th>Level</th>
                        <th>Department</th>
                        <th>Course Title</th>
                        <th>Course Code</th>
                        <th>Attendance Date</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $sn =1;
                    $sql = $db->query("SELECT s_a.*, c.title, c.code, d.name, ss.fname, ss.matric, ss.level  FROM student_attendance s_a INNER JOIN attendance a ON s_a.attendance_id = a.id INNER JOIN course c ON a.course_id = c.id INNER JOIN staff s ON a.staff_id = s.id INNER JOIN departments d ON c.department = d.id INNER JOIN students ss ON s_a.student_id = ss.id WHERE s_a.attendance_id='$attendance_id'");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
                            <td><?= ucwords($rs['fname']) ?></td>
                            <td><?= strtoupper($rs['matric']) ?></td>
                            <td><?= strtoupper($rs['level']) ?></td>
                            <td><?= $rs['title'] ?></td>
                            <td><?= $rs['code'] ?></td>
                            <td><?= $rs['name'] ?></td>
                            <td><?= $rs['created_at']?></td>
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
