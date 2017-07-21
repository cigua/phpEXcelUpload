<?php

/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
include("conn.php");
error_reporting(all);
$type=$_POST['type'];

date_default_timezone_set('Asia/ShangHai');
$time =date('Y-n-d H:i:s');

/** PHPExcel_IOFactory */
require_once 'PHPExcel/IOFactory.php';
//找到文件存放的位置
$filename = "upFile/1.xls";
//转换编码格式
$filename = iconv("UTF-8","gb2312",$filename);
// Check prerequisites
if (!file_exists( $_FILES["inputExcel"]["tmp_name"])) {
    echo "<script language=JavaScript>{alert('请上传您要导入的文件！');location.href='index.php'}</script>";
}else{
   $result= move_uploaded_file(  $_FILES["inputExcel"]["tmp_name"],$filename);
}
if($result) {
    $reader = PHPExcel_IOFactory::createReader('Excel5'); //设置以Excel5格式(Excel97-2003工作簿)
    $PHPExcel = $reader->load($filename); // 载入excel文件
    $sheet = $PHPExcel->getSheet(0); // 读取第一個工作表w
    $highestRow = $sheet->getHighestRow(); // 取得总行数
    $highestColumm = $sheet->getHighestColumn(); // 取得总列数
    /** 循环读取每个单元格的数据 */
    for ($row = 2; $row <= $highestRow; $row++) {//行数是以第1行开始
        for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
            $dataset[] = $sheet->getCell($column . $row)->getValue();
            $b .= $sheet->getCell($column . $row)->getValue() . '\\';
            //explode:函数把字符串分割为数组。


//        if($column=='B'){
//            $sql="insert into db_qwechat_userregist(mobile) VALUES ('{$b}');";
//            $db=new DB();
//            $result=$db->_query($sql);
//        }else if($column=='A'){
//
//            $sql="insert into db_qwechat_userregist(xingming) VALUES ('{$b}') where mo;";
//            $db=new DB();
//            $result=$db->_query($sql);
//
//        }else if($column=='C'){
//            $sql="insert into db_qwechat_userregist(address) VALUES ('{$b}');";
//            $db=new DB();
//            $result=$db->_query($sql);
//        }


        }
        $strs = explode("\\", $b);
        $db = new DB();
        $sql1="select * from db_qwechat_userregist where mobile='$strs[2]'";
        $result1=$db->query($sql1);
        $row1=$result1->fetch();
        if($strs[1]==$type){
            if($row1==0){
                if($type=="合作社"){
                    $sql = "insert into db_qwechat_userregist(xingming,mobile,address,xingbie,cooperation,director,city,quxian,money,time,project,type,subtime) VALUES ('" . $strs[2] . "','" . $strs[3] . "','" . $strs[4] . "','" . $strs[5] . "','" . $strs[6] . "','" . $strs[7] . "','" . $strs[8] . "','" . $strs[9] . "','" . $strs[10] . "','" . $strs[11] . "','" . $strs[12] . "','".$type."','" . $time ."')";
                }else if($type=="政府部门"){
                    $sql = "insert into db_qwechat_userregist(xingming,mobile,address,xingbie,city,quxian,bumen,zhiwu,type,subtime) VALUES ('" . $strs[2] . "','" . $strs[3] . "','" . $strs[4] . "','" . $strs[5] . "','" . $strs[6] . "','" . $strs[7] . "','" . $strs[8] . "','" . $strs[9] . "','".$type."','" . $time . "')";
                }elseif($type=="管理员"){
                    $sql = "insert into db_qwechat_userregist(xingming,mobile,address,xingbie,type,subtime) VALUES ('" . $strs[2] . "','" . $strs[3] . "','" . $strs[4] . "','" . $strs[4] . "','".$type."','" . $time . "')";
                }

                $result = $db->_query($sql);
            }
        }else{
            echo "<script language=JavaScript>{alert('导入的表格类别不符，导入失败！');location.href='../users_list.php'}</script>";
        }

        $b = "";
    }
    unlink($filename); //删除上传的excel文件
    echo "<script language=JavaScript>{alert('导入成功！');location.href='../users_list.php'}</script>";
}else{
    echo "<script language=JavaScript>{alert('导入失败！');location.href='index.php'}</script>";
}