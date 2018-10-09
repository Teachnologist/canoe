<?php
include('../Controllers/MyController.php');
$inputs = new MyController();
$inputs->setKeyword("calculus");

$log = array();
$log["insert_log"] = NULL;


if($inputs->validate($_POST["choices"])){
    $log["insert_log"] = $inputs->post();
}


$log["message"] = $inputs->getMessage();
$log["controller_class"] = $inputs->why();

echo json_encode($log);
?>
