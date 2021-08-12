<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 3/1/21
 * Time: 12:29 PM
 */

$page_title = "Add New Students";
require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}

if (isset($_POST['add'])){
    $matric = strtolower($_POST['matric']);
    $password = $matric;
    $phone = $_POST['phone'];
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $dept = $_POST['dept'];
    $level = $_POST['level'];
    $gender = $_POST['gender'];

    $sql = $db->query("SELECT * FROM students WHERE matric='$matric'");
    if ($sql->rowCount() >= 1){
        $error[] = "Matric number has already exit";
    }

    if (strlen($fname) > 100 or strlen($fname) < 3){
        $error[] = "Full name should be between 3 - 100 characters";
    }

    if (!is_numeric($phone) or strlen($phone) != 11){
        $error[] = "Phone number should not exceed 11 digit and cannot contain any other characters";
    }

    if (strlen($email) < 8 or strlen($email) > 100){
        $error[] = "Email address should be between 3 - 100 characters";
    }

    $error_count = count($error);

    if ($error_count == 0 ){

        $db->query("INSERT INTO students (matric,password,fname,phone,email,dept,level,gender)
        VALUES('$matric','$password','$fname','$phone','$email','$dept','$level','$gender')");

        set_flash("Student has been added successfully","warning");

    }else{
        $msg = ($error_count == 1) ? 'An error occurred' : 'Some error(s) occurred';
        foreach ($error as $value){
            $msg.='<p>'.$value.'</p>';
        }
        set_flash($msg,'danger');
    }
}
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

            <?php flash(); ?>

            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Matric Number</label>
                            <input type="text" class="form-control" value="<?= @$_POST['matric']; ?>" required name="matric" placeholder="Matric Number" id="">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Full Name</label>
                            <input type="text" name="fname" value="<?= @$_POST['fname']; ?>" class="form-control" required placeholder="Full Name" id="">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Phone Number</label>
                            <input type="text" class="form-control" value="<?= @$_POST['phone']; ?>" name="phone"  required placeholder="Phone Number" id="">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Department</label>
                            <select name="dept" class="form-control" required id="">
                                <option value="" selected disabled>Select</option>
                                <?php
                                    $sql = $db->query("SELECT * FROM departments ORDER BY name");
                                    while ($rs = $sql->fetch(PDO::FETCH_ASSOC)){
                                        ?>
                                        <option value="<?= $rs['id'] ?>"><?= ucwords($rs['name']) ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Level</label>
                            <select name="level" class="form-control" required id="">
                                <option value="" selected>Select</option>
                                <?php
                                    foreach (array('nd 1 ft','nd 2 ft','nd 1 dpt','nd 2 dpt','nd rpt yr1','nd rpt yr2','nd rpt yr3','hnd 1 ft','hnd 2 ft','hnd 1 dpt','hnd 2 dpt') as $value){
                                        ?>
                                        <option value="<?= $value ?>"><?= strtoupper($value) ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Email Address</label>
                            <input type="email" class="form-control" value="<?= @$_POST['email']; ?>" required placeholder="Email Address" name="email" id="">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Gender</label>
                            <select name="gender" class="form-control" required id="">
                                <option value="" selected>Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit" name="add" id="">
                </div>
            </form>

        </div>
    </div>
</div>

<?php require_once 'libs/foot.php';?>
