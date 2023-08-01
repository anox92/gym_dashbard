<?php 

require_once 'db_config.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
   
   
    $firs_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];

    $sql = "INSERT INTO trainers (name,l_name, email,phone_number) VALUES (?,?,?,?)"; 

    $run = $conn->prepare($sql);
    $run->bind_param("ssss" , $firs_name,$last_name,$email,$phone_number);
    $run->execute();
    $_SESSION['success_add_trainer'] = "Trainer successfully added to the dashboad!";
    header("location: admin_dashboard.php");
    exit();
}