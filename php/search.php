<?php
session_start();
include_once 'config.php';

$search_content = mysqli_real_escape_string($conn, $_POST['search_content']);

echo $search_content;
?>
