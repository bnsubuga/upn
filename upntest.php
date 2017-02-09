<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
 include 'class_upn.php';
 
$location = new upn();

if (isset($_POST['lat'])){

$lat= $_POST['lat'];
$lng= $_POST['lng'];

echo $location->code($lng,$lat);
}

if (isset($_POST['upn'])){
$upn= $_POST['upn'];
echo $location->decode($upn);

}

?>