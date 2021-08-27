<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-17
 * Time: 15:48
 */

require_once 'config/core.php';

if (is_lecturer_login()){
    unset($_SESSION['loggeding']);
    unset($_SESSION[USERS_SESSION_HOLDER]);
    set_flash("You have logged out successfully","info");
    redirect(base_url('lecturer.php'));
}

if (is_login()){
    unset($_SESSION['loggedin']);
    unset($_SESSION[USER_SESSION_HOLDER]);
    set_flash("You have logged out successfully","info");
    redirect(base_url());
}
