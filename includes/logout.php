<?php
session_start(); 
session_destroy(); 

$indexPath = '../index.php';

header("Location: $indexPath?msg=logout");
?>