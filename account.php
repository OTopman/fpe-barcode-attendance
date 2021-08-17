<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-17
 * Time: 12:55
 */

$page_title = "Dashboard";
require_once 'config/core.php';
if (!is_lecturer_login()){
    redirect(base_url('lecturer.php'));
    return;
}
require_once 'assets/head.php';
?>

<div class="col-sm-12">
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

            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Total Assigned Course
                        </div>
                        <div class="panel-body">
                            <h2 class="text-center">
                                <?php
                                    $staff_id = lecturer_details('id');
                                    $sql = $db->query("SELECT * FROM assign_course WHERE staff_id='$staff_id'");
                                    echo $sql->rowCount();
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            Total Attendance Schedules
                        </div>
                        <div class="panel-body">
                            <h2 class="text-center">
                                <?php
                                $staff_id = lecturer_details('id');
                                $sql = $db->query("SELECT * FROM attendance WHERE staff_id='$staff_id'");
                                echo $sql->rowCount();
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once 'assets/foot.php'?>
