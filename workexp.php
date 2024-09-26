<?php 
include("./models/config.php");
include("./models/nace/kpi.php");
$kpi_data = json_decode($kpi, true); // 'true' makes it return an array

$total_student_responses = $kpi_data['total_student_responses'];
$total_students = $kpi_data['total_students'];
$average_duration = $kpi_data['average_duration'];

if(is_numeric($average_duration[0])){
    $minutes = floor($average_duration[0] / 60);
    $seconds = $average_duration[0] % 60;        
}
else{
    $minutes = 0;
    $seconds = 0;
}
//     header('Location: nodata.php');
//     die();
// }
    
include("./models/nace/competency.php");
// $competency = json_decode($comp, true);
// echo "<pre>$comp</pre>";


// Decode JSON into a PHP associative array
$comp_data = json_decode($comp, true);

include("./models/nace/competency_questions.php");
// echo "<pre>$comp_q</pre>";
$comp_q_data = json_decode($comp_q, true);

include("./models/common/work_experience.php");
// echo "<pre>$comp_q</pre>";
// $comp_q_data = json_decode($comp_q, true);

$work_data = json_decode($work, true);

// echo json_encode($work_data['Experiential Learning Type']['percentages']);

include("./models/common/demographics.php");
$demo_data = json_decode($demo, true);

$dataArray = json_decode($demo, true);

$formattedData = [];

foreach ($dataArray as $question => $details) {
    $formattedData['data'] = []; 
    
    foreach ($details['values'] as $index => $value) {
        $formattedData['data'][] = [
            'y' => $value,
            'per' => intval($details['percentages'][$index])
        ];
    }
    $dataArray[$question]['formatted_data'] = $formattedData['data'];
}
$updatedJson = json_encode($dataArray, JSON_PRETTY_PRINT);

// echo "<pre>$updatedJson</pre>";

$dataArray = json_decode($updatedJson, true);

// echo json_encode($dataArray['Which of the following categories would you use to best describe yourself?']['formatted_data']);

?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Career Readiness Inventory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Career Readiness Inventory" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- jquery.vectormap css -->
    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="assets/libs/morris.js/morris.css">

    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- <link href="assets/css/neumorphism.css" rel="stylesheet" type="text/css" /> -->

    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom-css.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>


    <style>
    .grid1 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: 1fr;
        grid-column-gap: 16px;
        grid-row-gap: 0px;
    }

    .grid1child {
        grid-area: 1 / 1 / 2 / 5;
    }

    .highcharts-credits {
        display: none !important;
    }

    .pie-text {
        font-size: 19.2px;
        font-weight: bold;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
    }

    .apexcharts-tooltip-y-group {
        background-color: white !important;
        /* Custom background color */
        color: Black !important;
        /* Custom text color */
    }

    .apexcharts-tooltip-series-group {
        background-color: white !important;
        border: black 2px;
    }

    .ruler {
        position: relative;
        width: 100%;
        height: 2px;
        background-color: #eaeaea;
        border: 1px solid #000;
    }

    .tick {
        position: absolute;
        width: 3.5px;
        height: 17px;
        margin-top: -8px;
        background-color: #000;
    }

    .tick:nth-child(1) {
        left: -1px;
    }

    .tick:nth-child(2) {
        left: 25%;
    }

    .tick:nth-child(3) {
        left: 50%;
    }

    .tick:nth-child(4) {
        left: 75%;
    }


    .tick:nth-child(5) {
        left: 100%;
        margin-left: -1px;
        /* Adjust to center the last tick */
    }

    .digit-ruler {
        position: relative;
        width: 99%;
        height: 2px;
        /* opacity: 0; */
    }

    .digit {
        position: absolute;
        text-align: center;
        margin-top: -8px;
        font-weight: bolder;
        color: black;
    }

    .digit:nth-child(1) {
        left: -5px;
    }

    .digit:nth-child(2) {
        left: 25%;
    }

    .digit:nth-child(3) {
        left: 50%;
    }

    .digit:nth-child(4) {
        left: 75%;
    }

    .digit:nth-child(5) {
        left: 100%;
        margin-left: -1px;
        /* Adjust to center the last tick */
    }



    .shimmer-animation {
        background: linear-gradient(-45deg, #eee 40%, #fafafa 50%, #eee 60%);
        /* add the following line: */
        background-attachment: fixed;
        background-size: 300%;
        animation-name: shimmer;
        animation-duration: 1000ms;
        animation-timing-function: linear;
        animation-delay: 0;
        animation-iteration-count: infinite;
        animation-direction: normal;
        animation-fill-mode: none;
        animation-play-state: running;
    }

    @keyframes shimmer {
        0% {
            background-position-x: 100%;
        }

        100% {
            background-position-x: 0%;
        }
    }

    select {
        color: #000033 !important;
    }

    #SvgjsText1111 {
        fill: #12171dbf !important;
    }

    #SvgjsText1124 {
        fill: #12171dbf !important;
    }

    #SvgjsText1150 {
        fill: #12171dbf !important;
    }

    #SvgjsText1163 {
        fill: #12171dbf !important;
    }

    #SvgjsG1136 {
        fill: #12171dbf !important;
    }

    #SvgjsG1175 {
        fill: #12171dbf !important;
    }
    </style>
</head>

<body data-sidebar="dark" style="background-color:#dadadd59">

    <!-- <body data-layout="horizontal" data-topbar="light"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->

        <div class="container px-4">

            <nav class="navbar navbar-expand-lg navbar-dark py-2 px-3"
                style="border-radius: 0px 0px 16px 16px;background-color:#000033!important;">
                <a class="navbar-brand card mt-2" href="#"
                    style="margin-left:20px;padding-bottom:10p;border-radius:8px">
                    <div class="p-3">
                        <img class="img-fluid" src="assets/images/logo.png" style="width: 200px;">
                    </div>
                </a>
                <button class="navbar-toggler mr-5" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 100px;">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="./index.html"
                                style="font-size:18px;color:white!important;">Dashboard
                                <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item" style="margin-left: 100px;">
                            <a class="nav-link" href="./responses.html"
                                style="font-size:18px;color:white!important;">Responses</a>
                        </li>
                    </ul>
                    <select class="form-select bg-light" style="width:20%;margin-left:45%">
                        <option> All </option>
                        <option selected>This Week</option>
                        <option>This Month</option>
                        <option>This year</option>
                    </select>

                    <!-- <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form> -->
                </div>
            </nav>

            <div class="page-content" style="padding-top: 27px!important;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center" style="height: 86%;">
                                <div class="card-body" style="height: 100%;align-content: center;">
                                    <!-- <h4 class="card-title text-muted">Total Subscription</h4> -->
                                    <!-- <span class="logo-lg"> -->
                                    <img src="assets/images/asu.png" alt="logo-dark"
                                        style="object-fit: cover;width: 75%;">
                                    <!-- </span> -->
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center">
                                <div class="card-body p-t-10">
                                    <h4 class="card-title text-muted mb-0">Students</h4>
                                    <h2 class="mt-3 mb-2"><i class="mdi mdi-arrow-up text-success me-2"></i><b>
                                            <?=$total_students[0]?> </b></h2>
                                    <p class="mb-0 text-black mt-3"><b><?=$total_students[1]?>%</b>
                                        from Last Week</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center">
                                <div class="card-body p-t-10">
                                    <h4 class="card-title text-muted mb-0">Responses</h4>
                                    <h2 class="mt-3 mb-2"><i class="mdi mdi-arrow-up text-success me-2"></i><b>
                                            <?=$total_student_responses[0]?></b></h2>
                                    <p class="mb-0 text-black mt-3"><b> <?=$total_student_responses[1]?>%</b>
                                        from Last Week</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card text-center">
                                <div class="card-body p-t-10">
                                    <h4 class="card-title text-muted mb-0">Average
                                        Duration</h4>
                                    <h2 class="mt-3 mb-2"><i class="mdi mdi-arrow-down text-danger me-2"></i><b>
                                            <?=$minutes?> min <?=$seconds?>s </b>
                                    </h2>
                                    <p class="mb-0 text-black mt-3"><b><?=$average_duration[1]?>%</b>
                                        from Last Week</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="row mb-3" style="border-radius: 16px;background-color:#000033!important;">
                        <!-- <div class="col-sm-12">
                            <a href="#" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center"> <i
                                    class="mdi mdi-filter-variant"
                                    style="color:white;width:50px;float:right;font-size:24px"></i> </a>
                        </div> -->
                        <div class="col col-lg-3 p-5">
                            <center>
                                <h5 class="mb-2 text-white" style="font-size:20px">Data Type</h5>
                                <br>
                                <select class="form-select select-light" style="border-radius: 20px;">
                                    <option> NACE Competencies</option>
                                    <option> Plus Competencies </option>
                                    <option> Work Experience </option>
                                </select>
                                <select class="form-select select-light mt-3" style="border-radius: 20px;">
                                    <option> Student:
                                        Pre-Experience</option>
                                    <option> Student: Post-Experience
                                    </option>
                                    <option> Student: Pre vs. Post </option>
                                    <option> Evaluator vs. Student (Post)
                                    </option>
                                </select>
                            </center>
                        </div>
                        <div class="col col-lg-3 p-5">
                            <center>
                                <h5 class="text-white mb-2" style="font-size:20px">Implementation
                                    Type</h5> <br>
                                <select class="form-select select-light" style="border-radius: 20px;">
                                    <option selected disabled> Student
                                        Cohort
                                    </option>
                                    <option> All Data </option>
                                    <option> Cohort </option>
                                    <option> General </option>
                                </select>
                                <div class="d-flex">
                                    <div class="col-sm-6">
                                        <select class="form-select select-light mt-3" style="border-radius: 20px;">
                                            <option selected disabled>
                                                All Time
                                            </option>
                                            <option> Spring 24 </option>
                                            <option> Fall 24</option>
                                            <option> Fall 25 </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-select select-light mt-3" style="border-radius: 20px;">
                                            <option selected disabled> All
                                                Student Cohort
                                            </option>
                                            <option> Lead
                                                Cohort </option>
                                            <option> IVC Cohort</option>
                                            <option> ISS Cohort </option>
                                            <option> Department C </option>
                                            <option disabled> Embedded
                                                Courses</option>
                                            <option> BUSN 79 </option>
                                            <option> CSCI 10 </option>
                                            <option> COEN 42 </option>
                                            <option disabled> General
                                            </option>
                                            <option> Orientation - Class of
                                                2028 </option>
                                            <option> Welcome Meeting
                                                Orientation - Class of 2027
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </center>
                        </div>
                        <div class="col col-lg-3 p-5">
                            <center>
                                <h5 class="text-white mb-2" style="font-size:20px">Academic
                                    Level</h5>
                                <br>
                                <select class="form-select select-light" style="border-radius: 20px;">
                                    <option> Bachelor's - 1st Year </option>
                                    <option> Bachelor's - 2nd Year </option>
                                    <option> Bachelor's - 3rd Year </option>
                                    <option> Bachelor's - 4th Year </option>
                                    <option> Bachelor's - 5th Year or beyond
                                    </option>
                                    <option> Masters </option>
                                    <option> Doctoral </option>
                                    <option disabled> OR </option>
                                    <option> Certificate Program </option>
                                    <option> Associate - 1st Year </option>
                                    <option> Associate - 2nd Year </option>
                                    <option> Associate 3rd Year or beyond
                                    </option>
                                </select>
                            </center>
                        </div>
                        <div class="col col-lg-3 p-5">
                            <center>
                                <h5 class="text-white mb-2" style="font-size:20px">Demographic
                                    Group</h5> <br>
                                <select class="form-select select-light" style="border-radius: 20px;">
                                    <option> All Students </option>
                                    <option> First Gen Students </option>
                                    <option> International Students
                                    </option>
                                    <option disabled>
                                        ----------------------- </option>
                                    <option disabled> CUSTOM GROUPS
                                    </option>
                                    <option> Group A </option>
                                    <option> Group B </option>
                                    <option> Group C </option>
                                </select>
                                <button type="button" class="btn bg-white p-2 mt-3 rounded-circle btn-lg"
                                    data-bs-toggle="modal" data-bs-target=".bs-example-modal-center"
                                    style="height: 45px; font-size: 25px; width: 45px; line-height: 112%; color: #000032;"><i
                                        class="fa fa-plus"></i>
                                </button>
                            </center>
                        </div>
                        <div class="col col-lg-12">
                            <hr style="background-color:white;margin-top:-20px;margin-bottom:20px">
                            <center>
                                <button type="button" class="btn bg-white p-2 mb-3"
                                    style="line-height: 112%; color: #000032;border-radius:20px;">Apply
                                    Filters
                                </button>
                            </center>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 px-0">
                            <div class="card">
                                <div class="card-body">
                                    <!-- <div class="card"> -->
                                    <div class="card-body">
                                        <h5 class="card-title text-black mb-5">
                                            Overall Career Readiness
                                        </h5>
                                        <div class="row mt-3" style="width:94%;margin:auto">
                                            <div class="col-lg-3">
                                                <div class="card upcard border-2 d-flex align-content-center flex-wrap">
                                                    <!-- <div class="card body"> -->
                                                    <div class="text-center" dir="ltr">
                                                        <h4 class="font-size-18 mb-3 mt-3" style="font-weight:700">
                                                            Emerging
                                                            Knowledge</h4>

                                                        <div class="gauge-container" style="margin-left: 15px;">
                                                            <svg class="gauge" viewBox="-2 -2 50 50">
                                                                <!-- Updated viewBox -->
                                                                <path class="gauge-background" d="M21 2.1
                                                                        a 18.9 18.9 0 0 1 0 37.8
                                                                        a 18.9 18.9 0 0 1 0 -37.8" />
                                                                <path id="gauge-emerging-foreground"
                                                                    class="gauge-foreground gauge-emerging" d="M21 2.1
                                                                        a 18.9 18.9 0 0 1 0 37.8
                                                                        a 18.9 18.9 0 0 1 0 -37.8" />
                                                                <text x="22" y="21" class="gauge-percentage"
                                                                    id="gauge-emerging-percentage"
                                                                    style="font-size: 0.7em;font-weight: 700;color: #343A40">0%</text>
                                                            </svg>
                                                        </div>

                                                        <!-- <input class="knob " data-width="150" data-min="0" data-max="4"
                                                            data-readOnly=true data-fgcolor="#008ffb" -->
                                                        <!-- data-displayprevious="true" value="1"> -->
                                                        <h5 class="font-size-16 mb-3" style>
                                                            <?= intval($comp_data['overall_career_readiness_results']['Emerging Knowledge'][1]) ?>
                                                            Students
                                                        </h5>
                                                    </div>
                                                </div>
                                                <!-- </div> -->

                                            </div>
                                            <div class="col-lg-3">
                                                <div class="card upcard border-2 d-flex align-content-center flex-wrap">
                                                    <div class="text-center" dir="ltr">
                                                        <h4 class="font-size-18 mb-3 mt-3" style="font-weight:700">
                                                            Understanding
                                                        </h4>

                                                        <div class="gauge-container" style="margin-left: 15px;">
                                                            <svg class="gauge" viewBox="-2 -2 50 50">
                                                                <!-- Updated viewBox -->
                                                                <path class="gauge-background" d="M21 2.1
                                                                        a 18.9 18.9 0 0 1 0 37.8
                                                                        a 18.9 18.9 0 0 1 0 -37.8" />
                                                                <path id="gauge-understanding-foreground"
                                                                    class="gauge-foreground gauge-understanding" d="M21 2.1
                                                                        a 18.9 18.9 0 0 1 0 37.8
                                                                        a 18.9 18.9 0 0 1 0 -37.8" />
                                                                <text x="22" y="21" class="gauge-percentage"
                                                                    id="gauge-understanding-percentage"
                                                                    style="font-size: 0.7em;font-weight: 700;color: #343A40">0%</text>
                                                            </svg>
                                                        </div>

                                                        <!-- <input class="knob" data-width="150" data-min="0" data-max="4"
                                                            data-readOnly=true data-fgcolor="#00e396"
                                                            data-displayprevious="true" value="2"> -->
                                                        <h5 class="font-size-16 mb-3">
                                                            <?= intval($comp_data['overall_career_readiness_results']['Understanding'][1]) ?>
                                                            Students</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="card upcard border-2 d-flex align-content-center flex-wrap">
                                                    <div class="text-center" dir="ltr">
                                                        <h4 class="font-size-18 text-black mb-3 mt-3"
                                                            style="font-weight:700">
                                                            Early
                                                            Application
                                                        </h4>
                                                        <div class="gauge-container" style="margin-left: 15px;">
                                                            <svg class="gauge" viewBox="-2 -2 50 50">
                                                                <!-- Updated viewBox -->
                                                                <path class="gauge-background" d="M21 2.1
                                                                        a 18.9 18.9 0 0 1 0 37.8
                                                                        a 18.9 18.9 0 0 1 0 -37.8" />
                                                                <path id="gauge-early-foreground"
                                                                    class="gauge-foreground gauge-early" d="M21 2.1
                                                                        a 18.9 18.9 0 0 1 0 37.8
                                                                        a 18.9 18.9 0 0 1 0 -37.8" />
                                                                <text x="22" y="21" class="gauge-percentage"
                                                                    id="gauge-early-percentage"
                                                                    style="font-size: 0.7em;font-weight: 700;color: #343A40">0%</text>
                                                            </svg>
                                                        </div>

                                                        <h5 class="font-size-16 text-black mb-3">
                                                            <?= intval($comp_data['overall_career_readiness_results']['Early Application'][1]) ?>
                                                            Students</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div
                                                    class="card upcard border-2 d-flex justify-content-between flex-wrap">
                                                    <div class="text-center" dir="ltr">
                                                        <h4 class="font-size-18 mb-3 mt-3" style="font-weight:700">
                                                            Advanced
                                                            Application
                                                        </h4>
                                                        <div class="gauge-container" style="margin-left: 45px;">
                                                            <svg class="gauge" viewBox="-2 -2 50 50">
                                                                <!-- Updated viewBox -->
                                                                <path class="gauge-background" d="M21 2.1
                                                                        a 18.9 18.9 0 0 1 0 37.8
                                                                        a 18.9 18.9 0 0 1 0 -37.8" />
                                                                <path id="gauge-advanced-foreground"
                                                                    class="gauge-foreground gauge-advanced" d="M21 2.1
                                                                        a 18.9 18.9 0 0 1 0 37.8
                                                                        a 18.9 18.9 0 0 1 0 -37.8" />
                                                                <text x="22" y="21" class="gauge-percentage"
                                                                    id="gauge-advanced-percentage"
                                                                    style="font-size: 0.7em;font-weight: 700;color: #343A40">0%</text>
                                                            </svg>
                                                        </div>

                                                        <h5 class="font-size-16 text-black mb-3">
                                                            <?= intval($comp_data['overall_career_readiness_results']['Advanced Application'][1]) ?>
                                                            Students</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="px-3 mt-4" style="width:97%;margin:auto">
                                            <div
                                                style="margin-left:<?= $comp_data['overall_career_readiness_results']['Average'] - 2 ?>%!important;margin-top:-5px!important">
                                                <b class="font-size-16 text-black">Average</b>
                                            </div>

                                            <div class="ruler mt-4">
                                                <div class="tick"></div>
                                                <div class="tick"></div>
                                                <div class="tick"></div>
                                                <div class="tick"></div>
                                                <div class="tick"></div>
                                            </div>

                                            <div class="progress-value bg-warning text-black"
                                                style="position:absolute;left:<?= $comp_data['overall_career_readiness_results']['Average'] + 2 ?>%!important;font-size:20px">
                                                <?= intval($comp_data['overall_career_readiness_results']['Average']) ?>
                                            </div>

                                            <div class="digit-ruler" style="margin-top:15px">
                                                <?php 
                                                $avg = intval($comp_data['overall_career_readiness_results']['Average']);
                                                if($avg == 0)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>0</div>";

                                                    if($avg == 25)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>25</div>";

                                                    if($avg == 50)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>50</div>";

                                                    if($avg == 75)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>75</div>";

                                                    if($avg == 100)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>100</div>";
                                             ?>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal modal-lg fade bs-example-modal-center" tabindex="-1" role="dialog"
                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Filter by
                                        Demographic Group</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-5">
                                    <div class="border-2 row mb-4">
                                        <div class="col-sm-11">
                                            <select class="form-select" style="color:#000032">
                                                <option>Question 1</option>
                                            </select>
                                            <center>
                                                <select class="form-select mt-4 mb-4"
                                                    style="width:20%;border-color: #000032;border-radius: 20px;border:2px solid;color:#000032">
                                                    <option>is equal
                                                        to</option>
                                                    <option>not equal
                                                        to</option>
                                                </select>
                                            </center>
                                            <select class="form-select" style="color:#000032">
                                                <option>Option A</option>
                                                <option>Option B</option>
                                                <option>Option C</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-1">
                                            <a href="#" style="color:red;"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                    <h4 class="text-center mb-4">AND</h4>
                                    <!-- <hr style="color: rgba(108, 108, 108, 0.629);height:1px;opacity:1"> -->
                                    <div class="card p-3 border-2">
                                        <div class=" row mb-4">
                                            <div class="col-sm-11">
                                                <select class="form-select" style="color:#000032">
                                                    <option>Question
                                                        2</option>
                                                </select>
                                                <center>
                                                    <select class="form-select mt-4 mb-4"
                                                        style="width:20%;border-color: #000032;border-radius: 20px;border:2px solid;color:#000032">
                                                        <option>is equal
                                                            to</option>
                                                        <option>not equal
                                                            to</option>
                                                    </select>
                                                </center>
                                                <select class="form-select" style="color:#000032">
                                                    <option>Option
                                                        A</option>
                                                    <option>Option
                                                        B</option>
                                                    <option>Option
                                                        C</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1 align-content-center">
                                                <a href="#" style="color:red;"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <center>
                                        <button type="button"
                                            class="btn p-2 mt-3 rounded-circle btn-lg align-content-center text-center align-items-center"
                                            data-bs-toggle="modal" data-bs-target=".bs-example-modal-center"
                                            style="height: 45px; font-size: 25px; width: 45px; line-height: 112%; color: white;background-color: #000032;"><i
                                                class="fa fa-plus"></i>
                                        </button>
                                    </center>
                                    <!-- <hr style="color: rgba(108, 108, 108, 0.629);"> -->
                                </div>
                                <hr class="mt-5 mb-0" style="color: rgba(108, 108, 108, 0.629);">
                                <div class="py-3 px-3 d-flex justify-content-around">

                                    <button type="button" class="btn btn-secondary">Apply
                                        Filter</button>
                                    <button type="button" class="btn"
                                        style="background-color: #000032;color: white;">Save
                                        Group</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>

                <div class="card p-3">
                    <div class="sticky-top bg-white">
                        <!-- style="position:fixed; top:0; max-width:80%; z-index:100;" -->
                        <div class="row pt-0 mt-3 mb-3">
                            <div class="col-sm-3 align-content-center">
                                <h2 class="mb-0 text-black text-center" style="font-size:20px!important">Career
                                    Readiness Level</h2>
                            </div>
                            <div class="col-sm-8" style="margin:auto">

                                <div class="d-flex justify-content-around" style="width:94%">
                                    <div class=" align-content-center text-black"
                                        style="font-size:16px;margin-left:-18px">
                                        <b>Emerging Knowledge</b>
                                    </div>
                                    <div class="text-center text-black" style="font-size:16px">
                                        <b>Understanding</b>
                                    </div>
                                    <div class="text-center text-black" style="font-size:16px;margin-left:12px">
                                        <b>Early Application</b>
                                    </div>
                                    <div class="text-center text-black" style="font-size:16px">
                                        <b>Advanced
                                            Application</b>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlushExample">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingZero">
                                <button class="accordion-button collapsed btn-up" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseZero" aria-expanded="false"
                                    aria-controls="flush-collapseZero">
                                    <div class="row align-items-center p-0 w-100">
                                        <div
                                            class="col-sm-3 d-flex p-3 mb-0 align-items-center card bg-info align-content-center">
                                            <img class="img-fluid"
                                                src="./assets/images/nace-icons/nace-communication-black-line-art-icon.png"
                                                style="height: 70px;width: 70px;margin: auto;">
                                            <h3 class="px-2 icon-text text-dark mb-0"
                                                style="color: white!important;font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                Communication
                                                <!-- <?= $comp_data['communication_results']['Max'] ?> -->
                                            </h3>
                                        </div>
                                        <div class="col-sm-8 p-3" style="margin-top:20px;margin:auto">
                                            <div class="grid1 mt-1" style="line-height:0;">
                                                <div
                                                    class="align-items-center card bg-primary px-3 py-2 mb-3 <?= $comp_data['communication_results']['Max'] == "Emerging Knowledge" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['communication_results']['Emerging Knowledge'][0]) ?>%
                                                    </h4>
                                                    <p class="icon-text pb-1 text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= $comp_data['communication_results']['Emerging Knowledge'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                                <div
                                                    class="align-items-center card bg-success px-3 py-2 mb-3 <?= $comp_data['communication_results']['Max'] == "Understanding" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['communication_results']['Understanding'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= $comp_data['communication_results']['Understanding'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-warning px-3 py-2 mb-3 <?= $comp_data['communication_results']['Max'] == "Early Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white f-800">
                                                        <?= intval($comp_data['communication_results']['Early Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= $comp_data['communication_results']['Early Application'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-danger px-3 py-2 mb-3 <?= $comp_data['communication_results']['Max'] == "Advanced Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class=" text-white f-800">
                                                        <?= intval($comp_data['communication_results']['Advanced Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            <?= $comp_data['communication_results']['Advanced Application'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-3" style="width:100%;margin:auto">
                                                <div class="ruler mt-4">
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                </div>

                                                <div class="progress-value"
                                                    style="position:absolute;left:<?= $comp_data['communication_results']['Average'] ?>%!important;font-size:20px;background-color:#00A4FE">
                                                    <?= intval($comp_data['communication_results']['Average']) ?>
                                                </div>

                                                <div class="digit-ruler" style="margin-top:15px">
                                                    <?php 
                                                $avg = intval($comp_data['communication_results']['Average']);
                                                if($avg == 0)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>0</div>";

                                                    if($avg == 25)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>25</div>";

                                                    if($avg == 50)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>50</div>";

                                                    if($avg == 75)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>75</div>";

                                                    if($avg == 100)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>100</div>";
                                             ?>

                                                </div>
                                                <div class="mt-2"
                                                    style="margin-left:<?= $comp_data['communication_results']['Average'] - 2 ?>%!important;">
                                                    <b class="font-size-14 text-black">Average</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-collapseZero" class="accordion-collapse collapse"
                                aria-labelledby="flush-flush-collapseZero" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Oral Communication
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['communication']['Oral Communication']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['communication']['Oral Communication']['Emerging Knowledge'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['communication']['Oral Communication']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['communication']['Oral Communication']['Understanding'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['communication']['Oral Communication']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['communication']['Oral Communication']['Early Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['communication']['Oral Communication']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['communication']['Oral Communication']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Written Communication
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['communication']['Written Communication']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['communication']['Written Communication']['Emerging Knowledge'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['communication']['Written Communication']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['communication']['Written Communication']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['communication']['Written Communication']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['communication']['Written Communication']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['communication']['Written Communication']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['communication']['Written Communication']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 mb-0 text-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Non-verbal Communication
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['communication']['Non-verbal Communication']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['communication']['Non-verbal Communication']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['communication']['Non-verbal Communication']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['communication']['Non-verbal Communication']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['communication']['Non-verbal Communication']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['communication']['Non-verbal Communication']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['communication']['Non-verbal Communication']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['communication']['Non-verbal Communication']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 mb-0 text-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Active Listening
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['communication']['Active Listening']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['communication']['Active Listening']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['communication']['Active Listening']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['communication']['Active Listening']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['communication']['Active Listening']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['communication']['Active Listening']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['communication']['Active Listening']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['communication']['Active Listening']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button class="accordion-button collapsed btn-up" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    <div class="row align-items-center p-0 w-100">
                                        <div class="col-sm-3 d-flex p-3 mb-0 align-items-center card align-content-center"
                                            style="background-color: #E06B60;">
                                            <img class="img-fluid"
                                                src="./assets/images/nace-icons/nace-teamwork-black-line-art-icon.png"
                                                style="height: 70px;width: 70px;margin: auto;">
                                            <h3 class="px-2 icon-text text-dark mb-0"
                                                style="color: white!important;font-size:18px!important">
                                                Teamwork </h3>
                                        </div>
                                        <div class="col-sm-8 p-3" style="margin-top:20px;margin:auto">
                                            <div class="grid1 mt-1" style="line-height:0;">
                                                <div
                                                    class="align-items-center card bg-primary px-3 py-2 mb-3 <?= $comp_data['teamwork_results']['Max'] == "Emerging Knowledge" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['teamwork_results']['Emerging Knowledge'][0]) ?>%
                                                    </h4>
                                                    <p class="icon-text pb-1 text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= $comp_data['teamwork_results']['Emerging Knowledge'][1]?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                                <div
                                                    class="align-items-center card bg-success px-3 py-2 mb-3 <?= $comp_data['teamwork_results']['Max'] == "Understanding" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['teamwork_results']['Understanding'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= $comp_data['teamwork_results']['Understanding'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-warning px-3 py-2 mb-3 <?= $comp_data['teamwork_results']['Max'] == "Early Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white f-800">
                                                        <?= intval($comp_data['teamwork_results']['Early Application'][0])?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small> (
                                                            <?= $comp_data['teamwork_results']['Early Application'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-danger px-3 py-2 mb-3 <?= $comp_data['teamwork_results']['Max'] == "Advanced Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class=" text-white f-800">
                                                        <?= intval($comp_data['teamwork_results']['Advanced Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            <?= $comp_data['teamwork_results']['Advanced Application'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-3" style="width:100%;margin:auto">

                                                <div class="ruler mt-4">
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                </div>

                                                <div class="progress-value"
                                                    style="position:absolute;left:<?= $comp_data['teamwork_results']['Average'] ?>%!important;font-size:20px;background-color:#E06B60">
                                                    <?= intval($comp_data['teamwork_results']['Average']) ?>
                                                </div>

                                                <div class="digit-ruler" style="margin-top:15px">
                                                    <?php 
                                                $avg = intval($comp_data['teamwork_results']['Average']);
                                                if($avg == 0)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>0</div>";

                                                    if($avg == 25)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>25</div>";

                                                    if($avg == 50)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>50</div>";

                                                    if($avg == 75)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>75</div>";

                                                    if($avg == 100)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>100</div>";
                                             ?>

                                                </div>

                                                <div class="mt-2"
                                                    style="margin-left:<?= $comp_data['self_development_results']['Average'] - 2 ?>%!important;">
                                                    <b class="font-size-14 text-black">Average</b>
                                                </div>
                                            </div>
                                        </div>
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-flush-collapseTwo" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Build Relationships for
                                                    Collaboration
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['teamwork']['Build Relationships for Collaboration']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Build Relationships for Collaboration']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['teamwork']['Build Relationships for Collaboration']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Build Relationships for Collaboration']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['teamwork']['Build Relationships for Collaboration']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Build Relationships for Collaboration']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['teamwork']['Build Relationships for Collaboration']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Build Relationships for Collaboration']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Respect Diverse
                                                    Perspectives
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['teamwork']['Respect Diverse Perspectives']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Respect Diverse Perspectives']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['teamwork']['Respect Diverse Perspectives']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Respect Diverse Perspectives']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['teamwork']['Respect Diverse Perspectives']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Respect Diverse Perspectives']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['teamwork']['Respect Diverse Perspectives']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Respect Diverse Perspectives']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Integrate Strengths
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['teamwork']['Integrate Strengths']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Integrate Strengths']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['teamwork']['Integrate Strengths']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Integrate Strengths']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['teamwork']['Integrate Strengths']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Integrate Strengths']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['teamwork']['Integrate Strengths']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['teamwork']['Integrate Strengths']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed btn-up" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    <div class="row align-items-center p-0 w-100">
                                        <div
                                            class="col-sm-3 d-flex p-3 mb-0 align-items-center card bg-warning align-content-center">
                                            <img class="img-fluid"
                                                src="./assets/images/nace-icons/nace-career-and-self-development-black-line-art-icon.png"
                                                style="height: 70px;width: 70px;margin: auto;">
                                            <h5 class="px-2 icon-text text-center text-dark mb-0"
                                                style="color: white!important;">
                                                Career & Self Development
                                            </h5>
                                        </div>
                                        <div class="col-sm-8 p-3" style="margin-top:20px;margin:auto">
                                            <div class="grid1 mt-1" style="line-height:0;">
                                                <div
                                                    class="align-items-center card bg-primary px-3 py-2 mb-3 <?= $comp_data['self_development_results']['Max'] == "Emerging Knowledge" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['self_development_results']['Emerging Knowledge'][0]) ?>%
                                                    </h4>
                                                    <p class="icon-text pb-1 text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= $comp_data['self_development_results']['Emerging Knowledge'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                                <div
                                                    class="align-items-center card bg-success px-3 py-2 mb-3 <?= $comp_data['self_development_results']['Max'] == "Understanding" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['self_development_results']['Understanding'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= $comp_data['self_development_results']['Understanding'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-warning px-3 py-2 mb-3 <?= $comp_data['self_development_results']['Max'] == "Early Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white f-800">
                                                        <?= intval($comp_data['self_development_results']['Early Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= $comp_data['self_development_results']['Early Application'][1] ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-danger px-3 py-2 mb-3 <?= $comp_data['self_development_results']['Max'] == "Advanced Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class=" text-white f-800">
                                                        <?= intval($comp_data['self_development_results']['Advanced Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (
                                                            <?= intval($comp_data['self_development_results']['Advanced Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-3" style="width:100%;margin:auto">

                                                <div class="ruler mt-4">
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                </div>

                                                <div class="progress-value bg-warning"
                                                    style="position:absolute;left:<?= $comp_data['self_development_results']['Average'] ?>%!important;font-size:20px;">
                                                    <?= intval($comp_data['self_development_results']['Average']) ?>
                                                </div>

                                                <div class="digit-ruler" style="margin-top:15px">
                                                    <?php 
                                                $avg = intval($comp_data['self_development_results']['Average']);
                                                if($avg == 0)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>0</div>";

                                                    if($avg == 25)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>25</div>";

                                                    if($avg == 50)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>50</div>";

                                                    if($avg == 75)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>75</div>";

                                                    if($avg == 100)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>100</div>";
                                             ?>

                                                </div>

                                                <div class="mt-2"
                                                    style="margin-left:<?= $comp_data['self_development_results']['Average'] - 2 ?>%!important;">
                                                    <b class="font-size-14 text-black">Average</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-flush-collapseOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Awareness of Strengths &
                                                    Challenges
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['self_development']['Awareness of Strengths & Challenges']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['self_development']['Awareness of Strengths & Challenges']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['self_development']['Awareness of Strengths & Challenges']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['self_development']['Awareness of Strengths & Challenges']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['self_development']['Awareness of Strengths & Challenges']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['self_development']['Awareness of Strengths & Challenges']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['self_development']['Awareness of Strengths & Challenges']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['self_development']['Awareness of Strengths & Challenges']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Professional Development
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['self_development']['Professional Development']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['self_development']['Professional Development']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['self_development']['Professional Development']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['self_development']['Professional Development']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['self_development']['Professional Development']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['self_development']['Professional Development']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['self_development']['Professional Development']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['self_development']['Professional Development']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Networking
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['self_development']['Networking']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['self_development']['Networking']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['self_development']['Networking']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['self_development']['Networking']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['self_development']['Networking']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['self_development']['Networking']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['self_development']['Networking']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['self_development']['Networking']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFour">
                                <button class="accordion-button collapsed btn-up" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false"
                                    aria-controls="flush-collapseFour">
                                    <div class="row align-items-center p-0 w-100">
                                        <div class="col-sm-3 d-flex p-3 mb-0 align-items-center card align-content-center"
                                            style="background-color:#609866">
                                            <img class="img-fluid"
                                                src="./assets/images/nace-icons/nace-professionalism-black-line-art-icon.png"
                                                style="height: 60px;width: 60px;margin: auto;margin-bottom:6px">
                                            <h5 class="px-2 icon-text text-center text-dark mb-0"
                                                style="color: white!important;">
                                                Professionalism </h5>
                                        </div>
                                        <div class="col-sm-8 p-3" style="margin-top:20px;margin:auto">
                                            <div class="grid1 mt-1" style="line-height:0;">
                                                <div
                                                    class="align-items-center card bg-primary px-3 py-2 mb-3 <?= $comp_data['professionalism_results']['Max'] == "Emerging Knowledge" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['professionalism_results']['Emerging Knowledge'][0]) ?>%
                                                    </h4>
                                                    <p class="icon-text pb-1 text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['professionalism_results']['Emerging Knowledge'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                                <div
                                                    class="align-items-center card bg-success px-3 py-2 mb-3 <?= $comp_data['professionalism_results']['Max'] == "Understanding" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['professionalism_results']['Understanding'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['professionalism_results']['Understanding'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-warning px-3 py-2 mb-3 <?= $comp_data['professionalism_results']['Max'] == "Early Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white f-800">
                                                        <?= intval($comp_data['professionalism_results']['Early Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['professionalism_results']['Early Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-danger px-3 py-2 mb-3 <?= $comp_data['professionalism_results']['Max'] == "Advanced Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class=" text-white f-800">
                                                        <?= intval($comp_data['professionalism_results']['Advanced Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small> (
                                                            <?= intval($comp_data['professionalism_results']['Advanced Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-3" style="width:100%;margin:auto">
                                                <div class="ruler mt-4">
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                </div>

                                                <div class="progress-value"
                                                    style="position:absolute;left:<?= $comp_data['professionalism_results']['Average'] ?>%!important;font-size:20px;background-color:#609866">
                                                    <?= intval($comp_data['professionalism_results']['Average']) ?>
                                                </div>

                                                <div class="digit-ruler" style="margin-top:15px">
                                                    <?php 
                                                $avg = intval($comp_data['professionalism_results']['Average']);
                                                if($avg == 0)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>0</div>";

                                                    if($avg == 25)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>25</div>";

                                                    if($avg == 50)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>50</div>";

                                                    if($avg == 75)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>75</div>";

                                                    if($avg == 100)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>100</div>";
                                             ?>

                                                </div>

                                                <div class="mt-2"
                                                    style="margin-left:<?= $comp_data['professionalism_results']['Average'] - 2 ?>%!important;">
                                                    <b class="font-size-14 text-black">Average</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-collapseFour" class="accordion-collapse collapse"
                                aria-labelledby="flush-flush-collapseFour" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Act With Integrity
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['professionalism']['Act With Integrity']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Act With Integrity']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['professionalism']['Act With Integrity']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Act With Integrity']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['professionalism']['Act With Integrity']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Act With Integrity']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['professionalism']['Act With Integrity']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Act With Integrity']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Demonstrate
                                                    Dependability
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['professionalism']['Demonstrate Dependability']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Demonstrate Dependability']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['professionalism']['Demonstrate Dependability']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Demonstrate Dependability']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['professionalism']['Demonstrate Dependability']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Demonstrate Dependability']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['professionalism']['Demonstrate Dependability']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Demonstrate Dependability']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Achieve Goals
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['professionalism']['Achieve Goals']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Achieve Goals']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['professionalism']['Achieve Goals']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Achieve Goals']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['professionalism']['Achieve Goals']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Achieve Goals']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['professionalism']['Achieve Goals']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['professionalism']['Achieve Goals']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingFive">
                                <button class="accordion-button collapsed btn-up" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false"
                                    aria-controls="flush-collapseFive">
                                    <div class="row align-items-center p-0 w-100">
                                        <div class="col-sm-3 d-flex p-3 mb-0 align-items-center card align-content-center"
                                            style="background-color:#796258">
                                            <img class="img-fluid"
                                                src="./assets/images/nace-icons/nace-leadership-black-line-art-icon.png"
                                                style="height: 60px;width: 60px;margin: auto;margin-bottom:7px">
                                            <h5 class="px-2 icon-text text-center text-dark mb-0"
                                                style="color: white!important;">
                                                Leadership </h5>
                                        </div>
                                        <div class="col-sm-8 p-3" style="margin-top:20px;margin:auto">
                                            <div class="grid1 mt-1" style="line-height:0;">
                                                <div
                                                    class="align-items-center card bg-primary px-3 py-2 mb-3 <?= $comp_data['leadership_results']['Max'] == "Emerging Knowledge" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['leadership_results']['Emerging Knowledge'][0]) ?>%
                                                    </h4>
                                                    <p class="icon-text pb-1 text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['leadership_results']['Emerging Knowledge'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                                <div
                                                    class="align-items-center card bg-success px-3 py-2 mb-3 <?= $comp_data['leadership_results']['Max'] == "Understanding" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['leadership_results']['Understanding'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['leadership_results']['Understanding'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-warning px-3 py-2 mb-3 <?= $comp_data['leadership_results']['Max'] == "Early Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white f-800">
                                                        <?= intval($comp_data['leadership_results']['Early Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['leadership_results']['Early Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-danger px-3 py-2 mb-3 <?= $comp_data['leadership_results']['Max'] == "Advanced Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class=" text-white f-800">
                                                        <?= intval($comp_data['leadership_results']['Advanced Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>(
                                                            <?= intval($comp_data['leadership_results']['Advanced Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-3" style="width:100%;margin:auto">
                                                <div class="ruler mt-4">
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                </div>

                                                <div class="progress-value"
                                                    style="position:absolute;left:<?= $comp_data['leadership_results']['Average'] ?>%!important;font-size:20px;background-color:#796258">
                                                    <?= intval($comp_data['leadership_results']['Average']) ?>
                                                </div>

                                                <div class="digit-ruler" style="margin-top:15px">
                                                    <?php 
                                                $avg = intval($comp_data['leadership_results']['Average']);
                                                if($avg == 0)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>0</div>";

                                                    if($avg == 25)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>25</div>";

                                                    if($avg == 50)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>50</div>";

                                                    if($avg == 75)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>75</div>";

                                                    if($avg == 100)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>100</div>";
                                             ?>

                                                </div>

                                                <div class="mt-2"
                                                    style="margin-left:<?= $comp_data['leadership_results']['Average'] - 2 ?>%!important;">
                                                    <b class="font-size-14 text-black">Average</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                        </div>
                        <div id="flush-collapseFive" class="accordion-collapse collapse"
                            aria-labelledby="flush-flush-collapseFive" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="card upcard border-2">
                                    <div class="row w-100 align-items-center">
                                        <div class="col-sm-3 text-center mb-0 align-content-center">
                                            <p class="px-2 icon-text text-dark mb-0"
                                                style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                Inspire, Persuade, &
                                                Motivate
                                            </p>
                                        </div>
                                        <div class="col-sm-8" style="margin:auto">
                                            <div class="grid1 mt-4 mb-4"
                                                style="grid-column-gap : 8px;margin-left:-16px">
                                                <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['leadership']['Inspire, Persuade, & Motivate']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['leadership']['Inspire, Persuade, & Motivate']['Emerging Knowledge'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-success p-1 <?= $comp_q_data['leadership']['Inspire, Persuade, & Motivate']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>
" style="width:80%;margin:auto;">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['leadership']['Inspire, Persuade, & Motivate']['Understanding'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['leadership']['Inspire, Persuade, & Motivate']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:9px">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['leadership']['Inspire, Persuade, & Motivate']['Early Application'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['leadership']['Inspire, Persuade, & Motivate']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:3px">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['leadership']['Inspire, Persuade, & Motivate']['Advanced Application'][0]); ?>%
                                                    </h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card upcard border-2">
                                    <div class="row w-100 align-items-center">
                                        <div class="col-sm-3 text-center mb-0 align-content-center">
                                            <p class="px-2 icon-text text-dark mb-0"
                                                style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                Engage Various Resources &
                                                Seek Feedback
                                            </p>
                                        </div>
                                        <div class="col-sm-8" style="margin:auto">
                                            <div class="grid1 mt-4 mb-4"
                                                style="grid-column-gap : 8px;margin-left:-16px">
                                                <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['leadership']['Engage Various Resources & Seek Feedback']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['leadership']['Engage Various Resources & Seek Feedback']['Emerging Knowledge'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-success p-1 <?= $comp_q_data['leadership']['Engage Various Resources & Seek Feedback']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['leadership']['Engage Various Resources & Seek Feedback']['Understanding'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['leadership']['Engage Various Resources & Seek Feedback']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:9px">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['leadership']['Engage Various Resources & Seek Feedback']['Early Application'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['leadership']['Engage Various Resources & Seek Feedback']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:3px">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['leadership']['Engage Various Resources & Seek Feedback']['Advanced Application'][0]); ?>%
                                                    </h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card upcard border-2">
                                    <div class="row w-100 align-items-center">
                                        <div class="col-sm-3 text-center mb-0 align-content-center">
                                            <p class="px-2 icon-text text-dark mb-0"
                                                style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                Facilitate Group Dynamics
                                            </p>
                                        </div>
                                        <div class="col-sm-8" style="margin:auto">
                                            <div class="grid1 mt-4 mb-4"
                                                style="grid-column-gap : 8px;margin-left:-16px">
                                                <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['leadership']['Facilitate Group Dynamics']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['leadership']['Facilitate Group Dynamics']['Emerging Knowledge'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-success p-1 <?= $comp_q_data['leadership']['Facilitate Group Dynamics']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['leadership']['Facilitate Group Dynamics']['Understanding'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['leadership']['Facilitate Group Dynamics']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:9px">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['leadership']['Facilitate Group Dynamics']['Early Application'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['leadership']['Facilitate Group Dynamics']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:3px">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['leadership']['Facilitate Group Dynamics']['Advanced Application'][0]); ?>%
                                                    </h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSix">
                                <button class="accordion-button collapsed btn-up" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false"
                                    aria-controls="flush-collapseSix">
                                    <div class="row align-items-center p-0 w-100">
                                        <div class="col-sm-3 d-flex p-3 mb-0 align-items-center card align-content-center"
                                            style="background-color:#705181">
                                            <img class="img-fluid"
                                                src="./assets/images/nace-icons/nace-critical-thinking-black-line-art-icon.png"
                                                style="height: 70px;width: 70px;margin: auto;">
                                            <h5 class="px-2 icon-text text-center text-dark mb-0"
                                                style="color: white!important;">
                                                Critical Thinking </h5>
                                        </div>
                                        <div class="col-sm-8 p-3" style="margin-top:20px;margin:auto">
                                            <div class="grid1 mt-1" style="line-height:0;">
                                                <div
                                                    class="align-items-center card bg-primary px-3 py-2 mb-3 <?= $comp_data['critical_thinking_results']['Max'] == "Emerging Knowledge" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['critical_thinking_results']['Emerging Knowledge'][0]) ?>%
                                                    </h4>
                                                    <p class="icon-text pb-1 text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small> (
                                                            <?= intval($comp_data['critical_thinking_results']['Emerging Knowledge'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                                <div
                                                    class="align-items-center card bg-success px-3 py-2 mb-3 <?= $comp_data['critical_thinking_results']['Max'] == "Understanding" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['critical_thinking_results']['Understanding'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small> (
                                                            <?= intval($comp_data['critical_thinking_results']['Understanding'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-warning px-3 py-2 mb-3 <?= $comp_data['critical_thinking_results']['Max'] == "Early Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white f-800">
                                                        <?= intval($comp_data['critical_thinking_results']['Early Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small> (
                                                            <?= intval($comp_data['critical_thinking_results']['Early Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-danger px-3 py-2 mb-3 <?= $comp_data['critical_thinking_results']['Max'] == "Advanced Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class=" text-white f-800">
                                                        <?= intval($comp_data['critical_thinking_results']['Advanced Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small> (
                                                            <?= intval($comp_data['critical_thinking_results']['Advanced Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-3" style="width:100%;margin:auto">
                                                <div class="ruler mt-4">
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                </div>

                                                <div class="progress-value"
                                                    style="position:absolute;left:<?= $comp_data['critical_thinking_results']['Average'] ?>%!important;font-size:20px;background-color:#705181">
                                                    <?= intval($comp_data['critical_thinking_results']['Average']) ?>
                                                </div>

                                                <div class="digit-ruler" style="margin-top:15px">
                                                    <?php 
                                                $avg = intval($comp_data['critical_thinking_results']['Average']);
                                                if($avg == 0)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>0</div>";

                                                    if($avg == 25)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>25</div>";

                                                    if($avg == 50)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>50</div>";

                                                    if($avg == 75)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>75</div>";

                                                    if($avg == 100)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>100</div>";
                                             ?>

                                                </div>

                                                <div class="mt-2"
                                                    style="margin-left:<?= $comp_data['critical_thinking_results']['Average'] - 2 ?>%!important;">
                                                    <b class="font-size-14 text-black">Average</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                        </div>

                        <div id="flush-collapseSix" class="accordion-collapse collapse"
                            aria-labelledby="flush-flush-collapseSix" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">

                                <div class="card upcard border-2">
                                    <div class="row w-100 align-items-center">
                                        <div class="col-sm-3 text-center mb-0 align-content-center">
                                            <p class="px-2 icon-text text-dark mb-0"
                                                style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                Display Situational
                                                Awareness
                                            </p>
                                        </div>
                                        <div class="col-sm-8" style="margin:auto">
                                            <div class="grid1 mt-4 mb-4"
                                                style="grid-column-gap : 8px;margin-left:-16px">
                                                <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['critical_thinking']['Display Situational Awareness']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Display Situational Awareness']['Emerging Knowledge'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-success p-1 <?= $comp_q_data['critical_thinking']['Display Situational Awareness']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Display Situational Awareness']['Understanding'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['critical_thinking']['Display Situational Awareness']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:9px">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Display Situational Awareness']['Early Application'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['critical_thinking']['Display Situational Awareness']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:3px">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Display Situational Awareness']['Advanced Application'][0]); ?>%
                                                    </h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card upcard border-2">
                                    <div class="row w-100 align-items-center">
                                        <div class="col-sm-3 text-center mb-0 align-content-center">
                                            <p class="px-2 icon-text text-dark mb-0"
                                                style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                Gather & Analyze Data
                                            </p>
                                        </div>
                                        <div class="col-sm-8" style="margin:auto">
                                            <div class="grid1 mt-4 mb-4"
                                                style="grid-column-gap : 8px;margin-left:-16px">
                                                <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['critical_thinking']['Gather & Analyze Data']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Gather & Analyze Data']['Emerging Knowledge'][0]); ?>%
                                                    </h4>
                                                    <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-success p-1 <?= $comp_q_data['critical_thinking']['Gather & Analyze Data']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Gather & Analyze Data']['Understanding'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['critical_thinking']['Gather & Analyze Data']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:9px">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Gather & Analyze Data']['Early Application'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['critical_thinking']['Gather & Analyze Data']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:3px">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Gather & Analyze Data']['Advanced Application'][0]); ?>%
                                                    </h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card upcard border-2">
                                    <div class="row w-100 align-items-center">
                                        <div class="col-sm-3 text-center mb-0 align-content-center">
                                            <p class="px-2 icon-text text-dark mb-0"
                                                style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                Make Effective & Fair
                                                Decisions
                                            </p>
                                        </div>
                                        <div class="col-sm-8" style="margin:auto">
                                            <div class="grid1 mt-4 mb-4"
                                                style="grid-column-gap : 8px;margin-left:-16px">
                                                <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['critical_thinking']['Make Effective & Fair Decisions']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Make Effective & Fair Decisions']['Emerging Knowledge'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-success p-1 <?= $comp_q_data['critical_thinking']['Make Effective & Fair Decisions']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Make Effective & Fair Decisions']['Understanding'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['critical_thinking']['Make Effective & Fair Decisions']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:9px">
                                                    <h4 class="text-white  mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Make Effective & Fair Decisions']['Early Application'][0]); ?>
                                                        %</h4>
                                                    <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                </div>
                                                <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['critical_thinking']['Make Effective & Fair Decisions']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                    style="width:80%;margin:auto;margin-left:3px">
                                                    <h4 class="text-white mt-2">
                                                        <?= intval($comp_q_data['critical_thinking']['Make Effective & Fair Decisions']['Advanced Application'][0]); ?>%
                                                    </h4>
                                                    <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingSeven">
                                <button class="accordion-button collapsed btn-up" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven"
                                    aria-expanded="false" aria-controls="flush-collapseSeven">
                                    <div class="row align-items-center p-0 w-100">
                                        <div class="col-sm-3 d-flex p-3 mb-0 align-items-center card align-content-center"
                                            style="background-color:#3c4b6c">
                                            <img class="img-fluid"
                                                src="./assets/images/nace-icons/nace-technology-black-line-art-icon.png"
                                                style="height: 70px;width: 70px;margin: auto;">
                                            <h5 class="px-2 icon-text text-center text-dark mb-0"
                                                style="color: white!important;">
                                                Technology </h5>
                                        </div>
                                        <div class="col-sm-8 p-3" style="margin-top:20px;margin:auto">
                                            <div class="grid1 mt-1" style="line-height:0;">
                                                <div
                                                    class="align-items-center card bg-primary px-3 py-2 mb-3 <?= $comp_data['technology_results']['Max'] == "Emerging Knowledge" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['technology_results']['Emerging Knowledge'][0]) ?>%
                                                    </h4>
                                                    <p class="icon-text pb-1 text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['technology_results']['Emerging Knowledge'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                                <div
                                                    class="align-items-center card bg-success px-3 py-2 mb-3 <?= $comp_data['technology_results']['Max'] == "Understanding" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['technology_results']['Understanding'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['technology_results']['Understanding'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-warning px-3 py-2 mb-3 <?= $comp_data['technology_results']['Max'] == "Early Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white f-800">
                                                        <?= intval($comp_data['technology_results']['Early Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['technology_results']['Early Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-danger px-3 py-2 mb-3 <?= $comp_data['technology_results']['Max'] == "Advanced Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class=" text-white f-800">
                                                        <?= intval($comp_data['technology_results']['Advanced Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small> (
                                                            <?= intval($comp_data['technology_results']['Advanced Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-3" style="width:100%;margin:auto">
                                                <div class="ruler mt-4">
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                </div>

                                                <div class="progress-value"
                                                    style="position:absolute;left:<?= $comp_data['technology_results']['Average'] ?>%!important;font-size:20px;background-color:#3C4B6C">
                                                    <?= intval($comp_data['technology_results']['Average']) ?>
                                                </div>

                                                <div class="digit-ruler" style="margin-top:15px">
                                                    <?php 
                                                $avg = intval($comp_data['technology_results']['Average']);
                                                if($avg == 0)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>0</div>";

                                                    if($avg == 25)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>25</div>";

                                                    if($avg == 50)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>50</div>";

                                                    if($avg == 75)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>75</div>";

                                                    if($avg == 100)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>100</div>";
                                             ?>

                                                </div>

                                                <div class="mt-2"
                                                    style="margin-left:<?= $comp_data['technology_results']['Average'] - 2 ?>%!important;">
                                                    <b class="font-size-14 text-black">Average</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-collapseSeven" class="accordion-collapse collapse"
                                aria-labelledby="flush-flush-collapseSeven" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Leverage Technology
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['technology']['Leverage Technology']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['technology']['Leverage Technology']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['technology']['Leverage Technology']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['technology']['Leverage Technology']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['technology']['Leverage Technology']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="box-shadow: 0 0 0 2px #f3f5f6 inset;width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['technology']['Leverage Technology']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['technology']['Leverage Technology']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['technology']['Leverage Technology']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Adapt to New
                                                    Technologies
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['technology']['Adapt to New Technologies']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['technology']['Adapt to New Technologies']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['technology']['Adapt to New Technologies']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['technology']['Adapt to New Technologies']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['technology']['Adapt to New Technologies']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['technology']['Adapt to New Technologies']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['technology']['Adapt to New Technologies']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['technology']['Adapt to New Technologies']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Use Technology Ethically
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['technology']['Use Technology Ethically']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['technology']['Use Technology Ethically']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['technology']['Use Technology Ethically']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['technology']['Use Technology Ethically']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['technology']['Use Technology Ethically']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['technology']['Use Technology Ethically']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['technology']['Use Technology Ethically']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['technology']['Use Technology Ethically']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingEight">
                                <button class="accordion-button collapsed btn-up" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseEight"
                                    aria-expanded="false" aria-controls="flush-collapseEight">
                                    <div class="row align-items-center p-0 w-100">
                                        <div class="col-sm-3 d-flex p-3 mb-0 align-items-center card align-content-center"
                                            style="background-color:#ad3131">
                                            <img class="img-fluid"
                                                src="./assets/images/nace-icons/nace-equity-and-inclusion-black-line-art-icon.png"
                                                style="height: 70px;width: 70px;margin: auto;">
                                            <h5 class="px-2 icon-text text-center text-dark mb-0"
                                                style="color: white!important;">
                                                Equity & Inclusion </h5>
                                        </div>
                                        <div class="col-sm-8 p-3" style="margin-top:20px;margin:auto">
                                            <div class="grid1 mt-1" style="line-height:0;">
                                                <div
                                                    class="align-items-center card bg-primary px-3 py-2 mb-3 <?= $comp_data['equity_results']['Max'] == "Emerging Knowledge" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['equity_results']['Emerging Knowledge'][0]) ?>%
                                                    </h4>
                                                    <p class="icon-text pb-1 text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['equity_results']['Emerging Knowledge'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                                <div
                                                    class="align-items-center card bg-success px-3 py-2 mb-3 <?= $comp_data['equity_results']['Max'] == "Understanding" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white mb-1 f-800">
                                                        <?= intval($comp_data['equity_results']['Understanding'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['equity_results']['Understanding'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-warning px-3 py-2 mb-3 <?= $comp_data['equity_results']['Max'] == "Early Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class="text-white f-800">
                                                        <?= intval($comp_data['equity_results']['Early Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['equity_results']['Early Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>

                                                <div
                                                    class="align-items-center card bg-danger px-3 py-2 mb-3 <?= $comp_data['equity_results']['Max'] == "Advanced Application" ? "border border-dark border-0 max-border max-outline" : '' ?>">
                                                    <h4 class=" text-white f-800">
                                                        <?= intval($comp_data['equity_results']['Advanced Application'][0]) ?>%
                                                    </h4>
                                                    <p class="px-2 pb-1 icon-text text-dark mb-0 f-600"
                                                        style="color: white!important;">
                                                        <small>
                                                            (<?= intval($comp_data['equity_results']['Advanced Application'][1]) ?>
                                                            Students)</small>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="mt-3" style="width:100%;margin:auto">
                                                <div class="ruler mt-4">
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                    <div class="tick"></div>
                                                </div>

                                                <div class="progress-value"
                                                    style="position:absolute;left:<?= $comp_data['equity_results']['Average'] ?>%!important;font-size:20px;background-color:#AD3131">
                                                    <?= intval($comp_data['equity_results']['Average']) ?>
                                                </div>

                                                <div class="digit-ruler" style="margin-top:15px">
                                                    <?php 
                                                $avg = intval($comp_data['equity_results']['Average']);
                                                if($avg == 0)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>0</div>";

                                                    if($avg == 25)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>25</div>";

                                                    if($avg == 50)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>50</div>";

                                                    if($avg == 75)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>75</div>";

                                                    if($avg == 100)
                                                    echo "<div class='digit'></div>";
                                                else
                                                    echo "<div class='digit'>100</div>";
                                             ?>

                                                </div>

                                                <div class="mt-2"
                                                    style="margin-left:<?= $comp_data['equity_results']['Average'] - 2 ?>%!important;">
                                                    <b class="font-size-14 text-black">Average</b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="flush-collapseEight" class="accordion-collapse collapse"
                                aria-labelledby="flush-flush-collapseEight" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Engage Multiple
                                                    Perspectives
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['equity']['Engage Multiple Perspectives']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['equity']['Engage Multiple Perspectives']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['equity']['Engage Multiple Perspectives']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['equity']['Engage Multiple Perspectives']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['equity']['Engage Multiple Perspectives']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['equity']['Engage Multiple Perspectives']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['equity']['Engage Multiple Perspectives']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['equity']['Engage Multiple Perspectives']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Use Inclusive &
                                                    Equitable
                                                    Practices
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['equity']['Use Inclusive & Equitable Practices']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['equity']['Use Inclusive & Equitable Practices']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['equity']['Use Inclusive & Equitable Practices']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['equity']['Use Inclusive & Equitable Practices']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['equity']['Use Inclusive & Equitable Practices']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['equity']['Use Inclusive & Equitable Practices']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['equity']['Use Inclusive & Equitable Practices']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['equity']['Use Inclusive & Equitable Practices']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card upcard border-2">
                                        <div class="row w-100 align-items-center">
                                            <div class="col-sm-3 text-center mb-0 align-content-center">
                                                <p class="px-2 icon-text text-dark mb-0"
                                                    style="font-size: 18px;font-weight: 700;padding-left: 15px!important;">
                                                    Advocate
                                                </p>
                                            </div>
                                            <div class="col-sm-8" style="margin:auto">
                                                <div class="grid1 mt-4 mb-4"
                                                    style="grid-column-gap : 8px;margin-left:-16px">
                                                    <div class="align-items-center card bg-primary p-1 <?= $comp_q_data['equity']['Advocate']['Max'][1] == "Emerging Knowledge" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['equity']['Advocate']['Emerging Knowledge'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (100 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-success p-1 <?= $comp_q_data['equity']['Advocate']['Max'][1] == "Understanding" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['equity']['Advocate']['Understanding'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (50 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-warning p-1 <?= $comp_q_data['equity']['Advocate']['Max'][1] == "Early Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:9px">
                                                        <h4 class="text-white  mt-2">
                                                            <?= intval($comp_q_data['equity']['Advocate']['Early Application'][0]); ?>
                                                            %</h4>
                                                        <!-- <p class="px-2 f-small icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> (200 Students)</small>
                                                        </p> -->
                                                    </div>
                                                    <div class="align-items-center card bg-danger p-1 <?= $comp_q_data['equity']['Advocate']['Max'][1] == "Advanced Application" ? "border border-dark border-5 max-border" : '' ?>"
                                                        style="width:80%;margin:auto;margin-left:3px">
                                                        <h4 class="text-white mt-2">
                                                            <?= intval($comp_q_data['equity']['Advocate']['Advanced Application'][0]); ?>%
                                                        </h4>
                                                        <!-- <p class="px-2 icon-text text-dark mb-0"
                                                            style="color: white!important;">
                                                            <small> 150 Students)</small>
                                                        </p> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Javascript here incomplete -->
                <div class="card">
                    <div class="card-body p-5">
                        <h5 class="card-title text-black mb-5">
                            Competency Comparison
                        </h5>
                        <div class="row align-content-center">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-5">
                                <h5 class="card-title text-black mb-2">
                                    The Skills Employers Value Most
                                </h5>
                                <div class="row bg-light comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center bg-info text-white">
                                        1 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center comm-hov">Communication
                                    </div>
                                </div>
                                <div class="row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center text-white"
                                        style="background-color: #E06B60;">
                                        2 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center team-hov">Teamwork</div>
                                </div>
                                <div class="row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center text-white"
                                        style="background-color: #A056E6;">
                                        3 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center critical-hov">Critical
                                        Thinking
                                    </div>
                                </div>
                                <div class=" row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center bg-success text-white">
                                        4 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center professionalism-hov">
                                        Professionalism
                                    </div>
                                </div>
                                <div class="row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center bg-danger text-white">
                                        5 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center equity-hov">Equity
                                        & Inclusion</div>
                                </div>
                                <div class="row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center text-white"
                                        style="background-color: #556B9B;">
                                        6 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center tech-hov">Technology</div>
                                </div>
                                <div class="row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center bg-warning text-white">
                                        7 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center career-hov">Career
                                        &
                                        Self-Development</div>
                                </div>
                                <div class="row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center text-white"
                                        style="background-color: #796258;">
                                        8 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center leadership-hov">Leadership
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <h5 class="card-title text-black mb-2">
                                    How Students Rated Themselves
                                </h5>
                                <div class="row bg-light comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center bg-info text-white">
                                        1 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center comm-hov">Communication
                                    </div>
                                </div>
                                <div class=" row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center text-white"
                                        style="background-color: #E06B60;">
                                        2 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center team-hov">Teamwork</div>
                                </div>
                                <div class=" row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center text-white"
                                        style="background-color: #A056E6;">
                                        3 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center critical-hov">Critical
                                        Thinking
                                    </div>
                                </div>
                                <div class=" row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center bg-success text-white">
                                        4 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center professionalism-hov">
                                        Professionalism
                                    </div>
                                </div>
                                <div class=" row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center bg-danger text-white">
                                        5 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center equity-hov">Equity
                                        & Inclusion</div>
                                </div>
                                <div class=" row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center text-white"
                                        style="background-color: #556B9B;">
                                        6 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center tech-hov">Technology</div>
                                </div>
                                <div class=" row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center bg-warning text-white">
                                        7 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center career-hov">Career
                                        &
                                        Self-Development</div>
                                </div>
                                <div class=" row bg-light mt-2 comp" style="width:90%">
                                    <div class="col-sm-3 p-3 align-items-center text-center text-white"
                                        style="background-color: #796258;">
                                        8 </div>
                                    <div class="col-sm-9 p-3 align-items-center text-center leadership-hov">Leadership
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="accordion mb-3" id="accordionWork">
                    <div class="accordion-item">
                        <h2 class="accordion-header bg-white pt-4 px-4" id="headingWork">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseWork" aria-expanded="true" aria-controls="collapseWork">
                                <h3> Work Experience </h3>
                            </button>
                        </h2>
                        <div id="collapseWork" class="accordion-collapse collapse show" aria-labelledby="headingWork"
                            data-bs-parent="#accordionWork">
                            <div class="accordion-body bg-white">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div class="card border-2" style="height:720px">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h6 style="font-size:18px">Experiential
                                                        Learning Type</h6>
                                                </div>
                                                <div id="workexpchart1" class="apex-charts mt-5" dir="ltr"
                                                    style="height:630px;"></div>
                                                <!-- <div class="d-flex justify-content-evenly">
                                                    <div class="d-inline-flex">
                                                        <div class="div mt-1"
                                                            style="height:15px;width:15px;background-color:#008ffb !important">
                                                        </div>
                                                        <div
                                                            style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                            On-campus
                                                            student
                                                            work</div>
                                                    </div>
                                                    <div class="d-inline-flex">
                                                        <div class="div mt-1"
                                                            style="height:15px;width:15px;background-color:#00e296 !important">
                                                        </div>
                                                        <div
                                                            style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                            Micro-internship</div>
                                                    </div>
                                                    <div class="d-inline-flex">
                                                        <div class="div mt-1"
                                                            style="height:15px;width:15px;background-color:#fdb01a">
                                                        </div>
                                                        <div
                                                            style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                            Internship</div>
                                                    </div>
                                                </div> -->
                                                <!-- <div class="d-flex justify-content-evenly mt-2">
                                                    <div class="d-inline-flex">
                                                        <div class="div mt-1"
                                                            style="height:15px;width:15px;background-color:#ff4560">
                                                        </div>
                                                        <div
                                                            style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                            Apprenticeship</div>
                                                    </div>
                                                    <div class="d-inline-flex">
                                                        <div class="div mt-1"
                                                            style="height:15px;width:15px;background-color:#775dd0">
                                                        </div>
                                                        <div
                                                            style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                            Co-op</div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="card border-2">
                                            <div class="">
                                                <!-- <div class="row w-100 mb-3 align-content-center">
                                                    <div class="col-sm-5"></div>
                                                    <div class="col-sm-2 d-inline-flex">
                                                        <div class="div mt-1"
                                                            style="height:15px;width:15px;background-color:hsl(186 96% 44% / 1) !important">
                                                        </div>
                                                        <div
                                                            style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                            Min</div>
                                                    </div>
                                                    <div class="col-sm-3 d-inline-flex">
                                                        <div class="div mt-1"
                                                            style="height:15px;width:15px;background-color:hsl(186 96% 40% / 1) !important">
                                                        </div>
                                                        <div
                                                            style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                            Average</div>
                                                    </div>
                                                    <div class="col-sm-2 d-inline-flex">
                                                        <div class="bg-primary div mt-1"
                                                            style="height:15px;width:15px;">
                                                        </div>
                                                        <div
                                                            style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                            Max</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-4 text-center align-content-center">
                                                        <h6 style="font-size:18px">Avg
                                                            Hours Per
                                                            Week</h6>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="progress" style="height: 65px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 40%;background-color:hsl(186 96% 44% / 1) !important"
                                                                aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"
                                                                data-bs-toggle="tooltip" title="22 Students">
                                                                <b style="font-size:16px">5</b>
                                                            </div>
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 30%;background-color:hsl(186 96% 40% / 1) !important"
                                                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"
                                                                data-bs-toggle="tooltip" title="55 Students">
                                                                <b style="font-size:16px">12</b>
                                                            </div>
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                style="width: 30%" aria-valuenow="20" aria-valuemin="0"
                                                                aria-valuemax="100" data-bs-toggle="tooltip"
                                                                title="35 Students">
                                                                <b style="font-size:16px">15</b>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="row mt-3">
                                                    <!-- <div class="col-sm-4 text-center align-content-center">
                                                        <h6 style="font-size:18px">Total
                                                            Weeks</h6>
                                                    </div> -->
                                                    <div class="col-sm-12 py-2">
                                                        <table class="table table-striped"
                                                            style="line-height:220%;text-align:center">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"></th>
                                                                    <th scope="col">Min</th>
                                                                    <th scope="col">Avg</th>
                                                                    <th scope="col">Max</th>
                                                                    <th scope="col">Responses</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <tr>
                                                                    <th scope="row">Avg Hours Per Week</th>
                                                                    <td><?=intval(json_encode($work_data['Average Hours and Weeks']['hours']['min']))?>
                                                                    </td>
                                                                    <td><?=intval(json_encode($work_data['Average Hours and Weeks']['hours']['avg']))?>
                                                                    </td>
                                                                    <td><?=intval(json_encode($work_data['Average Hours and Weeks']['hours']['max']))?>
                                                                    </td>
                                                                    <td data-bs-toggle="tooltip" title="22 Students">
                                                                        <?= intval(json_encode($work_data['Average Hours and Weeks']['hours']['response']))?>%
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">Total Weeks</th>
                                                                    <td><?=intval(json_encode($work_data['Average Hours and Weeks']['weeks']['min']))?>
                                                                    </td>
                                                                    <td><?=intval(json_encode($work_data['Average Hours and Weeks']['weeks']['avg']))?>
                                                                    </td>
                                                                    <td><?=intval(json_encode($work_data['Average Hours and Weeks']['weeks']['max']))?>
                                                                    </td>
                                                                    <td data-bs-toggle="tooltip" title="22 Students">
                                                                        <?= intval(json_encode($work_data['Average Hours and Weeks']['weeks']['response']))?>%
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <!-- <div class="progress" style="height: 65px;">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 50%;background-color:hsl(186 96% 44% / 1) !important"
                                                                aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"
                                                                data-bs-toggle="tooltip" title="22 Students">
                                                                <b style="font-size:16px">4</b>
                                                            </div>
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 30%;background-color:hsl(186 96% 40% / 1) !important"
                                                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"
                                                                data-bs-toggle="tooltip" title="55 Students">
                                                                <b style="font-size:16px">8</b>
                                                            </div>
                                                            <div class="progress-bar bg-primary" role="progressbar"
                                                                style="width: 20%" aria-valuenow="20" aria-valuemin="0"
                                                                aria-valuemax="100" data-bs-toggle="tooltip"
                                                                title="35 Students">
                                                                <b style="font-size:16px">12</b>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card border-2" style="height:225px">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h6 style="font-size:18px">Pay
                                                        Status</h6>
                                                </div>
                                                <div class="row py-3 px-1">
                                                    <div class="col-sm-4">
                                                        <div class="d-flex">
                                                            <div class="div mt-1"
                                                                style="height:15px;width:15px;background-color:#008ffb!important">
                                                            </div>
                                                            <div
                                                                style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                Paid</div>
                                                        </div>
                                                        <div class="d-flex mt-3">
                                                            <div class="div mt-1"
                                                                style="height:15px;width:15px;background-color:#00e397!important">
                                                            </div>
                                                            <div
                                                                style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                Unpaid</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-8 pb-3">
                                                        <div id="workexpchart2" class="apex-charts" dir="ltr"
                                                            style="height:200px;margin-top:-50px"></div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card mb-0 border-2" style="height:225px">
                                            <div class="card-body">
                                                <div class="card-title">
                                                    <h6 style="font-size:18px">Academic
                                                        Credit</h6>
                                                </div>
                                                <div class="row py-3">
                                                    <div class="col-sm-4">
                                                        <div class="d-flex">
                                                            <div class="div mt-1"
                                                                style="height:15px;width:15px;background-color:#008ffb!important">
                                                            </div>
                                                            <div
                                                                style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                Credit</div>
                                                        </div>
                                                        <div class="d-flex mt-3">
                                                            <div class="div mt-1"
                                                                style="height:15px;width:15px;background-color:#00e397!important">
                                                            </div>
                                                            <div
                                                                style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                Not to
                                                                Credit</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8 pb-3">
                                                        <div id="workexpchart3" class="apex-charts" dir="ltr"
                                                            style="height:200px;margin-top:-50px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header bg-white pt-4 px-4" id="headingDemographics">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDemographics" aria-expanded="false"
                                aria-controls="collapseDemographics">
                                <h3> Demographics </h3>
                            </button>
                        </h2>
                        <div id="collapseDemographics" class="accordion-collapse collapse"
                            aria-labelledby="headingDemographics" data-bs-parent="#accordionDemographics">
                            <div class="accordion-body bg-white">
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="row p-4">
                                            <div class="col-sm-6">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <!-- <h6> At what degree/certificate/class year are you
                                                                currently
                                                                enrolled? </h6> -->
                                                        <div id="bar_chart2" class="apex-charts" dir="ltr"
                                                            style="height:370px">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <h6 class="pie-text">
                                                            Which of the
                                                            following best
                                                            represent your
                                                            program
                                                            or
                                                            area
                                                            of study? </h6>

                                                        <!-- <div id="bar_chart3" class="apex-charts" dir="ltr"
                                                            style="height:370px">
                                                        </div> -->
                                                        <div class style="height:316px;overflow:scroll">
                                                            <table class="table table-striped"
                                                                style="text-align:left!important">
                                                                <thead class="sticky-top bg-white">
                                                                    <tr>
                                                                        <th scope="col">#</th>
                                                                        <th scope="col">Name</th>
                                                                        <th scope="col">Students</th>
                                                                        <th scope="col">%</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">1</th>
                                                                        <td>Accounting
                                                                            and
                                                                            Computer
                                                                            Science</td>
                                                                        <td>222</td>
                                                                        <td>33%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">2</th>
                                                                        <td>Accounting
                                                                            and
                                                                            Related
                                                                            Services</td>
                                                                        <td>222</td>
                                                                        <td>33%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">3</th>
                                                                        <td>Aerospace,
                                                                            Aeronautical
                                                                            and
                                                                            Astronautical
                                                                            Engineering</td>
                                                                        <td>222</td>
                                                                        <td>33%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">4</th>
                                                                        <td>African
                                                                            Languages,
                                                                            Literatures,
                                                                            and
                                                                            Linguistics
                                                                        </td>
                                                                        <td>222</td>
                                                                        <td>33%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">5</th>
                                                                        <td>Agricultural
                                                                            and
                                                                            Domestic
                                                                            Animal
                                                                            Services
                                                                        </td>
                                                                        <td>222</td>
                                                                        <td>33%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">6</th>
                                                                        <td>Agricultural
                                                                            and
                                                                            Food
                                                                            Products
                                                                            Processing
                                                                        </td>
                                                                        <td>222</td>
                                                                        <td>33%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">7</th>
                                                                        <td>Agricultural
                                                                            Engineering</td>
                                                                        <td>222</td>
                                                                        <td>33%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">8</th>
                                                                        <td>Jacob</td>
                                                                        <td>222</td>
                                                                        <td>33%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">9</th>
                                                                        <td>Larry</td>
                                                                        <td>222</td>
                                                                        <td>33%</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <h6 class="pie-text">
                                                            Gender: How do
                                                            you identify?
                                                        </h6>
                                                        <div id="bar_chart4" class="apex-charts" dir="ltr"
                                                            style="height:370px">
                                                        </div>
                                                        <!-- <div class="d-flex justify-content-evenly">
                                                            <div class="d-inline-flex">
                                                                <div class="div mt-1"
                                                                    style="height:15px;width:15px;background-color:#008ffb !important">
                                                                </div>
                                                                <div
                                                                    style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                    Male</div>
                                                            </div>
                                                            <div class="d-inline-flex">
                                                                <div class="div mt-1"
                                                                    style="height:15px;width:15px;background-color:#00e296 !important">
                                                                </div>
                                                                <div
                                                                    style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                    Female</div>
                                                            </div>
                                                            <div class="d-inline-flex">
                                                                <div class="div mt-1"
                                                                    style="height:15px;width:15px;background-color:#fdb01a">
                                                                </div>
                                                                <div
                                                                    style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                    Non-binary</div>
                                                            </div>
                                                            <div class="d-inline-flex">
                                                                <div class="div mt-1"
                                                                    style="height:15px;width:15px;background-color:#ff4560">
                                                                </div>
                                                                <div
                                                                    style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                    Prefer
                                                                    not to
                                                                    respond</div>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 d-flex flex-fill">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <!-- <h6> Which of the following categories would you use to
                                                                best
                                                                describe yourself?
                                                            </h6> -->
                                                        <div id="bar_chart5" class="apex-charts" dir="ltr"
                                                            style="height:395px">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6  d-flex flex-fill">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <!-- <h6> What is your parent(s) or caregiver(s) highest
                                                                level of
                                                                education in the
                                                                United
                                                                States?</h6> -->
                                                        <div id="bar_chart6" class="apex-charts" dir="ltr"
                                                            style="height:390px">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <h6 class="pie-text">
                                                            Do you have a
                                                            diagnosed
                                                            disability?
                                                        </h6>
                                                        <div id="chart7" class="apex-charts" dir="ltr"
                                                            style="height:370px">
                                                        </div>
                                                        <!-- <div class="d-flex justify-content-evenly">
                                                            <div class="d-inline-flex">
                                                                <div class="div mt-1"
                                                                    style="height:15px;width:15px;background-color:#008ffb !important">
                                                                </div>
                                                                <div
                                                                    style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                    Yes</div>
                                                            </div>
                                                            <div class="d-inline-flex">
                                                                <div class="div mt-1"
                                                                    style="height:15px;width:15px;background-color:#00e296 !important">
                                                                </div>
                                                                <div
                                                                    style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                    No</div>
                                                            </div>
                                                            <div class="d-inline-flex">
                                                                <div class="div mt-1"
                                                                    style="height:15px;width:15px;background-color:#fdb01a">
                                                                </div>
                                                                <div
                                                                    style="margin-left: 10px; color: #12171dbf!important; font-weight: 600;font-size:16px">
                                                                    Prefer
                                                                    not to
                                                                    respond</div>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <h6 class="pie-text">
                                                            Do you identify
                                                            as a member of
                                                            the
                                                            LGBTQ+
                                                            community?
                                                        </h6>
                                                        <div id="chart8" class="apex-charts" dir="ltr"
                                                            style="height:370px">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <h6 class="pie-text">
                                                            Is English the
                                                            primary language
                                                            spoken
                                                            at your
                                                            childhood
                                                            home?</h6>
                                                        <div id="chart9" class="apex-charts" dir="ltr"
                                                            style="height:370px">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <h6 class="pie-text">
                                                            Are you a parent
                                                            to a child under
                                                            18
                                                            years old?
                                                        </h6>
                                                        <div id="chart10" class="apex-charts" dir="ltr"
                                                            style="height:370px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6  d-flex flex-fill">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <!-- <h6> Have you ever served on active duty in the U.S.
                                                                Armed
                                                                Forces, Reserves, or
                                                                National Guard? (Optional)</h6> -->
                                                        <div id="chart13" class="apex-charts" dir="ltr"
                                                            style="height:390px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <h6 class="pie-text">
                                                            Are you the
                                                            primary
                                                            caregiver to a
                                                            family member
                                                            (not a
                                                            child) such as a
                                                            parent, partner,
                                                            etc.?
                                                            (Optional)</h6>
                                                        <div id="chart12" class="apex-charts" dir="ltr"
                                                            style="height:370px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6  d-flex flex-fill">
                                                <div class="card p-3 border-2">
                                                    <div class="card-body px-3 py-3">
                                                        <!-- <h6> Age </h6> -->
                                                        <div id="chart14" class="apex-charts" dir="ltr"
                                                            style="height:410px"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="card p-3 border-2">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="card-body px-3 py-3">
                                                                <!-- <h6> Which of the following sources did you use
                                                                        to
                                                                        finance your college
                                                                        tuition?
                                                                        (Optional) </h6> -->
                                                                <div id="chart15" class="apex-charts" dir="ltr"
                                                                    style="height:390px">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="card-body">
                                                                <h3>Others</h3>
                                                                <!-- <hr style="color:grey"> -->
                                                                <!-- <ol style="line-height:200%">
                                                <li>Cash - 5 </li>
                                                <li> Grant A - 2 </li>
                                                <li> International Student Scholorship - 4 </li>
                                            </ol> -->

                                                                <table class="table" style="color:black!important;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col">Detail</th>
                                                                            <th scope="col">Count</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr style="color:black!important;">
                                                                            <th scope="row"
                                                                                style="color:black!important;">1
                                                                            </th>
                                                                            <td style="color:black!important;">Cash
                                                                            </td>
                                                                            <td style="color:black!important;">5
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">2</th>
                                                                            <td style="color:black!important;">Grant
                                                                                A</td>
                                                                            <td style="color:black!important;">2
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th scope="row">3</th>
                                                                            <td style="color:black!important;">
                                                                                International
                                                                                Student
                                                                                Scholorship
                                                                            </td>
                                                                            <td style="color:black!important;">4
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page-content -->

            <footer class="footer container" style="left: 20px!important;border-radius: 24px 24px 0px 0px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                            document.write(new Date().getFullYear())
                            </script> © Career Launch.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Crafted with <i class="mdi mdi-heart text-danger"></i>
                                by Team Career Launch
                            </div>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4 shadow">

                <h5 class="m-0 me-2">Settings</h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="layout-1">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="layout-2">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch"
                        data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="layout-3">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch"
                        data-appStyle="assets/css/app-rtl.min.css">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>

            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- morris chart -->
    <script src="assets/libs/morris.js/morris.min.js"></script>
    <script src="assets/libs/raphael/raphael.min.js"></script>

    <!-- jquery.vectormap map -->
    <script src="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js"></script>

    <!-- Required datatable js -->
    <script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Responsive examples -->
    <script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <script src="assets/js/pages/index.init.js"></script>

    <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>

    <script src="assets/js/pages/jquery-knob.init.js"></script>

    <!-- materialdesign icon js-->
    <script src="assets/js/pages/materialdesign.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <script>
    Highcharts.chart('bar_chart2', {
        chart: {
            type: 'bar'
        },
        title: {
            show: false,
            text: 'At what degree/certificate/class year are you currently enrolled?',
            align: 'left'
        },
        xAxis: {
            categories: ["Bachelor's - 1st Year",
                "Bachelor's - 2nd Year",
                "Bachelor's - 3rd Year",
                "Bachelor's - 4th Year",
                "Bachelor's - 5th Year or Beyond",
                "Masters",
                "Doctoral"
            ],
            crosshair: true,
            accessibility: {
                description: 'Countries'
            },
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Responses'
            }
        },
        tooltip: {
            valueSuffix: ' Students'
        },
        plotOptions: {
            column: {
                pointPadding: 0.5,
                borderWidth: 0,
                color: '#000033',
            },
            series: {
                pointWidth: 25,
                color: '#000051',
                dataLabels: {
                    enabled: true,
                    inside: true,
                    align: 'right'
                }

            }
        },
        legend: {
            enabled: false
        },
        dataLabels: {
            enabled: true,
            color: '#000',
            floating: true,
            format: '{point.y:.1f}', // one decimal
            backgroundColor: '#000033',
            style: {
                fontSize: '6px',
                fontFamily: 'Mulish, sans-serif',
            },
        },
        series: [{
            name: 'Responses',
            dataLabels: [{
                align: 'right',
                inside: false,
                floating: true,
                format: '{y} ({point.per}%)',
                style: {
                    color: 'white'
                },
            }],
            data: [{
                y: 1,
                per: 72,
            }, {
                y: 30,
                per: 74,
            }, {
                y: 48,
                per: 83
            }, {
                y: 32,
                per: 76
            }, ],
            showInLegend: false
        }]
    });

    var options = {
        series: <?= json_encode($demo_data['Gender: How do you identify?']['values']); ?>,
        chart: {
            type: 'donut',
            height: 400
        },
        legend: {
            show: true,
            showForSingleSeries: false,
            showForNullSeries: true,
            showForZeroSeries: true,
            position: 'bottom',
            horizontalAlign: 'center',
            floating: false,
            fontSize: '16px',
            fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"',
            fontWeight: 400,
            formatter: undefined,
            inverseOrder: false,
            width: undefined,
            height: undefined,
            tooltipHoverFormatter: undefined,
            customLegendItems: [],
            offsetX: 0,
            offsetY: 0,

            labels: {
                colors: undefined,
                useSeriesColors: false
            },
            markers: {
                size: 9,
                shape: 'square',
                strokeWidth: 1,
                fillColors: undefined,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            },
            onItemClick: {
                toggleDataSeries: true
            },
            onItemHover: {
                highlightDataSeries: true
            },
        },
        labels: <?= json_encode($demo_data['Gender: How do you identify?']['labels']); ?>,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 100
                },
                legend: {
                    position: 'bottom',
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#bar_chart4"), options);
    chart.render();

    Highcharts.chart('bar_chart5', {
        chart: {
            type: 'bar'
        },
        title: {
            show: false,
            text: 'Which of the following categories would you use to best describe yourself?',
            align: 'left'
        },
        xAxis: {
            categories: <?= json_encode($dataArray[
                            'Which of the following categories would you use to best describe yourself?'][
                            'labels'
                        ]);?>,
            crosshair: true,
            accessibility: {
                description: 'Countries'
            },
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Responses'
            }
        },
        tooltip: {
            valueSuffix: ' Students'
        },
        plotOptions: {
            column: {
                pointPadding: 0.5,
                borderWidth: 0,
                color: '#000033',
            },
            series: {
                pointWidth: 25,
                color: '#000051',
                dataLabels: {
                    enabled: true,
                    align: 'right',
                }

            }
        },
        legend: {
            enabled: false
        },
        series: [{
            colorByValue: true,
            name: 'Responses',
            dataLabels: [{
                align: 'right',
                inside: false,
                floating: true,
                formatter: function() {
                    var max = this.series.yAxis.max;
                    var color = this.y / max <= 0.1 ? 'black' : 'white'; // 5% width
                    perc = ((this.y / max).toFixed(2)) * 100;
                    return '<span style="color: ' + color + '">' + this.y + '(' + perc +
                        '%)</span>';
                },
            }],
            data: <?= json_encode($dataArray[
                            'Which of the following categories would you use to best describe yourself?'
                            ]['formatted_data']);?>,
            showInLegend: false
        }]
    });

    Highcharts.chart('bar_chart6', {
        chart: {
            type: 'bar'
        },
        title: {
            show: false,
            text: 'What is your parent(s) or caregiver(s) highest level of education in the United States?',
            align: 'left'
        },
        xAxis: {
            categories: <?= json_encode($dataArray[ 'Are you the primary caregiver to a family member (not a child) such as a parent, partner, etc.?' ]['labels']);?>,
            crosshair: true,
            accessibility: {
                description: 'Countries'
            },
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Responses'
            }
        },
        tooltip: {
            valueSuffix: ' Students'
        },
        plotOptions: {
            column: {
                pointPadding: 0.5,
                borderWidth: 0,
                color: '#000033',
            },
            series: {
                pointWidth: 25,
                color: '#000051',
                dataLabels: {
                    enabled: true,
                    inside: true,
                    align: 'right',
                }
            }
        },
        legend: {
            enabled: false
        },
        dataLabels: {
            enabled: true,
            color: '#000',
            floating: true,
            format: '{point.y:.1f}', // one decimal
            backgroundColor: '#000033',
            style: {
                fontSize: '6px',
                fontFamily: 'Mulish, sans-serif'
            },
        },
        series: [{
            name: 'Responses',
            dataLabels: [{
                align: 'right',
                inside: false,
                formatter: function() {
                    var max = this.series.yAxis.max;
                    var color = this.y / max <= 0.1 ? 'black' : 'white'; // 5% width
                    perc = ((this.y / max).toFixed(2)) * 100;
                    return '<span style="color: ' + color + '">' + this.y + '(' + perc +
                        '%)</span>';
                },
            }],
            data: <?= json_encode($dataArray[ 'Are you the primary caregiver to a family member (not a child) such as a parent, partner, etc.?' ]['formatted_data']);?>,
            showInLegend: false
        }]
    });

    var options = {
        series: <?= json_encode($demo_data['Do you have a diagnosed disability?']['values']); ?>,
        chart: {
            type: 'donut',
            height: 400
        },
        legend: {
            show: true,
            showForSingleSeries: false,
            showForNullSeries: true,
            showForZeroSeries: true,
            position: 'bottom',
            horizontalAlign: 'center',
            floating: false,
            fontSize: '16px',
            fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"',
            fontWeight: 400,
            formatter: undefined,
            inverseOrder: false,
            width: undefined,
            height: undefined,
            tooltipHoverFormatter: undefined,
            customLegendItems: [],
            offsetX: 0,
            offsetY: 0,

            labels: {
                colors: undefined,
                useSeriesColors: false
            },
            markers: {
                size: 9,
                shape: 'square',
                strokeWidth: 1,
                fillColors: undefined,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            },
            onItemClick: {
                toggleDataSeries: true
            },
            onItemHover: {
                highlightDataSeries: true
            },
        },
        labels: <?= json_encode($demo_data['Do you have a diagnosed disability?']['labels']); ?>,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 100
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart7"), options);
    chart.render();


    var options = {
        series: <?= json_encode($demo_data['Do you identify as a member of the LGBTQ+ community?']['values']); ?>,
        chart: {
            type: 'donut',
            height: 400
        },
        legend: {
            show: true,
            showForSingleSeries: false,
            showForNullSeries: true,
            showForZeroSeries: true,
            position: 'bottom',
            horizontalAlign: 'center',
            floating: false,
            fontSize: '16px',
            fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"',
            fontWeight: 400,
            formatter: undefined,
            inverseOrder: false,
            width: undefined,
            height: undefined,
            tooltipHoverFormatter: undefined,
            customLegendItems: [],
            offsetX: 0,
            offsetY: 0,

            labels: {
                colors: undefined,
                useSeriesColors: false
            },
            markers: {
                size: 9,
                shape: 'square',
                strokeWidth: 1,
                fillColors: undefined,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            },
            onItemClick: {
                toggleDataSeries: true
            },
            onItemHover: {
                highlightDataSeries: true
            },
        },
        labels: <?= json_encode($demo_data['Do you identify as a member of the LGBTQ+ community?']['labels']); ?>,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 100
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart8"), options);
    chart.render();

    var options = {
        series: <?= json_encode($demo_data['Is English the primary language spoken at your childhood home?']['values']); ?>,
        chart: {
            type: 'donut',
            height: 400
        },
        legend: {
            show: true,
            showForSingleSeries: false,
            showForNullSeries: true,
            showForZeroSeries: true,
            position: 'bottom',
            horizontalAlign: 'center',
            floating: false,
            fontSize: '16px',
            fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"',
            fontWeight: 400,
            formatter: undefined,
            inverseOrder: false,
            width: undefined,
            height: undefined,
            tooltipHoverFormatter: undefined,
            customLegendItems: [],
            offsetX: 0,
            offsetY: 0,

            labels: {
                colors: undefined,
                useSeriesColors: false
            },
            markers: {
                size: 9,
                shape: 'square',
                strokeWidth: 1,
                fillColors: undefined,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            },
            onItemClick: {
                toggleDataSeries: true
            },
            onItemHover: {
                highlightDataSeries: true
            },
        },
        labels: <?= json_encode($demo_data['Is English the primary language spoken at your childhood home?']['labels']); ?>,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 100
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart9"), options);
    chart.render();

    var options = {
        series: <?=json_encode($demo_data['Are you a parent to a child under 18 years old?']['values']);?>,
        chart: {
            type: 'donut',
            height: 400
        },
        legend: {
            show: true,
            showForSingleSeries: false,
            showForNullSeries: true,
            showForZeroSeries: true,
            position: 'bottom',
            horizontalAlign: 'center',
            floating: false,
            fontSize: '16px',
            fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"',
            fontWeight: 400,
            formatter: undefined,
            inverseOrder: false,
            width: undefined,
            height: undefined,
            tooltipHoverFormatter: undefined,
            customLegendItems: [],
            offsetX: 0,
            offsetY: 0,

            labels: {
                colors: undefined,
                useSeriesColors: false
            },
            markers: {
                size: 9,
                shape: 'square',
                strokeWidth: 1,
                fillColors: undefined,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            },
            onItemClick: {
                toggleDataSeries: true
            },
            onItemHover: {
                highlightDataSeries: true
            },
        },
        labels: <?=json_encode($demo_data['Are you a parent to a child under 18 years old?']['labels']);?>,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 100
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart10"), options);
    chart.render();

    Highcharts.chart('chart13', {
        chart: {
            type: 'bar'
        },
        title: {
            show: false,
            text: 'Have you ever served on active duty in the U.S. Armed Forces, Reserves, or National Guard? (Optional)',
            align: 'left'
        },
        xAxis: {
            categories: <?= json_encode($dataArray['Have you ever served on active duty in the U.S. Armed Forces, Reserves, or National Guard?']['labels']);?>,
            crosshair: true,
            accessibility: {
                description: 'Countries'
            },
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Responses'
            }
        },
        tooltip: {
            valueSuffix: ' Students'
        },
        plotOptions: {
            column: {
                pointPadding: 0.5,
                borderWidth: 0,
                color: '#000033',
            },
            series: {
                pointWidth: 25,
                color: '#000051',
                dataLabels: {
                    enabled: true,
                    inside: true,
                    align: 'right'
                }

            }
        },
        legend: {
            enabled: false
        },
        dataLabels: {
            enabled: true,
            color: '#000',
            floating: true,
            format: '{point.y:.1f}', // one decimal
            backgroundColor: '#000033',
            style: {
                fontSize: '6px',
                fontFamily: 'Mulish, sans-serif'
            },
        },
        series: [{
            name: 'Responses',
            dataLabels: [{
                align: 'right',
                inside: false,
                floating: true,
                formatter: function() {
                    var max = this.series.yAxis.max;
                    var color = this.y / max <= 0.1 ? 'black' : 'white'; // 5% width
                    perc = ((this.y / max).toFixed(2)) * 100;
                    return '<span style="color: ' + color + '">' + this.y + '(' + perc +
                        '%)</span>';
                },
            }],
            data: <?= json_encode($dataArray['Have you ever served on active duty in the U.S. Armed Forces, Reserves, or National Guard?']['formatted_data']);?>,
            showInLegend: false
        }]
    });

    var options = {
        series: <?= json_encode($demo_data['Are you the primary caregiver to a family member (not a child) such as a parent, partner, etc.?']['values']); ?>,
        chart: {
            type: 'donut',
            height: 400
        },
        legend: {
            show: true,
            showForSingleSeries: false,
            showForNullSeries: true,
            showForZeroSeries: true,
            position: 'bottom',
            horizontalAlign: 'center',
            floating: false,
            fontSize: '16px',
            fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"',
            fontWeight: 400,
            formatter: undefined,
            inverseOrder: false,
            width: undefined,
            height: undefined,
            tooltipHoverFormatter: undefined,
            customLegendItems: [],
            offsetX: 0,
            offsetY: 0,

            labels: {
                colors: undefined,
                useSeriesColors: false
            },
            markers: {
                size: 9,
                shape: 'square',
                strokeWidth: 1,
                fillColors: undefined,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            },
            onItemClick: {
                toggleDataSeries: true
            },
            onItemHover: {
                highlightDataSeries: true
            },
        },
        labels: <?= json_encode($demo_data['Are you the primary caregiver to a family member (not a child) such as a parent, partner, etc.?']['labels']); ?>,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 100
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#chart12"), options);
    chart.render();

    Highcharts.chart('chart15', {
        chart: {
            type: 'bar'
        },
        title: {
            show: false,
            text: 'Which of the following sources did you use to finance your college tuition? (Optional)',
            align: 'left'
        },
        xAxis: {
            categories: <?= json_encode($dataArray['Which of the following sources did you use to finance your college tuition? (Optional)  Select all that apply:']['labels']);?>,
            crosshair: true,
            accessibility: {
                description: 'Countries'
            },
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Responses'
            }
        },
        tooltip: {
            valueSuffix: ' Students'
        },
        plotOptions: {
            column: {
                pointPadding: 0.5,
                borderWidth: 0,
                color: '#000033',
            },
            series: {
                pointWidth: 30,
                color: '#000051',
                dataLabels: {
                    enabled: true,
                    inside: true,
                    align: 'right'
                }

            }
        },
        legend: {
            enabled: false
        },
        dataLabels: {
            enabled: true,
            color: '#000',
            // floating: true,
            format: '{point.y:.1f}', // one decimal
            backgroundColor: '#000033',
            style: {
                fontSize: '6px',
                fontFamily: 'Mulish, sans-serif'
            },
        },
        series: [{
            name: 'Responses',
            dataLabels: [{
                align: 'right',
                // inside: false,
                format: '{y} ({point.per}%)'
            }],
            data: <?= json_encode($dataArray['Which of the following sources did you use to finance your college tuition? (Optional)  Select all that apply:']['formatted_data']);?>,
            showInLegend: false
        }]
    });

    Highcharts.chart('chart14', {
        chart: {
            type: 'bar'
        },
        title: {
            show: false,
            text: 'Age',
            align: 'left'
        },
        xAxis: {
            categories: <?= json_encode($dataArray['What is your age? (Optional)']['labels']);?>,
            crosshair: true,
            accessibility: {
                description: 'Countries'
            },
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Responses'
            }
        },
        tooltip: {
            valueSuffix: ' Students'
        },
        plotOptions: {
            column: {
                pointPadding: 0.5,
                borderWidth: 0,
                color: '#000033',
            },
            series: {
                pointWidth: 25,
                color: '#000051',
                dataLabels: {
                    enabled: true,
                    align: 'right'
                }

            }
        },
        legend: {
            enabled: false
        },
        dataLabels: {
            enabled: true,
            color: '#000',
            floating: true,
            inside: false,
            format: '{point.y:.1f}', // one decimal
            backgroundColor: '#000033',
            style: {
                fontSize: '6px',
                fontFamily: 'Mulish, sans-serif'
            },
        },
        series: [{
            name: 'Responses',
            dataLabels: [{
                align: 'right',
                inside: false,
                floating: true,
                formatter: function() {
                    var max = this.series.yAxis.max;
                    var color = this.y / max <= 0.14 ? 'black' : 'white'; // 5% width
                    perc = ((this.y / max).toFixed(2)) * 100;
                    return '<span style="color: ' + color + '">' + this.y + '(' + perc
                        .toFixed(2) +
                        '%)</span>';
                },
            }],
            data: <?= json_encode($dataArray['What is your age? (Optional)']['formatted_data']);?>,
            showInLegend: false
        }]
    });


    var options = {
        series: <?= json_encode($work_data['Experiential Learning Type']['values']); ?>,
        chart: {
            type: 'donut',
            height: 630
        },
        legend: {
            show: true,
            showForSingleSeries: false,
            showForNullSeries: true,
            showForZeroSeries: true,
            position: 'bottom',
            horizontalAlign: 'center',
            floating: false,
            fontSize: '16px',
            fontFamily: '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"',
            fontWeight: 400,
            formatter: undefined,
            inverseOrder: false,
            width: undefined,
            height: undefined,
            tooltipHoverFormatter: undefined,
            customLegendItems: [],
            offsetX: 0,
            offsetY: 0,

            labels: {
                colors: undefined,
                useSeriesColors: false
            },
            markers: {
                size: 9,
                shape: 'square',
                strokeWidth: 1,
                fillColors: undefined,
                customHTML: undefined,
                onClick: undefined,
                offsetX: 0,
                offsetY: 0
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            },
            onItemClick: {
                toggleDataSeries: true
            },
            onItemHover: {
                highlightDataSeries: true
            },
        },
        labels: <?= json_encode($work_data['Experiential Learning Type']['labels']) ?>,
        formatter: function(val) {
            return val + "%"
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 100
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#workexpchart1"), options);
    chart.render();


    var options = {
        series: <?= json_encode($work_data['Pay Status']['percentages']) ?>,
        chart: {
            type: 'donut',
            height: 230
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    offset: 25,
                    style: {
                        colors: ['#000000'],
                    },
                }
            }
        },
        legend: {
            show: false
        },
        labels: <?= json_encode($work_data['Pay Status']['labels']) ?>,
        formatter: function(val) {
            return val + "%"
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 100
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#workexpchart2"), options);
    chart.render();


    var options = {
        series: <?= json_encode($work_data['Academic Credit']['percentages']) ?>,
        chart: {
            type: 'donut',
            height: 230,
        },
        legend: {
            show: false
        },
        labels: <?= json_encode($work_data['Academic Credit']['labels']) ?>,
        formatter: function(val) {
            return val + "%"
        },
        plotOptions: {
            pie: {
                dataLabels: {
                    offset: 40,
                    style: {
                        colors: ['#000000'],
                    },
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 100
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#workexpchart3"), options);
    chart.render();
    </script>

    <script>
    /**
     * In the chart render event, add icons on top of the circular shapes
     */
    function renderIcons() {

        this.series.forEach(series => {
            if (!series.icon) {
                series.icon = this.renderer
                    .text(
                        `<i class="fa fa-${series.options.custom.icon}"></i>`,
                        0,
                        0,
                        true
                    )
                    .attr({
                        zIndex: 10
                    })
                    .css({
                        color: series.options.custom.iconColor,
                        fontSize: '1.5em'
                    })
                    .add(this.series[2].group);
            }
            series.icon.attr({
                x: this.chartWidth / 2 - 15,
                y: this.plotHeight / 2 -
                    series.points[0].shapeArgs.innerR -
                    (
                        series.points[0].shapeArgs.r -
                        series.points[0].shapeArgs.innerR
                    ) / 2 +
                    8
            });
        });
    }

    const trackColors = Highcharts.getOptions().colors.map(color =>
        new Highcharts.Color(color).setOpacity(0.3).get()
    );

    Highcharts.chart('container', {

        chart: {
            type: 'solidgauge',
            height: '110%',
            events: {
                render: renderIcons
            }
        },

        title: {
            text: 'Emerging Knowledge',
            style: {
                fontSize: '14px'
            }
        },

        tooltip: {
            borderWidth: 0,
            backgroundColor: 'none',
            shadow: false,
            style: {
                fontSize: '16px'
            },
            valueSuffix: '%',
            pointFormat: '{series.name}<br>' +
                '<span style="font-size: 2em; color: {point.color}; ' +
                'font-weight: bold">{point.y}</span>',
            positioner: function(labelWidth) {
                return {
                    x: (this.chart.chartWidth - labelWidth) / 2,
                    y: (this.chart.plotHeight / 2) + 15
                };
            }
        },

        pane: {
            startAngle: 0,
            endAngle: 360,
            background: [{ // Track for Conversion
                outerRadius: '112%',
                innerRadius: '88%',
                backgroundColor: trackColors[0],
                borderWidth: 0
            }, { // Track for Engagement
                outerRadius: '87%',
                innerRadius: '63%',
                backgroundColor: trackColors[1],
                borderWidth: 0
            }, ]
        },

        yAxis: {
            min: 0,
            max: 100,
            lineWidth: 0,
            tickPositions: []
        },

        plotOptions: {
            solidgauge: {
                dataLabels: {
                    enabled: false
                },
                linecap: 'round',
                stickyTracking: false,
                rounded: true
            }
        },

        series: [{
            name: 'Responses',
            name: 'Post',
            data: [{
                color: Highcharts.getOptions().colors[0],
                radius: '112%',
                innerRadius: '88%',
                y: 80
            }],
            custom: {
                icon: 'filter',
                iconColor: '#303030'
            }
        }, {
            name: 'Pre',
            data: [{
                color: Highcharts.getOptions().colors[1],
                radius: '87%',
                innerRadius: '63%',
                y: 65
            }],
            custom: {
                icon: 'comments-o',
                iconColor: '#ffffff'
            }
        }]
    });
    </script>

    <script>
    $(".knob").knob({
                'format': function(value) {
                    return value + '%';
                }
    </script>

    <script>
    function setEmergingGaugeValue(percentage) {
        const gauge = document.getElementById('gauge-emerging-foreground');
        const text = document.getElementById('gauge-emerging-percentage');
        const offset = ((100 - percentage) / 100) * 100;
        gauge.style.strokeDasharray = `${percentage+7}, 100`;
        // guage.style.stroke = #000;
        text.textContent = `${percentage}%`;
    }

    setEmergingGaugeValue(<?= intval($comp_data['overall_career_readiness_results']['Emerging Knowledge'][0]) ?>);

    function setUnderstandingGaugeValue(percentage) {
        const gauge = document.getElementById('gauge-understanding-foreground');
        const text = document.getElementById('gauge-understanding-percentage');
        const offset = ((100 - percentage) / 100) * 100;
        gauge.style.strokeDasharray = `${percentage+7}, 100`;
        text.textContent = `${percentage}%`;
    }

    setUnderstandingGaugeValue(<?= intval($comp_data['overall_career_readiness_results']['Understanding'][0]) ?>);

    function setEarlyGaugeValue(percentage) {
        const gauge = document.getElementById('gauge-early-foreground');
        const text = document.getElementById('gauge-early-percentage');
        const offset = ((100 - percentage) / 100) * 100;
        gauge.style.strokeDasharray = `${percentage+7}, 100`;
        text.textContent = `${percentage}%`;
    }

    setEarlyGaugeValue(<?= intval($comp_data['overall_career_readiness_results']['Early Application'][0]) ?>);

    function setAdvancedGaugeValue(percentage) {
        const gauge = document.getElementById('gauge-advanced-foreground');
        const text = document.getElementById('gauge-advanced-percentage');
        const offset = ((100 - percentage) / 100) * 100;
        gauge.style.strokeDasharray = `${percentage+7}, 100`;
        text.textContent = `${percentage}%`;
    }

    setAdvancedGaugeValue(<?= intval($comp_data['overall_career_readiness_results']['Advanced Application'][0]) ?>);
    </script>

    <script>
    $(document).ready(function() {

        $('.comm-hov').on('click', function() {
            $('.comm-hov').toggleClass('comm-click');
        });

        $('.team-hov').on('click', function() {
            $('.team-hov').toggleClass('team-click');
        });

        $('.critical-hov').on('click', function() {
            $('.critical-hov').toggleClass('critical-click');
        });

        $('.professionalism-hov').on('click', function() {
            $('.professionalism-hov').toggleClass('professionalism-click');
        });

        $('.equity-hov').on('click', function() {
            $('.equity-hov').toggleClass('equity-click');
        });

        $('.tech-hov').on('click', function() {
            $('.tech-hov').toggleClass('tech-click');
        });

        $('.career-hov').on('click', function() {
            $('.career-hov').toggleClass('career-click');
        });

        $('.leadership-hov').on('click', function() {
            $('.leadership-hov').toggleClass('leadership-click');
        });


    });
    </script>

    <!-- apexcharts init -->
    <script src="assets/js/pages/apexcharts.init.js"></script>
</body>

</html>