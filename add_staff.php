<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-12
 * Time: 15:15
 */

$page_title = "Add Staff";
require_once 'config/core.php';
if (!is_login()){
    redirect(base_url('index.php'));
    return;
}
if (isset($_POST['add'])){
    $username = $_POST['username'];
    $fname = $_POST['fname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    $sql = $db->query("SELECT * FROM staff WHERE username='$username'");
    if ($sql->rowCount() >= 1){
        $error[] = "Staff Id has already exist";
    }

    if (strlen($fname) <3 or strlen($fname) > 100){
        $error[] = "Full Name should be between 3 - 100 characters";
    }

    if (!is_numeric($phone)){
        $error[] = "Invalid phone number";
    }

    $error_count = count($error);
    if ($error_count == 0){

        $in = $db->query("INSERT INTO staff (username,email,fname,phone,gender,password)VALUES ('$username','$email','$fname','$phone','$gender','$password')");

        set_flash("New staff has been added successfully","info");

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

            <?php flash(); ?>

            <form action="" method="post">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Staff Id</label>
                            <input type="text" class="form-control" required placeholder="Staff Id" name="username" id="">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Full Name</label>
                            <input type="text" class="form-control" required placeholder="Full Name" name="fname" id="">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Email Address</label>
                            <input type="email" class="form-control" name="email" required placeholder="Email Address" id="">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="">Phone Number</label>
                            <input type="text" class="form-control" required placeholder="Phone Number" name="phone" id="">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Gender</label>
                            <select name="gender" class="form-control" required id="">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" required placeholder="Password" name="password" id="">
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
