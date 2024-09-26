<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');


$base_url = "https://7gv0oagg0c.execute-api.us-east-1.amazonaws.com/dev/";
$filters = new stdClass();

// $filters->inventory_version = "";
// $filters->semester = "Fall 2024 - Spring 2025.";
$org = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $_GET['organization']);
$filters->org_name = $org;
if(isset($_GET['inventory'])){
$type = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $_GET['inventory']);
$filters->implementation_type =  $type;
}

$filter = json_encode($filters);

$data = new stdClass();
$data->filters = json_decode($filter);
$data->custom_questions = [];

// echo $_GET['organization'];

?>