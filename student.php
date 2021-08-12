<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2/26/21
 * Time: 2:26 PM
 */

$page_title = "All Students";
require_once 'config/core.php';
require_once 'libs/head.php';
?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

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
                            <th>Passport</th>
                            <th>Matric Number</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th>Department</th>
                            <th>Level</th>
                            <th>Gender</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>SN</th>
                        <th>Passport</th>
                        <th>Matric Number</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Gender</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        $sql = $db->query("SELECT s.*, d.name as dept FROM students s 
                            LEFT JOIN departments d
                                ON s.dept = d.id
                            ORDER BY s.id DESC
                        ");
                        while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <tr>
                                <td><?= $sn++ ?></td>
                                <td><img src="https://www.federalpolyede.edu.ng/passport/Reg<?=$rs['matric']?>.jpg" style="width: 50px;height: 50px; border-radius: 5px;"  alt=""></td>
                                <td><?= strtoupper($rs['matric']) ?></td>
                                <td><?= ucwords($rs['fname']) ?></td>
                                <td><?= $rs['email'] ?></td>
                                <td><?= $rs['phone'] ?></td>
                                <td><?= ucwords($rs['dept']) ?></td>
                                <td><?= strtoupper($rs['level']) ?></td>
                                <td><?= ucwords($rs['gender']) ?></td>
                                <td><?= $rs['created_at'] ?></td>
                                <td><a href="view.php?id=<?= $rs['id'] ?>" class="btn btn-primary btn-sm">View</a></td>
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
