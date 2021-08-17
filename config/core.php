<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 12/21/20
 * Time: 1:18 PM
 */

    session_start();
    require_once 'func.php';
    define('Env', 'onlin');

    //define("DB_PREFIX", "ht_");

    define("LIB_DIR","http://projects.io/app/creche/");
    define("HOME_DIR","http://projects.io/app/barcode-attendance/");
    define("HTML_TEMPLATE",LIB_DIR.'templates/');

    define("USER_SESSION_HOLDER", "admin");
    define("USERS_SESSION_HOLDER", "admin");
    define("WEB_TITLE","Barcode Attendance");
    define("WEB_SUB_TITLE","Barcode");

    require_once 'barcode/vendor/autoload.php';

    if (Env == "online") {
        define('DB_HOST', 'localhost');
        define('DB_TABLE', 'verajnse_barcode_attendance');
        define('DB_USER', 'verajnse_barcode_attendance');
        define('DB_PASSWORD', '5Xb0RcX@LuAL');
    }else{
        define('DB_HOST', 'localhost');
        define('DB_TABLE', 'app_fpe_barcode_attendance');
        define('DB_USER', 'root');
        define('DB_PASSWORD', '');
    }

    try {
        $db = new PDO('mysql:host='.DB_HOST.';dbname='.DB_TABLE, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
    }

    catch (PDOException $e){
        die('<br/><center><font size="15">Could not connect with database</font></center>');
    }