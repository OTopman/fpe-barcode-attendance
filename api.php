<?php
/**
 * Created by PhpStorm.
 * User: Tech4all
 * Date: 2021-08-12
 * Time: 14:26
 */

require_once 'config/core.php';
header("Content-Type:application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, OPTIONS, PATCH, DELETE');

$action_data = @$_POST;
$data = array();


switch ($action_data['action']){
    case 'login' :

        $matric = strtolower($action_data['matric']);
        $password = strtolower($action_data['password']);

        $sql = $db->query("SELECT s.*, d.name as dept FROM ".DB_PREFIX."students s 
        LEFT JOIN ".DB_PREFIX."departments d
            ON s.dept = d.id
        WHERE s.matric='$matric' and s.password='$password'");

        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        if ($sql->rowCount() == 0){
            $data['error'] = 0;
            $data['msg'] = "Invalid login details, try again";
        }else{
            $data['error'] =1;
            $student_info = array(
                'id'=>$rs['id'],
                'matric'=>strtoupper($rs['matric']),
                'fname'=>ucwords($rs['fname']),
                'level'=>ucwords($rs['level']),
                'email'=>$rs['email'],
                'phone'=>$rs['phone'],
                'dept'=>ucwords($rs['dept']),
                'gender'=>ucwords($rs['gender'])
            );

        }

        $data = array(
            'status'=>$data,
            'student_info'=>$student_info,
        );

        get_json($data);

        break;
    default;
}