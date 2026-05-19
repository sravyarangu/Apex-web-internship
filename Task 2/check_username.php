<?php
header('Content-Type: application/json');
$u = '';
if(isset($_GET['username'])) $u = trim($_GET['username']);
$taken = array('admin','user','test','taken');
$resp = array('available' => true);
if($u === '' || in_array(strtolower($u), $taken)) $resp['available'] = false;
echo json_encode($resp);
?>
