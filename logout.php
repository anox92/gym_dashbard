<?php

require_once 'db_config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    unset($_SESSION['admin_id']);
    header("Location: index.php");
    exit();
}