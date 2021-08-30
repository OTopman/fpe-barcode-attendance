<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-12
 * Time: 15:11
 */

    require_once 'config/barcode/vendor/autoload.php';
$redColor = [255, 0, 0];
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG("ss");
?>

<table width="500" align="center" style="border-collapse: collapse; background-image:url('templates/images/logo2fade.png'); box-shadow:0 0 0 2px #f5f5f5; border-radius:5px;" border="1">
    <tr>
        <td>
           <table>
               <tr>
                   <td align="left">
                       <img src="<?= image_url('logo.png') ?>" style="width: 50px; height: 50px; padding: 5px; margin: 10px;" alt="">
                   </td>
                   <td>
                       <h4 style="margin-top:10px; text-transform:uppercase; text-align: center">
                           <b>Federal Polytechnic Ede, OSun State Student</b>
                           <p style="margin-top: 10px;"><b> Identity Card</b></p>
                       </h4>
                   </td>
               </tr>
           </table>
            <table align="left">
                <tr>
                    <td>
                        <img src="https://www.federalpolyede.edu.ng/passport/Reg<?=$data['matric']?>.jpg" alt="" style="width:120px; margin:10px;">
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td style="padding-bottom: 5px;"><b>Matric Number :</b> <?php echo strtoupper($data['matric'])?></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 5px;"><b>Full Name :</b> <?php echo $data['fname']?></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 5px;"><b>Department :</b> <?php echo ucwords($data['dept'])?></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 5px;"><b>Level :</b> <?php echo strtoupper($data['level'])?></td>
                </tr>
                <tr>
                    <td style="padding-bottom: 5px;"><b>Gender :</b> <?php echo ucwords($data['gender'])?></td>
                </tr>
                <tr>
                    <td style="width: 100%"><?= '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($data['matric'], $generator::TYPE_CODE_128)) . '">'; ?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>