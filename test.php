<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-12
 * Time: 15:03
 */

require_once 'config/core.php';

$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';