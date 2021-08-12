<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2/26/21
 * Time: 2:20 PM
 */

$page_title = "Dashboard";
require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}

require_once 'libs/head.php';
?>

<div class="col-lg-6 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                <?php
                    $sql = $db->query("SELECT * FROM admin");
                    echo $sql->rowCount();
                ?>
            </h3>
            <p>All Staffs</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="staff.php" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-6 col-xs-12">
    <!-- small box -->
    <div class="small-box bg-blue">
        <div class="inner">
            <h3>
                <?php
                $sql = $db->query("SELECT * FROM students");
                echo $sql->rowCount();
                ?>
            </h3>
            <p>All Students</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="student.php" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>


<div class="col-sm-12">
    <div class="box ">
        <div class="box-header with-border">Recent Students</div>
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
                            ORDER BY s.id DESC LIMIT 5
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
