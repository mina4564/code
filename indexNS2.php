<?php
//ini_set('display_errors','1');
//error_reporting(E_ALL);
require_once("../../assets/language/language.php");
$lang = new Language();
$lang->load("header");
$lang->load("case");
$timestamp_s = strtotime($_GET['start']);
$taiwan_y_s = date('Y', $timestamp_s) - 1911;
$taiwan_m_s = date('m', $timestamp_s);
$taiwan_d_s = date('d', $timestamp_s);
$taiwan_date_s  = $taiwan_y_s . '-' . $taiwan_m_s . '-' . $taiwan_d_s;
$timestamp_e = strtotime($_GET['end']);
$taiwan_y_e = date('Y', $timestamp_e) - 1911;
$taiwan_m_e = date('m', $timestamp_e);
$taiwan_d_e = date('d', $timestamp_e);
$taiwan_date_e  = $taiwan_y_e . '-' . $taiwan_m_e . '-' . $taiwan_d_e;
$health =  htmlspecialchars(strip_tags($_GET['health']));
$month = strtotime(htmlspecialchars($_GET['month']));
$month_y = date('Y', $month) - 1911;
$month_m = date('m', $month);
$season = htmlspecialchars(strip_tags($_GET['season']));//20230328
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('../../assets/head.php');
    $member_id = $_GET['report'];
    $selectsql = "select Doctor_date,Nurse_date,Serino from ins_user where Member = :member_id";
    $info = $link->prepare($selectsql);
    $info->bindValue(':member_id', htmlspecialchars(strip_tags($member_id)), PDO::PARAM_STR);
    $info->execute();
    $row = $info->fetch();
    if ($row["Nurse_date"] != null) {
        $nurse_date = explode(",", $row["Nurse_date"]);
        $nurse_count = count($nurse_date);
        $x = 0;
    } else {
        $nurse_count = 0;
        $x = 0;
    }
    for ($i = 0; $i < 12; $i++) {
        // echo $nurse_date[$i] ;
        if (($nurse_date[$i] != '' or $nurse_date[$i] != null) and $nurse_date[$i] != '-') {
            $x++;
            // echo $x ;
        }
    }
    if ($row["Doctor_date"] != null) {
        $doctor_date = explode(",", $row["Doctor_date"]);
        $doctor_count = count($doctor_date);
        $y = 0;
    } else {
        $doctor_count = 0;
        $y = 0;
    }
    for ($i = 0; $i < 4; $i++) {
        if (($doctor_date[$i] != '' or $doctor_date[$i] != null) and $doctor_date[$i] != '-') {
            $y++;
        }
    }
    if(substr($row["Serino"],0,2)=='NS'){
        $Serino="專案代碼";
        // $Serino="健管專案代碼";
    }else{
        $Serino="保單號碼";
        // $Serino="e 守護保單號碼";
    }
    ?>
    <?php require_once('../../assets/js.php'); ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous">
    <script src="../../assets/highcharts/highcharts.js"></script>
    <script src="../../assets/highcharts/highcharts-more.js"></script>
    <script src="../../assets/highcharts/modules/solid-gauge.js"></script>
    <script src="../../assets/highcharts/modules/exporting.js"></script>
    <script src="../../assets/highcharts/modules/export-data.js"></script>
    <script src="../../assets/highcharts/modules/bullet.js"></script>
    <script src="../../assets/highcharts/modules/accessibility.js"></script>
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css"> -->
</head>

<style>
    li {
        /* list-style: none; */
        content: ".";
        color: #00AA88;
    }

    /* li:before { */
    /* content: "·"; */
    /* font-size: 120px; */
    /* vertical-align: middle; */
    /* line-height: 20px; */
    /* } */

    .libefore {
        list-style: none;
        color: #00AA88;
    }

    .libefore:before {
        content: "·";
        font-size: 100px;
        vertical-align: -0.22em;
        line-height: 50px;
    }

    .lichar {
        list-style: none;
    }

    .lichar:before {
        content: "·";
        font-size: 70px;
        vertical-align: -0.22em;
        line-height: 0px;
    }

    .tabletd>tbody>tr>td {
        width: 20%;
        font-weight: bold;
    }

    .tabletd>tbody>tr>td:first-child {
        padding-left: 2%;
        width: 28%;
        text-align: left
    }

    .doctorimggirl {
        position: absolute;
        top: -75px;
        left: -20px;
        width: 110px;
        height: 130px;
    }

    .doctorimgboy {
        position: absolute;
        top: -75px;
        left: -20px;
        width: 100px;
        height: 140px;
    }

    .icondash {
        /* width: 1px; */
        /* height: 1px; */
        vertical-align: 0.24em;
    }

    /* .libefore::marker { */
    /* content: "·"; */
    /* font-size: 80px; */
    /* vertical-align: middle; */
    /* line-height: 20px; */
    /* } */

    body {
        /* margin: 0; */
        font-family: "Rubik", sans-serif;
        font-size: 0.875rem;

        background-image: url("../../assets/img/backgroundimage7.png");
        /* background: #ffffff; */

        overflow-x: hidden;
        /* height: 100%;
        width: 100%; */
        background-attachment: fixed;
        /*background-repeat: no-repeat;*/
        background-position: center;
        background-size: cover;
    }

    /* .table.table-bordered>thead>tr>th {
        border: 1px solid #00AA88;
    } */

    .table-color>tbody>tr>th {
        border: 1px solid #00AA88;
    }

    /* .libefore { */
    /* content: "·"; */
    /* font-size: 120px; */
    /* vertical-align: middle;
        line-height: 20px; */
    /* } */

    /* .page {
        page-break-inside: avoid;
        page-break-after: always;
    } */

    /* @page { */
    /* size: portrait; */

    /* size: landscape; */

    /* size: A4; */

    /* size: A4 portrait; */


    /* margin: 0; */

    /* } */

    /* .content {
        width: 1154px;
    } */
    /* .page {
        width: 210mm;
        min-height: 297mm;
    } */
    .page {
        min-height: 413.5mm;
        height: 413.5mm;
    }

    #board button {
        width: 130px;
        margin: 10px 20px;
    }

    /* @page {
        size: A4;
        margin: -1.1rem;
    } */

    @media print {
        @page {
            size: A4;
            margin: -1.1rem;
        }


        /* body { */
        /* margin: 0 auto; */
        /* line-height: 1em; */
        /* word-spacing: 1px; */
        /* letter-spacing: 0.2px; */
        /* background: blue; */
        /* color: black; */
        /* width: 100%; */
        /* float: none; */
        /* } */

        /* html,
        body {
            width: 260mm;
            height: 297mm;
        } */

        /* width: 210mm; */
        /* height: 297mm; */
        /* content: url(../../assets/img/backgroundimage6.jpeg); */
        /* background-size: cover; */
        /* background-repeat: no-repeat; */
        /* background-position: center center */
        /* background-attachment: fixed; */
        /* z-index: 1; */
        /* } */

        /* .content { */
        /* -webkit-print-color-adjust: exact !important; */
        /* background-image: url(../../assets/img/backgroundimage6.jpg); */
        /* background-size: cover; */
        /* overflow-x: hidden; */
        /* background-attachment: fixed; */
        /* background-position: center; */
        /* } */

        /* body { */
        /* background-image: url(../../assets/img/backgroundimage1.jpeg); */
        /* background-image: unset; */
        /* background-attachment: fixed; */
        /* background-position: center; */
        /* background-size: cover; */
        /* } */



        .board {
            display: none;
        }

        /* .img1 {
            height: 50%;
        } */

        /* #img2 {
            height: 50%;
        } */

        /* .pagebackground {
            width: 21cm;
            height: 29.7cm;
            background-image: url(../../assets/img/backgroundimage6.jpg);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        } */

        .page {
            min-height: 413.5mm;
            /* max-height: 393mm; */
            /* width: 21cm;
            height: 29.7cm; */
            /* background: white; */
            /* max-height: 297mm; */
            background-image: url(../../assets/img/backgroundimage7.png);
            background-size: cover;
            background-position: center;
            background-repeat: repeat;
            page-break-inside: avoid;
            page-break-after: always;
        } /* 确保左侧绿色边框在打印时显示 */
    div[style*="float: left;background-color: #00AB95"] {
        background-color: #00AB95 !important; /* 强制在打印时使用背景颜色 */
    }

    div[style*="float: left;background-color: #009F91"] {
        background-color: #009F91 !important; /* 强制在打印时使用背景颜色 */
    }

    div[style*="float: left;background-color: #007F7A"] {
        background-color: #007F7A !important; /* 强制在打印时使用背景颜色 */
    }

    /* 确保左侧绿色栏的高度与页面匹配 */
    .left-column {
        background-color: #00AB95 !important;
        height: 100%; /* 匹配页面高度 */
    }

        /* .page:last-of-type {
            page-break-after: auto;
        } */
    }
</style>

<body>
<div class="main-wrapper">
    <div class="board" id="board">
        <button id="print" type="button" class="btn btn-light" style="opacity: 0.2">
            Print PDF
        </button>
    </div>
    <div class="content" style="margin: 2%">
        <div class="page">
            <div style="width: 35px;height: 100%;float: left">
                <div style="float: left;background-color: #00AB95;width: 35px;height: 7em"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 25em"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 79em"></div>
                <!-- <div style="float: left;background-color: #00AB95;width: 35px;height: 8em"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 25em"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 79em"></div>
                <div style="float: left;background-color: #00AB95;width: 35px;height: 9em"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 25em"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 79em"></div>
                <div style="float: left;background-color: #00AB95;width: 35px;height: 9em"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 25em"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 79em"></div>
                <div style="float: left;background-color: #00AB95;width: 35px;height: 9em"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 25em"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 79em"></div> -->
                <!-- <div style="float: left;background-color: #00AB95;width: 35px;height: 100px"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 300px"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 1160px"></div>
                <div style="float: left;background-color: #00AB95;width: 35px;height: 100px"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 300px"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 1159px"></div>
                <div style="float: left;background-color: #00AB95;width: 35px;height: 100px"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 300px"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 1158px"></div>
                <div style="float: left;background-color: #00AB95;width: 35px;height: 100px"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 300px"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 1158px"></div> -->
            </div>
            <br>
            <div class="row">
                <div class="col-sm-6 col-md-5 col-lg-5 col-xl-5">
                    <img src="../../assets/img/logo8.png" style="width: 50%">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10" style="text-align: center;">
                    <h1 class="display-3" style="font-family: CSong3-Medium;font-weight:bold; font-stretch:50%;">健康管理服務報告 </h1>
                    <!-- <h1 class="display-4" style="font-family: auto;color: #71717D;font-weight: 300;">Health Management Service Report</h1> -->
                    <h1 class="display-4" style="font-family: auto;color: #71717D;font-weight: 300;white-space:nowrap;">Health Management Service Report</h1>
                    <hr>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            </div>
            <div class="row  justify-content-end">
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4" style="margin-right:7rem">
                    <h4 class="" style="text-align:right;font-size:20px;"><?php if($season != null){echo "季度 ";} ?><span style="font-size: 23px;"><?php                                                                                                                                
                                                                                                                                                        if($season==1){
                                                                                                                                                            echo "➊➁➂➃";
                                                                                                                                                        }
                                                                                                                                                        if($season==2){
                                                                                                                                                            echo "➊➋➂➃";
                                                                                                                                                        }
                                                                                                                                                        if($season==3){
                                                                                                                                                            echo "➊➋➌➃";
                                                                                                                                                        }
                                                                                                                                                        if($season==4){
                                                                                                                                                            echo "➊➋➌➍";
                                                                                                                                                        }?></h4>
                    <h4 class="" style="text-align:right;font-size:20px;"><?php 
                                                                            if($month != null){
                                                                            echo "{$month_y}年{$month_m}月"; }?></h4>
                    <h4 class="mt-n2" style="text-align:right;font-size:16px;">報告區間 : <?php echo "{$taiwan_y_s}年{$taiwan_m_s}月{$taiwan_d_s}日至{$taiwan_y_e}年{$taiwan_m_e}月{$taiwan_d_e}日"; ?></h4>
                </div>

            </div><br><br><br>
            <div class="row">
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10" style="text-align: center;">
                    <!-- <h4 style="text-align: left;">
                        親愛的 <b><span id="Name" style="font-size: 28px"></span></b> <span id="Gender"></span> 您好:<br><br>
                        感謝您透過芯盛健康管理中心的健康管理方案，與我們一起為您的健康努力。您本月份的最新健康管理成果如下，提醒您如果針對健康數值有任何疑慮，歡迎透過遠距照護雲上的「線上互動 」功能與我們聯繫，我們將竭誠為您服務！</h4> -->
                        <h4 style="text-align: left;">
                        親愛的 <u><span id="Name" style="font-size: 30px"></span></u> <span id="Gender"></span> 您好:<br><br>
                        感謝您透過芯盛健康管理中心的健康管理方案，與我們一起為您的健康努力。您本月份的最新健康管理成果如下，提醒您如果針對健康數值有任何疑慮，歡迎透過遠距照護雲上的「線上互動 」功能與我們聯繫，我們將竭誠為您服務！</h4>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            </div><br>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="font-size: 23px">
                    <ul style="padding-left: 17%">
                        <li class="libefore">
                            <font color="black">健管服務起始日 / <span id="StartDate"></span></font>
                        </li>
                        <li class="libefore">
                            <font color="black">健管專案名稱 / <span id="plan_name"></span></font>
                        </li>
                        <li class="libefore">
                            <font color="black">健管<?php echo "$Serino"; ?> / <span id="Serino"></span></font>
<!--                            <font color="black">--><?php //echo "$Serino"; ?><!-- / <span id="Serino"></span></font>-->
                        </li>
                        <li class="libefore">
                            <font color="black">健康管理師 / <span id="Nus"></span><span> 健管師</span></font>
                        </li>
                    </ul>
                </div>
                <div style="height: 89.6px;width: 100%"></div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10" style="text-align: center;">
                    <hr style="border-top: 1px solid #06827D;">
                    <h1 class="mb-0" style="color:#06827D;font-weight:bold;">一、健康管理服務紀錄 </h1>
                    <hr style="border-top: 1px solid #06827D;">
                    <span style="font-size: 20px ;color:#007F7A">本健康管理服務享有每月乙次健康管理師關懷、醫師每季視訊諮詢30分鐘服務。</span><br><br>
                    <div style="text-align: left">
                        <span style="font-size: 22px;">至報告截止日，健康管理師關懷紀錄已完成 <?php echo $x; ?>次；詳細記錄如下：</span>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12">
                            <table border="1" style="width: 100%;height:100px;text-align: center;border:1px #007F7A solid;">
                                <tr style="background-color:#007F7A">
                                    <th style="width:4.1%;color:white">次數</th>
                                    <?php
                                    for ($i = 0; $i < 12; $i++) {
                                        echo "<td style='color:white;'>" . ($i + 1) . "</td>";
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td style="width:4%;background-color:#BCE1DE;font-weight:bold;">關懷</br>日期</td>
                                    <?php
                                    for ($i = 0; $i < $nurse_count; $i++) {
                                        echo "<td style='width:8%;font-weight:bold;'>$nurse_date[$i]</td>";
                                    }
                                    for ($i = $nurse_count; $i < 12; $i++) {
                                        echo "<td style='width:8%;font-weight:bold;'></td>";
                                    }
                                    ?>
                                </tr>
                            </table><br><br>
                            <div style="text-align: left">
                                <span style="font-size: 22px;">至報告截止日，醫師諮詢紀錄已完成 <?php echo $y; ?>次；詳細記錄如下：</span>
                            </div><br>
                            <table border="1" style="width: 100%;height:100px;text-align: center;border:1px #007F7A solid;">
                                <tr style="background-color:#007F7A">
                                    <th style="width:47px;color:white">次數</th>
                                    <?php
                                    for ($i = 0; $i < 4; $i++) {
                                        echo "<td style='color:white;'>" . ($i + 1) . "</td>";
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td style="background-color:#BCE1DE;font-weight:bold;">關懷</br>日期</td>
                                    <?php
                                    for ($i = 0; $i < $doctor_count; $i++) {
                                        echo "<td style='width:24%;font-weight:bold;'>$doctor_date[$i]</td>";
                                    }
                                    for ($i = $doctor_count; $i < 4; $i++) {
                                        echo "<td style='width:24%;font-weight:bold;'></td>";
                                    }
                                    ?>
                                </tr>
                            </table>
                        </div>
                    </div><br>
                    <div class="row mt-n3" >
                        <p style="font-size: 15px;text-align:left;color: red;margin:0 1% 0 1.2%;margin-right: ">我們於本健康管理報告中所提供之健康管理師關懷、醫師諮詢等，均係依使用者傳輸檢驗結果累積之數據，由專業醫事人員依據當時普遍認可之醫學知識提供說明，並非正式之醫療診斷，使用者如懷疑有任何疾病者，仍應循醫療體系進行診斷及治療。</p>
                    </div>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            </div>
        </div>
        <div class="page"><br>
            <div style="width: 35px;height: 100%;float: left">
                <div style="float: left;background-color: #00AB95;width: 35px;height: 8em"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 25em"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 80em"></div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-6 col-md-5 col-lg-5 col-xl-5">
                    <img src="../../assets/img/logo8.png" style="width: 50%">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10" style="text-align: center;">
                    <hr style="border-top: 1px solid #06827D;">
                    <h1 style="color:#06827D;font-weight:bold;">二、本月份測量數據趨勢分析</h1>
                    <hr style="border-top: 1px solid #06827D;"><br>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card-box" style="margin-right:5%;margin-left: 5%;background-color: #fff0;box-shadow: 0 0 0 0;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            <h2 class="card-title" style="font-size: 1.5rem;color:black">1、血壓量測數據</h2>
                                        </div>
                                        <div class=" col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                            <ul style="font-size: 1.1rem;">
                                                <li class="lichar" style="color:#19A14C;">平均收縮壓約<span id='Char_BP_b1'></span>mmHg</li>
                                                <li class="lichar" style="color:#B2AE16;">平均舒張壓約<span id='Char_BP_b'></span>mmHg</li>
                                            </ul>
                                        </div>
                                        <div class=" col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                            <font style="color: red;font-size: 1.1rem;" id='target'>目標 </font></br>
                                            <font style="color: red;font-size: 1.1rem;" id='target1'>目標 </font>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center">
                                    <div id="bp_chart" style="height: 210px;width:100%;"></div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            <h2 class="card-title" style="font-size: 1.5rem;color:black">2、血糖量測數據</h2>
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0">
                                            <ul style="font-size: 1.1rem;">
                                                <li class="lichar" style="color:#19A14C">平均空腹血糖約<span id='Char_glucose_b_b'></span>mg/dL</li>
                                            </ul>
                                        </div>
                                        <div class=" col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                            <font style="color: red;font-size: 1.1rem;" id='target4'>目標 </font>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div id="AC_chart" style="height: 210px;width:100%"></div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="row mt-n3">
                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <h2 class="card-title" style="font-size: 1.5rem;color:black"></h2>
                                    </div>
                                    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 p-0">
                                        <ul style="font-size: 1.1rem;">
                                            <li class="lichar" style="color:#B2AE16">平均餐後血糖約<span id='Char_glucose_b_a'></span>mg/dL</li>
                                        </ul>
                                    </div>
                                    <div class=" col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                        <font style="color: red;font-size: 1.1rem;" id='target3'>目標 </font></br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div id="PC_chart" style="height: 210px;width:100%"></div>
                            </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                            <h2 class="card-title" style="font-size: 1.5rem;color:black">3、心電圖量測數據</h2>
                                        </div>
                                        <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                            <ul style="font-size: 1.1rem;">
                                                <li class="lichar" style="color:#19A14C">平均心跳數<span id='Char_HR_b'></span>次/分</li>
                                                <!-- <li class="lichar" style="color:#19A14C">平均心跳數 79<span ></span>次/分</li>    -->
                                            </ul>
                                        </div>
                                        <div class=" col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                            <font style="color: red;font-size: 1.1rem;">目標 60-100</font>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <div id="Ecg_chart" style="height: 210px;width:100%"></div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <h2 class="card-title" style="font-size: 1.5rem;color:black">4、總膽固醇、血液尿酸最新量測數據</h2>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                    <table align="left" style="text-align: center;border:1px #007F7A solid;width:100%;" border="1">
                                        <tr style="background-color:#007F7A;font-size: 20px ;color:white;">
                                            <th>總膽固醇</th>
                                            <th>血液尿酸</th>
                                        </tr>
                                        <tr style="background-color:#BCE1DE;font-size: 20px;">
                                            <th id="Cholesterol_b1">-- </th>
                                            <th id="UricAcid_b1">-- </th>
                                        </tr>
                                        <tr style="font-size: 20px;">
                                            <th style="width:50%;">測量結果屬 <span id="CholesterolValue">【--】</span></th>
                                            <th style="width:50%;">測量結果屬 <span id="UricAcidValue">【--】</span></th>
                                        </tr>

                                        <tr style="font-size: 20px;"><!-- ------------------------------------------20240626新增 -->
                                            <th style="width:50%;">量測日期: <span id="CholesterolValue_time">--</span></th>
                                            <th style="width:50%;">量測日期: <span id="UricAcidValue_time">--</span></th>
                                        </tr> 
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page"><br>
            <div style="width: 35px;height: 100%;float: left">
                <div style="float: left;background-color: #00AB95;width: 35px;height: 8em"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 25em"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 80em"></div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-6 col-md-5 col-lg-5 col-xl-5">
                    <img src="../../assets/img/logo8.png" style="width: 50%">
                </div>
            </div><br>
            <div class="row" style="margin-left: 1%">
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10" style="text-align: center;">
                    <hr style="border-top: 1px solid #06827D;">
                    <h1 style="color:#06827D;font-weight:bold;">三、本月份健康管理目標及達成情形</h1>
                    <hr style="border-top: 1px solid #06827D;">
                    <span style="font-size: 20px ;color:#007F7A;padding-top: 10px">以下目標值由芯盛健康管理中心依據您的個人健康狀況訂定。</span>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            </div><br><br><br>
            <div class="card-box" style="text-align: center;width: 70%;margin: 0 auto;background-color: #fff0;box-shadow: 0 0 0 0;">
                <div class="table-responsive">
                    <table class="tabletd" align="center" style="line-height: 50px;font-size: 18px;border:1px #007F7A solid;width: 100%;overflow: hidden" border="2px">
                        <thead>
                        <tr style="background-color:  #007F7A">
                            <th style="color:white">項目</th>
                            <th style="color:white">目標</th>
                            <th style="color:white">結果</th>
                            <th style="color:white">達成情形</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr style="background-color:#BCE1DE">
                            <td>體重(Kg)</td>
                            <td id="w_control_t"></td>
                            <td id="Weight_b">--</td>     <!--20220330個案體重改82,原本正確的-->
                            <!-- <td >82</td>  20220330個案體重改82 -->
                            <!-- <td><font size="3" color="red">82</font></td>    20220401個案體重改82,紅色 -->
                            <td id="w_ac">--</td>
                        </tr>
                        <tr>
                            <td>BMI</td>
                            <td id="">18.5-24</td>
                            <td id="BMI_N">--</td>
                            <td id="BMI_ac">--</td>
                        </tr>
                        <tr style="background-color:#BCE1DE">
                            <td>血壓-收縮壓(mmHg)</td>
                            <td id="bp_goal"></td>
                            <td id="BP_b1">--</td>
                            <td id="bp_ac">--</td>
                        </tr>
                        <tr>
                            <td>血壓-舒張壓(mmHg)</td>
                            <td id="bp_goal1"></td>
                            <td id="BP_b">--</td>
                            <td id="bp_ac1">--</td>
                        </tr>
                        <tr style="background-color:#BCE1DE">
                            <td>血糖-空腹(mg/dL)</td>
                            <td id="bs_goal"></td>
                            <td id="glucose_b">--</td>
                            <td id="glucose_ac">--</td>
                        </tr>
                        <tr>
                            <td>血糖-餐後(mg/dL)</td>
                            <td id="bs_goal1"></td>
                            <td id="glucose_b_a">--</td>
                            <td id="glucose_pc">--</td>
                        </tr>
                        <tr style="background-color:#BCE1DE">
                            <td>尿酸(mg/dL)</td>
                            <td id="ua_control_t"></td>
                            <td id="UricAcid_b">--</td>
                            <td id="ua_ac" style="">--</td>
                        </tr>
                        <tr>
                            <td>總膽固醇(mg/dL)</td>
                            <td id="t_cholesterol_t"></td>
                            <td id="Cholesterol_b">--</td>
                            <td id="c_ac">--</td>
                        </tr>
                        <tr style="background-color:#BCE1DE">
                            <td>心跳數</td>
                            <td id="">60-100</td>
                            <td id="heart1">--</td>
                            <!-- <td>79</td> -->
                            <td id="h_ac">--</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align: right">
                <span style="font-size: 20px;margin-right: 15%;padding-top: 10px"></span>
            </div>
            <div style="width: 100%;height: 80px"></div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" align="center">
                <img src="../../assets/img/ICON_01.png" style="width: 85%">
            </div>
        </div>
        <div class="page" style="height:1000px"><br>
            <div style="width: 35px;height: 100%;float: left">
                <div style="float: left;background-color: #00AB95;width: 35px;height: 8em"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 25em"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 80em"></div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-6 col-md-5 col-lg-5 col-xl-5">
                    <img src="../../assets/img/logo8.png" style="width: 50%">
                </div>
            </div>
            <div class="row" style="margin-left: 1%">
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10 mb-5" style="text-align: center;">
                    <hr style="border-top: 1px solid #06827D;">
                    <h1 style="color:#06827D;font-weight:bold;">四、健管團隊關懷叮嚀</h1>
                    <hr style="border-top: 1px solid #06827D;"><br>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            </div>
            <div class="row" style="margin-right:10%;margin-left: 10%;">
                <!-- <img src="../../assets/img/girl.png" style="width: 85%"> -->
                <div class="card-box col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-1 mb-5" style="background-color: #fff0;margin-left:2%;border:1px #007F7A solid;box-shadow: 0 0 0 0;">
                    <img class="doctorimggirl" src="../../assets/img/girl.png">
                    <div class="card-body" style="padding:0.8rem 0.2rem 0.8rem 4rem;height:130mm;">
                        <h3><b>健管師關懷</b></h3>
                        <div style="font-size: 1.5em" id="NUS_s"></div>
                    </div>
                </div>
                <div class="card-box col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-5" style="background-color: #fff0;margin-left:2%;border:1px #007F7A solid;box-shadow: 0 0 0 0;">
                    <img class="doctorimgboy" src="../../assets/img/boy.png">
                    <div class="card-body" style="padding:0.8rem 0.2rem 0.8rem 4rem;height:130mm;">
                        <h3><b>醫師關懷</b></h3>
                        <div style="font-size: 1.5em" id="Dr_s"></div>

                        <!-- <span class="mb-0">&#40;醫生簽名或蓋章&#41;</span> -->
                        <!-- <div class="row justify-content-end" style="padding:2.4rem 0.2rem 0.1rem 4rem;height:105mm;">
                            <div class="col-3">
                                <span class="mb-0">&#40;醫生簽名或蓋章&#41;</span>
                            </div>
                        </div> -->
                        <!-- <blockquote class="blockquote text-center" style="color: #9E9E9F;">
                            <div style="width: 100mm;height: 100%" id="name_sign"></div>
                            <span class="mb-0">&#40;醫生簽名或蓋章&#41;</span>
                        </blockquote> -->
                    </div>
<!--                    <div class="row justify-content-around" style="color: #9E9E9F;">-->
<!--                        <div class="col-6">-->
<!---->
<!--                        </div>-->
<!--                        <div class="col-3 text-center" style="border-top: 1px solid #9E9E9F;">-->
<!--                            <span class="mb-0">&#40;醫生簽名或蓋章&#41;</span>-->
<!--                        </div>-->
<!--                    </div>-->
                </div>
            </div><br>
            <div class="row justify-content-end">
                <div class="col-3">
                    <h2 class="text-right" style="color: black; "> </h2>
                </div>
                <div class="col-3">
                    <div style="width: 100mm;height: 100%"></div>
                </div>
            </div>
        </div>
        <div class="page"><br>
            <div style="width: 35px;height: 100%;float: left">
                <div style="float: left;background-color: #00AB95;width: 35px;height: 8em"></div>
                <div style="float: left;background-color: #009F91;width: 35px;height: 25em"></div>
                <div style="float: left;background-color: #007F7A;width: 35px;height: 78em"></div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-6 col-md-5 col-lg-5 col-xl-5">
                    <img src="../../assets/img/logo8.png" style="width: 50%">
                </div>
            </div>
            <div class="row" style="margin-left: 1%">
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
                <div class="col-sm-10 col-md-10 col-lg-10 col-xl-10" style="text-align: center;">
                    <hr style="border-top: 1px solid #06827D;">
                    <h1 style="color:#06827D;font-weight:bold;">五、衛教資訊</h1>
                    <hr style="border-top: 1px solid #06827D;"><br>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xl-1"></div>
            </div><br>
            <div class="row" style="justify-content: center!important">
                <div class=" col-sm-8 col-md-8 col-lg-8 col-xl-8" style="height:270mm">
<!--                    <img alt="" style="width:100%;max-height: 270mm" src="data:image/png;base64,>-->
                    <img alt="" style="width:100%;" src="data:image/png;base64,<?php $selectsql = "Select * from health where `tittle` = :tittle ";
                    $info = $link->prepare($selectsql);
                    $info->bindParam(':tittle', $health, PDO::PARAM_STR);
                    $info->execute();
                    $row = $info->fetch();
                    echo $row["base64"]; ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4" style="text-align:center " align="center">
                    <img src="../../assets/img/ICON_02.png" style="width: 100%;height: 100%">
                </div>
                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="text-align: center;padding-bottom: 50px; color:#5F1985">
                            <span style="font-size: 30px;margin-right: 20%"><b>芯盛健康管理團隊 全體同仁</b></span><br>
                            <span style="font-size: 30px;margin-right: 20%"><b>敬祝您 平安健康 順心每一天</b></span>
                        </div>
                        <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5" style="">
                            <img src="../../assets/img/logo8.png" style="width: 100%">
                        </div>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7" style="text-align: left">
                            <span style="font-size: 20px;margin-right: 10%">地址/桃園市桃園區新埔六街101號17樓</span><br>
                            <span style="font-size: 20px;margin-right: 10%">電話/0800-000-876、03-3166912</span><br>
                            <span style="font-size: 20px;margin-right: 10%">網址/www.hshcare.com.tw</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sidebar-overlay" data-reff=""></div>
<!-- <?php require_once('../../assets/js.php'); ?> -->
<script src="./case.js"></script>
<script src="./aidata_chartNS.js"></script>
<script>//------------------------------------------20231113新增
window.onload = function() {
    // 選擇所有的 td 和 th 元素
    var elements = document.querySelectorAll('td, th, th span');
    elements.forEach(function(el) {
        if (el.textContent.trim() === '--') {
            el.style.color = 'red';
        }
        else if (el.textContent.trim() === '【--】') {
            el.style.color = 'red';
        }
    });
};
</script>
<script>
    String.prototype.insert = function(index) {
        if (index > 0)
            return this.substring(0, index) + "<br>" + this.substring(index, this.length);
    };
    var Systolic_Blood_Pressure = '<?php echo $lang->line("case.Systolic_Blood_Pressure"); ?>';
    var Diastolic_Blood_Pressure = '<?php echo $lang->line("case.Diastolic_Blood_Pressure"); ?>';
    var Pulse_Pressure = '<?php echo $lang->line("case.Pulse_Pressure"); ?>';
    var Before_Meal = '<?php echo $lang->line("case.Before_Meal"); ?>';
    var After_Meal = '<?php echo $lang->line("case.After_Meal"); ?>';
    var Cholesterol_Value = '<?php echo $lang->line("case.Cholesterol_Value"); ?>';
    var Uric_Acid_Value = '<?php echo $lang->line("case.Uric_Acid_Value"); ?>';
    var Body_Weight = '<?php echo $lang->line("case.Body_Weight"); ?>';
    var Body_Height = '<?php echo $lang->line("case.Body_Height"); ?>';
    var Waist = '<?php echo $lang->line("case.Waist"); ?>';
    var Bodyfat = '<?php echo $lang->line("case.Bodyfat"); ?>';
    var Brightness = '<?php echo $lang->line("case.Brightness"); ?>';
    var Browse = '<?php echo $lang->line("case.Browse"); ?>';
    var Breakfast = '<?php echo $lang->line("case.Breakfast"); ?>';
    var Lunch = '<?php echo $lang->line("case.Lunch"); ?>';
    var Dinner = '<?php echo $lang->line("case.Dinner"); ?>';
    var Note = '<?php echo $lang->line("case.Note"); ?>';
    var Before = '<?php echo $lang->line("case.Before"); ?>';
    var After = '<?php echo $lang->line("case.After"); ?>';
    var Other = '<?php echo $lang->line("case.Other"); ?>';
    var Sleep = '<?php echo $lang->line("case.Sleep"); ?>';
    var HeartRate = '<?php echo $lang->line("case.heart"); ?>';
    $(document).ready(function() {
        var Member = '<?php echo  htmlspecialchars(strip_tags($_GET['report'])); ?>';
        var end_date = '<?php echo  htmlspecialchars(strip_tags($_GET['end'])); ?>';
        var start_date = '<?php echo htmlspecialchars(strip_tags($_GET['start'])); ?>';
        var Gender = "";
        let suggest = '<?php echo  htmlspecialchars(strip_tags($_GET['suggest'])); ?>';
        let suggest2 = '醫師視訊諮詢安排，將於【 二個月 】後進行，溫馨提醒您；可將要跟醫師討論的健康問題記錄下來喔。</br></br>以便諮詢時能解答您對健康問題的疑惑，謝謝您。';
        let suggest1 = '下個月即將安排【 醫師視訊諮詢 】，溫馨提醒您；可將要跟醫師討論的健康問題記錄下來喔。</br></br>以便諮詢時能解答您對健康問題的疑惑，謝謝您。';
        // 20220829
        let suggest3 = '謹代表 「芯盛健康管理」向您致意，謝謝您讓我們在這一段時間陪伴照顧您或家人</br>的健康，很榮幸有您的支持和信任，給予照護團隊的協助。</br></br>這一年來；謝謝您於服務期間為了您的健康付諸行動，配合量測、調整飲食/運動，</br>讓我們共同為健康促進而努力。</br></br>養成健康的生活習慣，重在「把行動習慣化」，落實於日常生活中，並持之以恆。</br></br>新的服務年度即將展開，讓芯盛健管繼續陪伴您照顧每一天。</br></br>祝福您 健康順心</br>芯盛健康管理 全體同仁 敬上';
        let suggest4 = '謹代表 「芯盛健康管理」向您致意，謝謝您讓我們在這一段時間陪伴照顧您或家人</br>的健康，很榮幸有您的支持和信任，給予照護團隊的協助。</br></br>這一年來；謝謝您於服務期間為了您的健康付諸行動，配合量測、調整飲食/運動，</br>讓我們共同為健康促進而努力。</br></br>養成健康的生活習慣，重在「把行動習慣化」，落實於日常生活中，並持之以恆。</br></br>芯盛健康管理 全體同仁 謝謝您給我們服務的機會。</br>祝福您 健康順心';
        // 20220829
        //let CholesterolValue = '<?php //echo htmlspecialchars(strip_tags($_GET['stup'])); ?>//';
        //let UricAcidValue = '<?php //echo htmlspecialchars(strip_tags($_GET['stup1'])); ?>//';
        $.ajax({
            url: "ajcase.php",
            method: "POST",
            dataType: "json",
            data: {
                Member: Member,
                end_date: end_date,
                start_date: start_date,
            },
            success: function(res) {
                if (res['status'] === "Permission denied") {
                    Swal.fire({
                        icon: 'error',
                        title: '沒有權限!',
                        text: '請告知管理員！',
                        showConfirmButton: true,
                    }).then((result) => {
                        window.location.href = 'https://hs-hc.com.tw/hshc/patient/patient_list/index.php';
                    });
                } else {
                    console.log(res);
                    $('#Member').text(res['data'].Member);
                    $('#Serino').text(res['data'].Serino);
                    $('#Idno').text(res['data'].Idno);
                    $('#Name').text(res['data'].Name);
                    if (res['data'].Gender == "M") {
                        Gender = "先生";
                    } else {
                        Gender = "小姐";
                    }
                    $('#Gender').text(Gender);
                    $('#Program').text(res['data'].Program);
                    $('#StartDate').text(res['smile']);
                    $('#EndDate').text(res['data'].EndDate);
                    $('#plan_name').text(res['plan_name']);
                    $('#Doctor').text(res['Doctor']);
                    $('#Nus').text(res['Nus']);
                    $('#name_sign').empty().append("<img src='data:image/png;base64," + res['name_base64'] + "' style='width:60%;margin-top:-5%'>");

                    var a = res['Dr_s'];
                    var b = [];
                    if(a.length==0 || a==null || a == undefined){
                        if(suggest == '2'){
                            b.push(suggest2);
                        }else if(suggest == '1') {
                            b.push(suggest1);
                        // 20220829
                        }else if(suggest == '3') {
                            b.push(suggest3);
                        
                        }else if(suggest == '4') {
                            b.push(suggest4);
                        }
                        // 20220829    
                    }else {
                        a.forEach((value, index, self) => {
                            b.push(value.toString() + '<br>');
                        });}
                    $('#Dr_s').html(b.toString().replace(/\n/g, '<br>'));
                    // $('#Dr_s').html(b.toString().replace(/\n/g, '<br>').replace(/\B,/g, '<br>'));
                    // $('#Dr_s').html(b.toString());
                    var a1 = res['NUS_s'];
                    console.log(a1);
                    var b1 = [];
                    a1.forEach((value, index, self) => {
                        b1.push(value.toString() + '<br>');
                    });
                    // $('#NUS_s').html(b1.toString().replace(/\B,/g, '<br>'))
                    // $('#NUS_s').html(b1.toString().replace(/\n/g, '<br>'));
                    $('#NUS_s').html(b1.toString().replace(/\n/g, '<br>').replace(/\B,/g, '<br>'));
                    // $('#NUS_s').html(b1.toString());
                }
            }
        });
    });
    $(document).ready(function() {
        var Member = '<?php echo htmlspecialchars(strip_tags($_GET['report'])); ?>';
        var end_date = '<?php echo htmlspecialchars(strip_tags($_GET['end'])); ?>';
        var start_date = '<?php echo htmlspecialchars(strip_tags($_GET['start'])); ?>';
        var average = '<?php echo  htmlspecialchars(strip_tags($_GET['average'])); ?>';
        var d = '<?php echo $d; ?>';
        console.log(d);
        // var Table = $("#Table");
        // ---------------$.ajax-------------會去抓ajtable.php回傳的資料
        $.ajax({
            url: "ajgoal.php",
            method: "POST",
            dataType: "json",
            data: {
                Member: Member,
                end_date: end_date,
                start_date: start_date,
                average: average
            },
            success: function(res) {

                if (res['status'] === "Permission denied") {
                    Swal.fire({
                        icon: 'error',
                        title: '沒有權限!',
                        text: '請告知管理員！',
                        showConfirmButton: true,
                    }).then((result) => {
                        window.location.href = 'https://hs-hc.com.tw/hshc1/patient/patient_list/index.php';
                    });
                } else {
                    console.log(res);
                    $('#w_control_t').text(res['goal'].w_control_t);
                    $('#bp_goal').text(res['goal'].sbp_control_t);
                    $('#target').append(res['goal'].sbp_control_t);
                    $('#bp_goal_h').text(res['goal'].sbp_control_t);
                    $('#target1').append(res['goal'].dbp_control_t);
                    $('#bp_goal1').text(res['goal'].dbp_control_t);
                    $('#bp_goal1_h').text(res['goal'].dbp_control_t);
                    $('#bs_goal').text(res['goal'].bs_control_t_b);
                    $('#target4').append(res['goal'].bs_control_t_b);
                    $('#bs_goal_h').text(res['goal'].bs_control_t_b);
                    $('#bs_goal1').text(res['goal'].bs_control_t_a);
                    $('#target3').append(res['goal'].bs_control_t_a);
                    $('#bs_goal1_h').text(res['goal'].bs_control_t_a);
                    $('#ua_control_t').text(res['goal'].ua_control_t);
                    $('#t_cholesterol_t').text(res['goal'].t_cholesterol_t);
                    $('#hr_i_t').text(res['goal'].hr_i_t);
                    $('#hr_c_t').text(res['goal'].hr_c_t);
                    $('#BMI_T').text(res['goal'].BMI_t);
                    $('#BMI_N').text(res['BMI']);
                    $('#Weight_b').text(res['Weight_b']);
                    var i = 0;
                    var j = 0;
                    let Gender = res['data'].Gender;
                    //BMI正常
                    if (res['BMI'] != null && res['BMI'] != undefined && res['BMI'] != 0) {
                        j += 1;
                        if (parseFloat(res['BMI']) <= 24  && parseFloat(res['BMI']) >= 18.5 ) {
                            var BMI_ac = '正常';
                            $('#BMI_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#BMI_N').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        }else {
                            var BMI_ac = '異常';
                            $('#BMI_ac').attr('style', 'color:red');
                            $('#BMI_N').attr('style', 'color:red');
                        }
                    }else if(res['BMI'] == null || res['BMI'] ==0){
                        $('#BMI_N').text("--");
                        var BMI_ac = '--';
                        $('#BMI_ac').attr('style', 'color:red');
                        $('#BMI_N').attr('style', 'color:red');
                    }
                    $('#BMI_ac').text(BMI_ac);
                    //體重正常
                    if (res['Weight_b'] != null && res['goal'].w_control_t_h != null && res['goal'].w_control_t_l != null && res['goal'].w_control_t_h != undefined && res['goal'].w_control_t_l != undefined) {
                        j += 1;
                        if (parseFloat(res['Weight_b']) <= parseFloat(res['goal'].w_control_t_h) && parseFloat(res['Weight_b']) >= parseFloat(res['goal'].w_control_t_l)) {
                            var w_ac = '正常';
                            $('#w_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#Weight_b').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        }else {
                            var w_ac = '異常';
                            $('#w_ac').attr('style', 'color:red');
                            $('#Weight_b').attr('style', 'color:red');
                        }
                    }else if(res['Weight_b'] == null){
                        $('#Weight_b').text("--");
                        var w_ac = '--';
                        $('#w_ac').attr('style', 'color:red');
                        $('#Weight_b').attr('style', 'color:red');
                    }else if(res['goal'].w_control_t_h == null || res['goal'].w_control_t_l == null || res['goal'].w_control_t_h == undefined || res['goal'].w_control_t_l == undefined){
                        var w_ac = '--';
                        $('#w_ac').attr('style', 'color:red');
                    }

                    $('#w_ac').text(w_ac);
                }
            }
        })
    });
    $(document).ready(function() {
        var Member = '<?php echo htmlspecialchars(strip_tags($_GET['report'])); ?>';
        var end_date = '<?php echo htmlspecialchars(strip_tags($_GET['end'])); ?>';
        var start_date = '<?php echo htmlspecialchars(strip_tags($_GET['start'])); ?>';
        var average = '<?php echo  htmlspecialchars(strip_tags($_GET['average'])); ?>';
        var d = '<?php echo $d; ?>';
        console.log(d);
        // var Table = $("#Table");
        // ---------------$.ajax-------------會去抓ajtable.php回傳的資料
        $.ajax({
            url: "ajglucose.php",
            method: "POST",
            dataType: "json",
            data: {
                Member: Member,
                end_date: end_date,
                start_date: start_date,
                average: average
            },
            success: function(res) {

                if (res['status'] === "Permission denied") {
                    Swal.fire({
                        icon: 'error',
                        title: '沒有權限!',
                        text: '請告知管理員！',
                        showConfirmButton: true,
                    }).then((result) => {
                        window.location.href = 'https://hs-hc.com.tw/hshc1/patient/patient_list/index.php';
                    });
                } else {
                    console.log(res);
                    $('#Char_glucose_b_b').text(res['glucose_b_b']);
                    $('#Char_glucose_b_a').text(res['glucose_b_a']);
                    $('#glucose_b').text(res['glucose_b_b']);
                    $('#glucose_b_a').text(res['glucose_b_a']);
                    $('#bs_goal').text(res['goal'].bs_control_t_b);
                    $('#bs_goal_h').text(res['goal'].bs_control_t_b);
                    $('#bs_goal1').text(res['goal'].bs_control_t_a);
                    $('#bs_goal1_h').text(res['goal'].bs_control_t_a);

                    var i = 0;
                    var j = 0;
                    let Gender = res['data'].Gender;
                    //血糖控制正常
                    if (res['glucose_b_b'] != null && res['goal'].bs_control_t_b_h != null && res['goal'].bs_control_t_b_l != null && res['goal'].bs_control_t_b_h != undefined && res['goal'].bs_control_t_b_l != undefined) {
                        j += 1;
                        if (parseFloat(res['glucose_b_b']) <= parseFloat(res['goal'].bs_control_t_b_h) && parseFloat(res['glucose_b_b']) >= parseFloat(res['goal'].bs_control_t_b_l)) {
                            var glucose_ac_b = '正常';
                            $('#glucose_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#glucose_b').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        }else{
                            var glucose_ac_b = '異常';
                            $('#glucose_ac').attr('style', 'color:red');
                            $('#glucose_b').attr('style', 'color:red');
                        }
                    }else if(res['glucose_b_b'] == null){
                        $('#glucose_b').text("--");
                        $('#Char_glucose_b_b').text("--");
                        var glucose_ac_b = '--';
                        $('#glucose_ac').attr('style', 'color:red');
                        $('#glucose_b').attr('style', 'color:red');
                        $('#Char_glucose_b_b').attr('style', 'color:red');
                    }else if(res['goal'].bs_control_t_b_h == null || res['goal'].bs_control_t_b_l == null || res['goal'].bs_control_t_b_h == undefined || res['goal'].bs_control_t_b_l == undefined){
                        var glucose_ac_b = '--';
                        $('#glucose_ac').attr('style', 'color:red');
                    }

                    $('#glucose_ac').text(glucose_ac_b);
                }
            }
        })
    });
    $(document).ready(function() {
        var Member = '<?php echo htmlspecialchars(strip_tags($_GET['report'])); ?>';
        var end_date = '<?php echo htmlspecialchars(strip_tags($_GET['end'])); ?>';
        var start_date = '<?php echo htmlspecialchars(strip_tags($_GET['start'])); ?>';
        var average = '<?php echo  htmlspecialchars(strip_tags($_GET['average'])); ?>';
        var d = '<?php echo $d; ?>';
        console.log(d);
        // var Table = $("#Table");
        // ---------------$.ajax-------------會去抓ajtable.php回傳的資料
        $.ajax({
            url: "ajglucose2.php",
            method: "POST",
            dataType: "json",
            data: {
                Member: Member,
                end_date: end_date,
                start_date: start_date,
                average: average
            },
            success: function(res) {

                if (res['status'] === "Permission denied") {
                    Swal.fire({
                        icon: 'error',
                        title: '沒有權限!',
                        text: '請告知管理員！',
                        showConfirmButton: true,
                    }).then((result) => {
                        window.location.href = 'https://hs-hc.com.tw/hshc1/patient/patient_list/index.php';
                    });
                } else {
                    console.log(res);
                    $('#Char_glucose_b_b').text(res['glucose_b_b']);
                    $('#Char_glucose_b_a').text(res['glucose_b_a']);
                    $('#glucose_b').text(res['glucose_b_b']);
                    $('#glucose_b_a').text(res['glucose_b_a']);
                    $('#bs_goal').text(res['goal'].bs_control_t_b);
                    $('#bs_goal_h').text(res['goal'].bs_control_t_b);
                    $('#bs_goal1').text(res['goal'].bs_control_t_a);
                    $('#bs_goal1_h').text(res['goal'].bs_control_t_a);

                    var i = 0;
                    var j = 0;
                    let Gender = res['data'].Gender;
                    //血糖控制正常

                    if (res['glucose_b_a'] != null && res['goal'].bs_control_t_a_h != null && res['goal'].bs_control_t_a_l != null && res['goal'].bs_control_t_a_h != undefined && res['goal'].bs_control_t_a_l != undefined) {
                        j += 1;
                        if (parseFloat(res['glucose_b_a']) <= parseFloat(res['goal'].bs_control_t_a_h) && parseFloat(res['glucose_b_a']) >= parseFloat(res['goal'].bs_control_t_a_l)) {
                            var glucose_pc_a = '正常';
                            $('#glucose_pc').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#glucose_b_a').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        } else{
                            var glucose_pc_a = '異常';
                            $('#glucose_pc').attr('style', 'color:red');
                            $('#glucose_b_a').attr('style', 'color:red');
                        }
                    }else if(res['glucose_b_a'] == null){
                        $('#glucose_b_a').text("--");
                        $('#Char_glucose_b_a').text("--");
                        var glucose_pc_a = '--';
                        $('#glucose_pc').attr('style', 'color:red');
                        $('#glucose_b_a').attr('style', 'color:red');
                        $('#Char_glucose_b_a').attr('style', 'color:red');
                    }else if(res['goal'].bs_control_t_a_h == null || res['goal'].bs_control_t_a_l == null || res['goal'].bs_control_t_a_h == undefined || res['goal'].bs_control_t_a_l == undefined){
                        var glucose_pc_a = '--';
                        $('#glucose_pc').attr('style', 'color:red');
                    }

                    $('#glucose_pc').text(glucose_pc_a);
                }
            }
        })
    });
    setTimeout(function() {
        var Member = '<?php echo htmlspecialchars(strip_tags($_GET['report'])); ?>';
        var end_date = '<?php echo htmlspecialchars(strip_tags($_GET['end'])); ?>';
        var start_date = '<?php echo htmlspecialchars(strip_tags($_GET['start'])); ?>';
        var average = '<?php echo  htmlspecialchars(strip_tags($_GET['average'])); ?>';
        var d = '<?php echo $d; ?>';
        console.log(d);
        // var Table = $("#Table");
        // ---------------$.ajax-------------會去抓ajtable.php回傳的資料
        $.ajax({
            url: "ajbp.php",
            method: "POST",
            dataType: "json",
            data: {
                Member: Member,
                end_date: end_date,
                start_date: start_date,
                average: average
            },
            success: function(res) {

                if (res['status'] === "Permission denied") {
                    Swal.fire({
                        icon: 'error',
                        title: '沒有權限!',
                        text: '請告知管理員！',
                        showConfirmButton: true,
                    }).then((result) => {
                        window.location.href = 'https://hs-hc.com.tw/hshc1/patient/patient_list/index.php';
                    });
                } else {
                    console.log(res);
                    $('#Char_BP_b1').text(res['Systolic']);
                    $('#Char_BP_b').text(res['Diastolic']);
                    $('#BP_b').text(res['Diastolic']);
                    $('#BP_b1').text(res['Systolic']);
                    $('#bp_goal').text(res['goal'].sbp_control_t);
                    $('#bp_goal_h').text(res['goal'].sbp_control_t);
                    $('#bp_goal1').text(res['goal'].dbp_control_t);
                    $('#bp_goal1_h').text(res['goal'].dbp_control_t);
                    BP(res['BP_Diastolic'], res['BP_Systolic'],res['goal'].sbp_control_t, res['goal'].dbp_control_t);
                    var i = 0;
                    var j = 0;
                    let Gender = res['data'].Gender;
                    //血壓控制正常
                    if (res['Diastolic'] != null && res['goal'].dbp_control_t_h != null && res['goal'].dbp_control_t_l != null && res['goal'].dbp_control_t_h != undefined && res['goal'].dbp_control_t_l != undefined) {
                        j += 1;
                        if (parseFloat(res['Diastolic']) <= parseFloat(res['goal'].dbp_control_t_h) && parseFloat(res['Diastolic']) >= parseFloat(res['goal'].dbp_control_t_l)) {
                            var d_ac_b = '正常';
                            $('#bp_ac1').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#BP_b').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        }else{
                            var d_ac_b = '異常';
                            $('#bp_ac1').attr('style', 'color:red');
                            $('#BP_b').attr('style', 'color:red');
                        }
                    }else if(res['Diastolic'] == null){
                        $('#BP_b').text("--");
                        $('#Char_BP_b').text("--");
                        var d_ac_b = '--';
                        $('#bp_ac1').attr('style', 'color:red');
                        $('#BP_b').attr('style', 'color:red');
                        $('#Char_BP_b').attr('style', 'color:red');
                    }else if(res['goal'].dbp_control_t_h == null || res['goal'].dbp_control_t_l == null || res['goal'].dbp_control_t_h == undefined || res['goal'].dbp_control_t_l == undefined){
                        var d_ac_b = '--';
                        $('#bp_ac1').attr('style', 'color:red');
                    }

                    if (res['Systolic'] != null && res['goal'].sbp_control_t_h != null && res['goal'].sbp_control_t_l != null && res['goal'].sbp_control_t_h != undefined && res['goal'].sbp_control_t_l != undefined) {
                        j += 1;
                        if (parseFloat(res['Systolic']) <= parseFloat(res['goal'].sbp_control_t_h) && parseFloat(res['Systolic']) >= parseFloat(res['goal'].sbp_control_t_l)) {
                            var s_ac_b = '正常';
                            $('#bp_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#BP_b1').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        }else{
                            var s_ac_b = '異常';
                            $('#bp_ac').attr('style', 'color:red');
                            $('#BP_b1').attr('style', 'color:red');
                        }
                    }else if(res['Systolic'] == null){
                        $('#BP_b1').text("--");
                        $('#Char_BP_b1').text("--");
                        var s_ac_b = '--';
                        $('#bp_ac').attr('style', 'color:red');
                        $('#BP_b1').attr('style', 'color:red');
                        $('#Char_BP_b1').attr('style', 'color:red');
                    }else if(res['goal'].sbp_control_t_h == null || res['goal'].sbp_control_t_l == null || res['goal'].sbp_control_t_h == undefined || res['goal'].sbp_control_t_l == undefined){
                        var s_ac_b = '--';
                        $('#bp_ac').attr('style', 'color:red');
                    }

                    $('#bp_ac').text(s_ac_b);
                    $('#bp_ac1').text(d_ac_b);
                }
            }
        })
}, 1000); // 延迟1秒执行，你可以根据需要调整延迟时间
    // $(document).ready(function() {
    //     var Member = '<?php echo htmlspecialchars(strip_tags($_GET['report'])); ?>';
    //     var end_date = '<?php echo htmlspecialchars(strip_tags($_GET['end'])); ?>';
    //     var start_date = '<?php echo htmlspecialchars(strip_tags($_GET['start'])); ?>';
    //     var average = '<?php echo  htmlspecialchars(strip_tags($_GET['average'])); ?>';
    //     var d = '<?php echo $d; ?>';
    //     console.log(d);
    //     // var Table = $("#Table");
    //     // ---------------$.ajax-------------會去抓ajtable.php回傳的資料
    //     $.ajax({
    //         url: "ajbp.php",
    //         method: "POST",
    //         dataType: "json",
    //         data: {
    //             Member: Member,
    //             end_date: end_date,
    //             start_date: start_date,
    //             average: average
    //         },
    //         success: function(res) {

    //             if (res['status'] === "Permission denied") {
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: '沒有權限!',
    //                     text: '請告知管理員！',
    //                     showConfirmButton: true,
    //                 }).then((result) => {
    //                     window.location.href = 'https://hs-hc.com.tw/hshc1/patient/patient_list/index.php';
    //                 });
    //             } else {
    //                 console.log(res);
    //                 $('#Char_BP_b1').text(res['Systolic']);
    //                 $('#Char_BP_b').text(res['Diastolic']);
    //                 $('#BP_b').text(res['Diastolic']);
    //                 $('#BP_b1').text(res['Systolic']);
    //                 $('#bp_goal').text(res['goal'].sbp_control_t);
    //                 $('#bp_goal_h').text(res['goal'].sbp_control_t);
    //                 $('#bp_goal1').text(res['goal'].dbp_control_t);
    //                 $('#bp_goal1_h').text(res['goal'].dbp_control_t);
    //                 BP(res['BP_Diastolic'], res['BP_Systolic'],res['goal'].sbp_control_t, res['goal'].dbp_control_t);
    //                 var i = 0;
    //                 var j = 0;
    //                 let Gender = res['data'].Gender;
    //                 //血壓控制正常
    //                 if (res['Diastolic'] != null && res['goal'].dbp_control_t_h != null && res['goal'].dbp_control_t_l != null && res['goal'].dbp_control_t_h != undefined && res['goal'].dbp_control_t_l != undefined) {
    //                     j += 1;
    //                     if (parseFloat(res['Diastolic']) <= parseFloat(res['goal'].dbp_control_t_h) && parseFloat(res['Diastolic']) >= parseFloat(res['goal'].dbp_control_t_l)) {
    //                         var d_ac_b = '正常';
    //                         $('#bp_ac1').attr('style', 'color:black');//------------------------------------------20231113新增
    //                         $('#BP_b').attr('style', 'color:black');//------------------------------------------20231113新增
    //                         i += 1;
    //                     }else{
    //                         var d_ac_b = '異常';
    //                         $('#bp_ac1').attr('style', 'color:red');
    //                         $('#BP_b').attr('style', 'color:red');
    //                     }
    //                 }else if(res['Diastolic'] == null){
    //                     $('#BP_b').text("--");
    //                     $('#Char_BP_b').text("--");
    //                     var d_ac_b = '--';
    //                     $('#bp_ac1').attr('style', 'color:red');
    //                     $('#BP_b').attr('style', 'color:red');
    //                     $('#Char_BP_b').attr('style', 'color:red');
    //                 }else if(res['goal'].dbp_control_t_h == null || res['goal'].dbp_control_t_l == null || res['goal'].dbp_control_t_h == undefined || res['goal'].dbp_control_t_l == undefined){
    //                     var d_ac_b = '--';
    //                     $('#bp_ac1').attr('style', 'color:red');
    //                 }

    //                 if (res['Systolic'] != null && res['goal'].sbp_control_t_h != null && res['goal'].sbp_control_t_l != null && res['goal'].sbp_control_t_h != undefined && res['goal'].sbp_control_t_l != undefined) {
    //                     j += 1;
    //                     if (parseFloat(res['Systolic']) <= parseFloat(res['goal'].sbp_control_t_h) && parseFloat(res['Systolic']) >= parseFloat(res['goal'].sbp_control_t_l)) {
    //                         var s_ac_b = '正常';
    //                         $('#bp_ac').attr('style', 'color:black');//------------------------------------------20231113新增
    //                         $('#BP_b1').attr('style', 'color:black');//------------------------------------------20231113新增
    //                         i += 1;
    //                     }else{
    //                         var s_ac_b = '異常';
    //                         $('#bp_ac').attr('style', 'color:red');
    //                         $('#BP_b1').attr('style', 'color:red');
    //                     }
    //                 }else if(res['Systolic'] == null){
    //                     $('#BP_b1').text("--");
    //                     $('#Char_BP_b1').text("--");
    //                     var s_ac_b = '--';
    //                     $('#bp_ac').attr('style', 'color:red');
    //                     $('#BP_b1').attr('style', 'color:red');
    //                     $('#Char_BP_b1').attr('style', 'color:red');
    //                 }else if(res['goal'].sbp_control_t_h == null || res['goal'].sbp_control_t_l == null || res['goal'].sbp_control_t_h == undefined || res['goal'].sbp_control_t_l == undefined){
    //                     var s_ac_b = '--';
    //                     $('#bp_ac').attr('style', 'color:red');
    //                 }

    //                 $('#bp_ac').text(s_ac_b);
    //                 $('#bp_ac1').text(d_ac_b);
    //             }
    //         }
    //     })
    // });
    $(document).ready(function() {
        var Member = '<?php echo htmlspecialchars(strip_tags($_GET['report'])); ?>';
        var end_date = '<?php echo htmlspecialchars(strip_tags($_GET['end'])); ?>';
        var start_date = '<?php echo htmlspecialchars(strip_tags($_GET['start'])); ?>';
        var average = '<?php echo  htmlspecialchars(strip_tags($_GET['average'])); ?>';
        var d = '<?php echo $d; ?>';
        console.log(d);
        // var Table = $("#Table");
        $.ajax({
            url: "ajtable.php",
            method: "POST",
            dataType: "json",
            data: {
                Member: Member,
                end_date: end_date,
                start_date: start_date,
                average: average
            },
            success: function(res) {

                if (res['status'] === "Permission denied") {
                    Swal.fire({
                        icon: 'error',
                        title: '沒有權限!',
                        text: '請告知管理員！',
                        showConfirmButton: true,
                    }).then((result) => {
                        window.location.href = 'https://hs-hc.com.tw/hshc/patient/patient_list/index.php';
                    });
                } else {
                    console.log(res);
                    $('#Char_glucose_b_b').text(res['glucose_b_b']);
                    $('#Char_glucose_b_a').text(res['glucose_b_a']);
                    $('#Char_BP_b1').text(res['Systolic']);
                    $('#Char_BP_b').text(res['Diastolic']);
                    $('#heart1').text(res['HR_b']);
                    $('#Char_HR_b').text(res['HR_b']);
                    // if (res['Weight_b'] == null) {
                    //     res['Weight_b'] = '';
                    // }
                    $('#BMI_N').text(res['BMI']);
                    $('#Weight_b').text(res['Weight_b']);
                    $('#BP_b').text(res['Diastolic']);
                    $('#BP_b1').text(res['Systolic']);
                    $('#glucose_b').text(res['glucose_b_b']);
                    $('#glucose_b_a').text(res['glucose_b_a']);
                    $('#UricAcid_b').text(res['UricAcid_b1']);
                    $('#UricAcid_b1').text(res['UricAcid_b1'] + " mg/dL");
                    $('#Cholesterol_b').text(res['Cholesterol_b1']);
                    $('#Cholesterol_b1').text(res['Cholesterol_b1'] + " mg/dL");
                    $('#UricAcidValue_time').text(res['UricAcidValue_time']);//------------------------------------------20240626新增
                    $('#CholesterolValue_time').text(res['CholesterolValue_time']);//------------------------------------------20240626新增
                    // $('#heart').text(res['heart']);
                    // $('#heart1').text(res['heart']);
                    $('#w_control_t').text(res['goal'].w_control_t);
                    $('#bp_goal').text(res['goal'].sbp_control_t);
                    $('#bp_goal_h').text(res['goal'].sbp_control_t);
                    $('#bp_goal1').text(res['goal'].dbp_control_t);
                    $('#bp_goal1_h').text(res['goal'].dbp_control_t);
                    $('#bs_goal').text(res['goal'].bs_control_t_b);
                    $('#bs_goal_h').text(res['goal'].bs_control_t_b);
                    $('#bs_goal1').text(res['goal'].bs_control_t_a);
                    $('#bs_goal1_h').text(res['goal'].bs_control_t_a);
                    $('#ua_control_t').text(res['goal'].ua_control_t);
                    $('#t_cholesterol_t').text(res['goal'].t_cholesterol_t);
                    $('#hr_i_t').text(res['goal'].hr_i_t);
                    $('#hr_c_t').text(res['goal'].hr_c_t);
                    $('#BMI_T').text(res['goal'].BMI_t);
                    BP(res['BP_Diastolic'], res['BP_Systolic'],res['goal'].sbp_control_t, res['goal'].dbp_control_t);
                    AC_Glucose(res['AC_Glucose'],res['goal'].bs_control_t_b);
                    // console.log(res['AC_Glucose'].name);
                    PC_Glucose(res['PC_Glucose'],res['goal'].bs_control_t_a);
                    // AC_Glucose(res['AC_Glucose'], res['PC_Glucose'],res['Glucose_Date']);
                    // PC_Glucose(res['AC_Glucose'], res['PC_Glucose'],res['Glucose_Date']);
                    // console.log(res['ecg_HR'], res['ecg_QRS']); //------------------------------------------20220303新增
                    // res['ecg_HR'][0]['y'] = 79;                    //------------------------------------------20220308新增
                    ecg(res['ecg_HR'], res['ecg_QRS']);
                    // bp_goal(res['goal'].sbp_control_t, res['goal'].dbp_control_t)
                    // AC_chart(res['goal'].bs_control_t_b, res['goal'].bs_control_t_a)
                    $('#UricAcidValue_time').attr('style', 'color:black');//------------------------------------------20240626新增
                    $('#CholesterolValue_time').attr('style', 'color:black');//------------------------------------------20240626新增

                    var i = 0;
                    var j = 0;
                    let Gender = res['data'].Gender;
                    //BMI正常
                    if (res['BMI'] != null && res['BMI'] != undefined && res['BMI'] != 0) {
                        j += 1;
                        if (parseFloat(res['BMI']) <= 24  && parseFloat(res['BMI']) >= 18.5 ) {
                            var BMI_ac = '正常';
                            $('#BMI_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#BMI_N').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        }else {
                            var BMI_ac = '異常';
                            $('#BMI_ac').attr('style', 'color:red');
                            $('#BMI_N').attr('style', 'color:red');
                        }
                    }else if(res['BMI'] == null || res['BMI'] ==0){
                        $('#BMI_N').text("--");
                        var BMI_ac = '--';
                        $('#BMI_ac').attr('style', 'color:red');
                        $('#BMI_N').attr('style', 'color:red');
                    }
                    $('#BMI_ac').text(BMI_ac);
                    //體重正常
                    if (res['Weight_b'] != null && res['goal'].w_control_t_h != null && res['goal'].w_control_t_l != null && res['goal'].w_control_t_h != undefined && res['goal'].w_control_t_l != undefined) {
                        j += 1;
                        if (parseFloat(res['Weight_b']) <= parseFloat(res['goal'].w_control_t_h) && parseFloat(res['Weight_b']) >= parseFloat(res['goal'].w_control_t_l)) {
                            var w_ac = '正常';
                            $('#w_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#Weight_b').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        }else {
                            var w_ac = '異常';
                            $('#w_ac').attr('style', 'color:red');
                            $('#Weight_b').attr('style', 'color:red');
                        }
                    }else if(res['Weight_b'] == null){
                        $('#Weight_b').text("--");
                        var w_ac = '--';
                        $('#w_ac').attr('style', 'color:red');
                        $('#Weight_b').attr('style', 'color:red');
                    }else if(res['goal'].w_control_t_h == null || res['goal'].w_control_t_l == null || res['goal'].w_control_t_h == undefined || res['goal'].w_control_t_l == undefined){
                        var w_ac = '--';
                        $('#w_ac').attr('style', 'color:red');
                    }

                    $('#w_ac').text(w_ac);

                    //血壓控制正常
                    // if (res['Diastolic'] != null && res['goal'].dbp_control_t_h != null && res['goal'].dbp_control_t_l != null && res['goal'].dbp_control_t_h != undefined && res['goal'].dbp_control_t_l != undefined) {
                    //     j += 1;
                    //     if (parseFloat(res['Diastolic']) <= parseFloat(res['goal'].dbp_control_t_h) && parseFloat(res['Diastolic']) >= parseFloat(res['goal'].dbp_control_t_l)) {
                    //         var d_ac_b = '正常';
                    //         $('#bp_ac1').attr('style', 'color:black');//------------------------------------------20231113新增
                    //         $('#BP_b').attr('style', 'color:black');//------------------------------------------20231113新增
                    //         i += 1;
                    //     }else{
                    //         var d_ac_b = '異常';
                    //         $('#bp_ac1').attr('style', 'color:red');
                    //         $('#BP_b').attr('style', 'color:red');
                    //     }
                    // }else if(res['Diastolic'] == null){
                    //     $('#BP_b').text("--");
                    //     $('#Char_BP_b').text("--");
                    //     var d_ac_b = '--';
                    //     $('#bp_ac1').attr('style', 'color:red');
                    //     $('#BP_b').attr('style', 'color:red');
                    //     $('#Char_BP_b').attr('style', 'color:red');
                    // }else if(res['goal'].dbp_control_t_h == null || res['goal'].dbp_control_t_l == null || res['goal'].dbp_control_t_h == undefined || res['goal'].dbp_control_t_l == undefined){
                    //     var d_ac_b = '--';
                    //     $('#bp_ac1').attr('style', 'color:red');
                    // }

                    // if (res['Systolic'] != null && res['goal'].sbp_control_t_h != null && res['goal'].sbp_control_t_l != null && res['goal'].sbp_control_t_h != undefined && res['goal'].sbp_control_t_l != undefined) {
                    //     j += 1;
                    //     if (parseFloat(res['Systolic']) <= parseFloat(res['goal'].sbp_control_t_h) && parseFloat(res['Systolic']) >= parseFloat(res['goal'].sbp_control_t_l)) {
                    //         var s_ac_b = '正常';
                    //         $('#bp_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                    //         $('#BP_b1').attr('style', 'color:black');//------------------------------------------20231113新增
                    //         i += 1;
                    //     }else{
                    //         var s_ac_b = '異常';
                    //         $('#bp_ac').attr('style', 'color:red');
                    //         $('#BP_b1').attr('style', 'color:red');
                    //     }
                    // }else if(res['Systolic'] == null){
                    //     $('#BP_b1').text("--");
                    //     $('#Char_BP_b1').text("--");
                    //     var s_ac_b = '--';
                    //     $('#bp_ac').attr('style', 'color:red');
                    //     $('#BP_b1').attr('style', 'color:red');
                    //     $('#Char_BP_b1').attr('style', 'color:red');
                    // }else if(res['goal'].sbp_control_t_h == null || res['goal'].sbp_control_t_l == null || res['goal'].sbp_control_t_h == undefined || res['goal'].sbp_control_t_l == undefined){
                    //     var s_ac_b = '--';
                    //     $('#bp_ac').attr('style', 'color:red');
                    // }

                    // $('#bp_ac').text(s_ac_b);
                    // $('#bp_ac1').text(d_ac_b);
                    //血糖控制正常
                    if (res['glucose_b_b'] != null && res['goal'].bs_control_t_b_h != null && res['goal'].bs_control_t_b_l != null && res['goal'].bs_control_t_b_h != undefined && res['goal'].bs_control_t_b_l != undefined) {
                        j += 1;
                        if (parseFloat(res['glucose_b_b']) <= parseFloat(res['goal'].bs_control_t_b_h) && parseFloat(res['glucose_b_b']) >= parseFloat(res['goal'].bs_control_t_b_l)) {
                            var glucose_ac_b = '正常';
                            $('#glucose_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#glucose_b').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        }else{
                            var glucose_ac_b = '異常';
                            $('#glucose_ac').attr('style', 'color:red');
                            $('#glucose_b').attr('style', 'color:red');
                        }
                    }else if(res['glucose_b_b'] == null){
                        $('#glucose_b').text("--");
                        $('#Char_glucose_b_b').text("--");
                        var glucose_ac_b = '--';
                        $('#glucose_ac').attr('style', 'color:red');
                        $('#glucose_b').attr('style', 'color:red');
                        $('#Char_glucose_b_b').attr('style', 'color:red');
                    }else if(res['goal'].bs_control_t_b_h == null || res['goal'].bs_control_t_b_l == null || res['goal'].bs_control_t_b_h == undefined || res['goal'].bs_control_t_b_l == undefined){
                        var glucose_ac_b = '--';
                        $('#glucose_ac').attr('style', 'color:red');
                    }

                    if (res['glucose_b_a'] != null && res['goal'].bs_control_t_a_h != null && res['goal'].bs_control_t_a_l != null && res['goal'].bs_control_t_a_h != undefined && res['goal'].bs_control_t_a_l != undefined) {
                        j += 1;
                        if (parseFloat(res['glucose_b_a']) <= parseFloat(res['goal'].bs_control_t_a_h) && parseFloat(res['glucose_b_a']) >= parseFloat(res['goal'].bs_control_t_a_l)) {
                            var glucose_pc_a = '正常';
                            $('#glucose_pc').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#glucose_b_a').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        } else{
                            var glucose_pc_a = '異常';
                            $('#glucose_pc').attr('style', 'color:red');
                            $('#glucose_b_a').attr('style', 'color:red');
                        }
                    }else if(res['glucose_b_a'] == null){
                        $('#glucose_b_a').text("--");
                        $('#Char_glucose_b_a').text("--");
                        var glucose_pc_a = '--';
                        $('#glucose_pc').attr('style', 'color:red');
                        $('#glucose_b_a').attr('style', 'color:red');
                        $('#Char_glucose_b_a').attr('style', 'color:red');
                    }else if(res['goal'].bs_control_t_a_h == null || res['goal'].bs_control_t_a_l == null || res['goal'].bs_control_t_a_h == undefined || res['goal'].bs_control_t_a_l == undefined){
                        var glucose_pc_a = '--';
                        $('#glucose_pc').attr('style', 'color:red');
                    }

                    $('#glucose_ac').text(glucose_ac_b);
                    $('#glucose_pc').text(glucose_pc_a);
                    //尿酸控制正常
                    // if (res['UricAcid_b'] != null) {
                    //     j += 1;
                    //     if(Gender=="M") {
                    //         if (parseFloat(res['UricAcid_b']) <= 7 && parseFloat(res['UricAcid_b']) >= 3) {
                    //             var ua_ac = '正常';
                    //             i += 1;
                    //         }else{
                    //             var ua_ac = '異常';
                    //             $('#ua_ac').attr('style', 'color:red');
                    //             $('#UricAcid_b').attr('style', 'color:red');
                    //         }
                    //     }else if(Gender=="F"){
                    //         if (parseFloat(res['UricAcid_b']) <= 6 && parseFloat(res['UricAcid_b']) >= 2.5) {
                    //             var ua_ac = '正常';
                    //             i += 1;
                    //         }else{
                    //             var ua_ac = '異常';
                    //             $('#ua_ac').attr('style', 'color:red');
                    //             $('#UricAcid_b').attr('style', 'color:red');
                    //         }
                    //     }
                    // }else if(res['UricAcid_b'] == null){
                    //     $('#UricAcid_b').text("--");
                    //     var ua_ac = '--';
                    //     $('#ua_ac').attr('style', 'color:red');
                    //     $('#UricAcid_b').attr('style', 'color:red');
                    // }
                    if (res['UricAcid_b1'] != null) {
                        j += 1;
                        if(Gender=="M") {
                            if (parseFloat(res['UricAcid_b1']) <= 7 && parseFloat(res['UricAcid_b1']) >= 3) {
                                var ua_ac1 = '正常';
                                $('#UricAcid_b1').attr('style', 'color:black');//------------------------------------------20231113新增
                                $('#ua_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                                $('#UricAcid_b').attr('style', 'color:black');//------------------------------------------20231113新增
                                i += 1;
                            }else{
                                var ua_ac1 = '異常';
                                $('#UricAcid_b1').attr('style', 'color:red');
                                $('#ua_ac').attr('style', 'color:red');
                                $('#UricAcid_b').attr('style', 'color:red');
                            }
                        }else if(Gender=="F"){
                            if (parseFloat(res['UricAcid_b1']) <= 6 && parseFloat(res['UricAcid_b1']) >= 2.5) {
                                var ua_ac1 = '正常';
                                $('#UricAcid_b1').attr('style', 'color:black');//------------------------------------------20231113新增
                                $('#ua_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                                $('#UricAcid_b').attr('style', 'color:black');//------------------------------------------20231113新增
                                i += 1;
                            }else{
                                var ua_ac1 = '異常';
                                $('#UricAcid_b1').attr('style', 'color:red');
                                $('#ua_ac').attr('style', 'color:red');
                                $('#UricAcid_b').attr('style', 'color:red');
                            }
                        }
                    }else if(res['UricAcid_b1'] == null){
                        var ua_ac1 = '--';
                        $('#UricAcid_b').text("--");
                        $('#UricAcid_b1').text("--");
                        $('#UricAcid_b1').attr('style', 'color:red');
                        $('#ua_ac').attr('style', 'color:red');
                        $('#UricAcid_b').attr('style', 'color:red');
                        $('#UricAcidValue_time').attr('style', 'color:red');//------------------------------------------20240626新增
                        $('#UricAcidValue_time').text("--");
                        
                    }

                    $('#UricAcidValue').text('【' + ua_ac1 + '】');
                    if (ua_ac1 == '正常') {
                        $('#UricAcidValue').attr('style', 'color:#009FE8');
                    } else {
                        $('#UricAcidValue').attr('style', 'color:red');
                    }
                    $('#ua_ac').text(ua_ac1);
                    //膽固醇控制正常
                    // if (res['Cholesterol_b'] != null) {
                    //     j += 1;
                    //     if (parseFloat(res['Cholesterol_b']) <= 200 && parseFloat(res['Cholesterol_b']) >= 130) {
                    //         var c_ac = '正常';
                    //         i += 1;
                    //     }else {
                    //         var c_ac = '異常';
                    //         $('#c_ac').attr('style', 'color:red');
                    //         $('#Cholesterol_b').attr('style', 'color:red');
                    //     }
                    // }else if(res['Cholesterol_b'] == null){
                    //     $('#Cholesterol_b').text("--");
                    //     var c_ac = '--';
                    //     $('#c_ac').attr('style', 'color:red');
                    //     $('#Cholesterol_b').attr('style', 'color:red');
                    // }

                    if (res['Cholesterol_b1'] != null) {
                        j += 1;
                            if (parseFloat(res['Cholesterol_b1']) <= 200 && parseFloat(res['Cholesterol_b1']) >= 130) {
                                var c_ac1 = '正常';
                                $('#c_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                                $('#Cholesterol_b').attr('style', 'color:black');//------------------------------------------20231113新增
                                $('#Cholesterol_b1').attr('style', 'color:black');//------------------------------------------20231113新增
                                i += 1;
                            }else{
                                var c_ac1 = '異常';
                                $('#c_ac').attr('style', 'color:red');
                                $('#Cholesterol_b').attr('style', 'color:red');
                                $('#Cholesterol_b1').attr('style', 'color:red');
                            }
                    }else if(res['Cholesterol_b1'] == null){
                        var c_ac1 = '--';
                        $('#Cholesterol_b').text("--");
                        $('#Cholesterol_b1').text("--");
                        $('#Cholesterol_b1').attr('style', 'color:red');
                        $('#c_ac').attr('style', 'color:red');
                        $('#Cholesterol_b').attr('style', 'color:red');
                        $('#CholesterolValue_time').attr('style', 'color:red');//------------------------------------------20240626新增
                        $('#CholesterolValue_time').text("--");
                    }

                    $('#CholesterolValue').text('【' + c_ac1 + '】');
                    if (c_ac1 == '正常') {
                        $('#CholesterolValue').attr('style', 'color:#009FE8');
                    } else {
                        $('#CholesterolValue').attr('style', 'color:red');
                    }
                    $('#c_ac').text(c_ac1);
                    //心跳數正常
                    var str = res['HR_b'];
                    if (res['HR_b'] != null) {
                        j += 1;
                        if (str>=60 && str<=100) {
                            var h_ac = '正常'
                            $('#h_ac').attr('style', 'color:black');//------------------------------------------20231113新增
                            $('#heart1').attr('style', 'color:black');//------------------------------------------20231113新增
                            i += 1;
                        } else {
                            var h_ac = '異常'
                            $('#h_ac').attr('style', 'color:red');
                            $('#heart1').attr('style', 'color:red');
                        }
                    } else if(str == null){
                        $('#heart1').text("--");
                        $('#Char_HR_b').text("--");
                        var h_ac = '--'
                        $('#h_ac').attr('style', 'color:red');
                        $('#heart1').attr('style', 'color:red');
                        $('#Char_HR_b').attr('style', 'color:red');
                    }

                    $('#h_ac').text(h_ac);
                    $('#care2').text('正常');
                    i += 1;
                    j += 1;
                    var k = i / j * 100;
                    if (k >= 85) {
                        $("#prompt").append("<font>給你一個讚!</font>")
                    } else if (k < 85 && k >= 60) {
                        $("#prompt").append("還不錯 要繼續加油喔!")
                    } else if (k < 60 && k >= 40) {
                        $("#prompt").append("你很努力了 繼續朝目標邁進吧!")
                    } else {
                        $("#prompt").append("工作再忙都要注意身體喔!<br>期待你下個月達標喔~~")
                    }
                    TAR(k);
                    //心律判讀正常
                }
            }
        });
    

        // function bp_goal(bp_Systolic_goal, bp_Diastolic_goal) {
        //     // Diastolic 舒張
        //     // Systolic 收縮
        //     let bp_chart = $('#bp_chart').highcharts();
        //     let plotLines = [];
        //     let max;
        //     let min;
        //     let maxvalue;
        //     let minvalue;
        //     if (parseInt(bp_Diastolic_goal) >= parseInt(bp_Systolic_goal)) {
        //         maxvalue = parseInt(bp_Diastolic_goal);
        //         minvalue = parseInt(bp_Systolic_goal);
        //     } else {
        //         maxvalue = parseInt(bp_Systolic_goal);
        //         minvalue = parseInt(bp_Diastolic_goal);
        //     }
        //     if(parseInt(bp_chart.yAxis[0].dataMax) >= maxvalue) {
        //         max = parseInt(bp_chart.yAxis[0].dataMax);
        //     }else{
        //         max = maxvalue + 15;
        //     }
        //     if(parseInt(bp_chart.yAxis[0].dataMin) >= minvalue) {
        //         min = minvalue - 15;
        //     }else{
        //         min = parseInt(bp_chart.yAxis[0].dataMin);
        //     }
        //     bp_chart.yAxis[0].setExtremes(min, max);
        //     plotLines.push(bp_chart.yAxis[0].addPlotLine({
        //         value: bp_Systolic_goal,
        //         color: 'red',
        //         width: 2,
        //         dashStyle: 'ShortDash'
        //     }));
        //     plotLines.push(bp_chart.yAxis[0].addPlotLine({
        //         value: bp_Diastolic_goal,
        //         color: 'red',
        //         width: 2,
        //         dashStyle: 'ShortDash'
        //     }));
        //     bp_chart.setTitle(null, {
        //         text: '<div class="ml-2" style="font-size:16px;width:100%;height:100%"><i class="fa fa-ellipsis-h ml-3 mr-2" aria-hidden="true" style="color:#FF0000;"></i><span class="icondash" style="color:black;font-size:10px">數值目標線</span></div>',
        //         useHTML: true,
        //         floating: true,
        //         // align: 'right',
        //         x: 85,
        //         y: 240,
        //     });
        // }

        // function AC_chart(AC, PC) {
        //     //AC 飯前
        //     //PC 飯後
        //     let AC_chart = $('#AC_chart').highcharts();
        //     let plotLines = [];
        //     let maxvalue;
        //     if (parseInt(AC) >= parseInt(PC)) {
        //         maxvalue = parseInt(AC);
        //         minvalue = parseInt(PC);
        //     } else {
        //         maxvalue = parseInt(PC);
        //         minvalue = parseInt(AC);
        //     }
        //     if(parseInt(AC_chart.yAxis[0].dataMax) >= maxvalue) {
        //         max = parseInt(AC_chart.yAxis[0].dataMax);
        //     }else{
        //         max = maxvalue + 8;
        //     }
        //     if(parseInt(AC_chart.yAxis[0].dataMin) >= minvalue) {
        //         min = minvalue - 8 ;
        //     }else{
        //         min = parseInt(AC_chart.yAxis[0].dataMin);
        //     }
        //     AC_chart.yAxis[0].setExtremes(min, max);
        //     plotLines.push(AC_chart.yAxis[0].addPlotLine({
        //         value: AC,
        //         color: 'red',
        //         width: 2,
        //         dashStyle: 'ShortDash'
        //     }));
        //     plotLines.push(AC_chart.yAxis[0].addPlotLine({
        //         value: PC,
        //         color: 'red',
        //         width: 2,
        //         dashStyle: 'ShortDash'
        //     }));
        //     AC_chart.setTitle(null, {
        //         text: '<div class="ml-2" style="font-size:16px;width:100%;height:100%"><i class="fa fa-ellipsis-h ml-3 mr-2" aria-hidden="true" style="color:#FF0000;"></i><span class="icondash" style="color:black;font-size:10px">數值目標線</span></div>',
        //         useHTML: true,
        //         floating: true,
        //         // align: 'right',
        //         x: 80,
        //         y: 240,
        //     });
        // }


        // function Ecg_chart() {
        //     let Ecg_chart = $('#Ecg_chart').highcharts();
        //     plotLines.push(Ecg_chart.yAxis[0].addPlotLine({
        //         value: 120,
        //         color: 'red',
        //         width: 1,
        //     }));
        // }
    });
    window.onbeforeprint = function() {
        document.body.style.background = "url('../../assets/img/backgroundimage7.png') no-repeat center center fixed";
        };

    $("#print").click(function() {
        var bp_chart = $('#bp_chart').highcharts();
        var AC_chart = $('#AC_chart').highcharts();
        var PC_chart = $('#PC_chart').highcharts();
        var Ecg_chart = $('#Ecg_chart').highcharts();

        // 如果图表存在且有数据，调整尺寸
        bp_chart.setSize(800, 210, false);
        AC_chart.setSize(800, 210, false);
        PC_chart.setSize(800, 210, false);
        Ecg_chart.setSize(800, 210, false);
        bp_chart.setSize(null, null);
        AC_chart.setSize(null, null);
        PC_chart.setSize(null, null);
        Ecg_chart.setSize(null, null);
        window.print();
        
    });
</script>
</body>

</html>
