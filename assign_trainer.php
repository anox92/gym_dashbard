<?php

include_once 'db_config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $members_id = $_POST['memberId'];
    $trainer_id = $_POST['trainerId'];
    $sql = "UPDATE members SET trainer_id = ? WHERE member_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii',$trainer_id,$members_id);
    
    $stmt->execute();

    $_SESSION['success_message'] = 'trainer successfully added to the member!';

    header('location: admin_dashboard.php');
}
