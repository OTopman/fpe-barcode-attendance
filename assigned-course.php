<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-12
 * Time: 15:15
 */

$page_title = "All Assigned Course";
require_once 'config/core.php';
if (!is_lecturer_login()){
    redirect(base_url('index.php'));
    return;
}


require_once 'assets/head.php';
?>


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



            <div class="table-responsive">
                <table class="table table-bordered" id="example1">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Department</th>
                        <th>Level</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Department</th>
                        <th>Level</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                    $staff_id = lecturer_details('id');
                    $sql = $db->query("SELECT a.*, s.fname, s.username, c.title, c.code, c.level, d.name FROM assign_course a INNER JOIN course c ON a.course_id = c.id INNER JOIN departments d ON c.department = d.id INNER JOIN staff s ON a.staff_id = s.id WHERE a.staff_id = '$staff_id' ORDER BY a.id DESC");
                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                        ?>
                        <tr>
                            <td><?= $sn++ ?></td>
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



<?php require_once 'assets/foot.php';?>
