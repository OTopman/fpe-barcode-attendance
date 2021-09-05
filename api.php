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
$data = $student_info = $attendance = array();


switch ($action_data['action']){
    case 'login' :

        $matric = strtolower($action_data['matric']);
        $password = strtolower($action_data['password']);

        $sql = $db->query("SELECT s.*, d.name as dept FROM students s 
        LEFT JOIN departments d
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

    case 'get_attendance' :

        $student_id = $action_data['student_id'];

        $sql = $db->query("SELECT * FROM students WHERE id='$student_id'");
        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        $department_id = $rs['dept'];
        $level = $rs['level'];

        $end_time = date('m/d/Y H:s A');

        $sql2 = $db->query("SELECT a.*, s.fname, s.username, c.title, c.code, c.level, d.name FROM attendance a INNER JOIN course c ON a.course_id = c.id INNER JOIN departments d ON c.department = d.id INNER JOIN staff s ON a.staff_id = s.id WHERE c.department ='$department_id' and c.level='$level' and a.end_time <='$end_time'");


        if ($sql2->rowCount() == 0){
            $data['error'] = 0;
            $data['msg'] = "No schedule for attendance yet";
        }else{
            while ($rs = $sql2->fetch(PDO::FETCH_ASSOC)){
                $attendance[] = $rs;
            }
        }

        $data = array(
            'status'=>$data,
            'attendance'=>$attendance
        );

        get_json($data);

        break;

    case 'change_password' :

        $student_id = $action_data['student_id'];
        $password = $action_data['password'];
        $npassword = $action_data['npassword'];

        $sql = $db->query("SELECT * FROM students WHERE id='$student_id'");

        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        if ($password != $rs['password'] or $sql->rowCount() == 0){
            $data['error'] = 0;
            $data['msg'] = "Invalid old password entered, please try again";
        }else{
            $db->query("UPDATE students SET password='$npassword' WHERE id='$student_id'");
            $data['error'] = 1;
            $data['msg'] = "Your password has been changed successfully";
        }

        get_json($data);

        break;

    case 'scan_barcode_attendance' :

        $matric = $action_data['matric'];
        $attendance_id = $action_data['attendance_id'];

        $end_time = date('m/d/Y H:s A');

        $sql = $db->query("SELECT * FROM students WHERE matric='$matric'");
        $rs = $sql->fetch(PDO::FETCH_ASSOC);

        $student_id = $rs['id'];
        $department_id = $rs['dept'];
        $level = $rs['level'];

        $sql2 = $db->query("SELECT * FROM attendance WHERE id='$attendance_id' and end_time <='$end_time'");

        $sql3 = $db->query("SELECT * FROM student_attendance WHERE student_id='$student_id' and attendance_id='$attendance_id'");

        if ($sql->rowCount() == 0){
            $data['error'] = 0;
            $data['msg'] = "Invalid barcode";
        }elseif ($sql2->rowCount() == 0){
            $data['error'] = 0;
            $data['msg'] = "Attendance time has been closed";
        }elseif ($sql3->rowCount() >= 1){
            $data['error'] = 0;
            $data['msg'] = "You have already mark an attendance";
        }else{

            $db->query("INSERT INTO student_attendance (student_id,attendance_id)VALUES ('$student_id','$attendance_id')");

            $data['error'] =1;
            $data['msg'] = "Your attendance has been submitted successfully";
        }

        get_json($data);

        break;
    default;
}