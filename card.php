<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-12
 * Time: 15:11
 */
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
?>

<html>
<head>
    <title>Id Card</title>
    <style>

    </style>
</head>
<body>


<table width="450" align="center" style="border-collapse: collapse; background-image:url('templates/images/logo2fade.png'); box-shadow:0 0 0 2px #f5f5f5; border-radius:5px;" border="1">
    <tr>
        <td>
            <center>
                <h3 style="margin-top:10px; text-transform:uppercase">Fpe Evoting Identity Card</h3>
            </center>
            <table align="left">
                <tr>
                    <td>
                        <img src="" alt="" style="width:120px; margin-top:-10px;">
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td>Matric Number : <?php echo strtoupper($data['matric'])?></td>
                </tr>
                <tr>
                    <td>Full Name : <?php echo $data['fname']?></td>
                </tr>
<!--                <tr>-->
<!--                    <td>Department : --><?php //echo ucwords(dept($rs['dept']))?><!--</td>-->
<!--                </tr>-->
<!--                <tr>-->
<!--                    <td>Level : --><?php //echo strtoupper(level($rs['level']))?><!--</td>-->
<!--                </tr>-->
            </table>
        </td>
    </tr>
</table>

</body>
</html>