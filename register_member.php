<?php 
    require_once 'db_config.php';

    $sql = "INSERT INTO members (name,l_name, email,phone_number,photo_path,training_plans_id,trainer_id,access_card_pdf_path) 
            VALUES (?,?,?,?,?,?,?,?)";
    
   
    $firs_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone'];
    //image upload
    $targetFile = 'static/images/' . basename($_FILES["img"]["name"]);

    if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
      //file was successfully uploaded
    }
    //end of image upload
    $training_plans_id = $_POST['training_plans_id'];
    $trainer_id = 0;
    $access_card_pdf_path = "";
    $run = $conn->prepare($sql);
    $run->bind_param("sssssiis",$firs_name,$last_name,$email,$phone_number,$targetFile,$training_plans_id,$trainer_id,$access_card_pdf_path);
    $run->execute();


$_SESSION['success_message'] = "Request successfully submited!";
header("location: admin_dashboard.php");
exit();
