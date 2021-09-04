<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-31
 * Time: 12:57
 */
require_once 'config/core.php';
require_once 'config/phpqrcode/qrlib.php';
$matric = $_GET['matric'];
QRcode::png($matric);