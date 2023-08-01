<?php 

require_once 'db_config.php';
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $member_id = $_POST['member_id'];
    $sql = "DELETE FROM members WHERE member_id = ?";
    $run = $conn->prepare($sql);
    $run->bind_param('i',$member_id);
    if($run -> execute()){
        $_SESSION['delete'] = "Item Deleted successfully";
        header('location: admin_dashboard.php');
    }else{
        $_SESSION['error_delete'] = "Item not deleted error ocured";
    }
}