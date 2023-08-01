<?php

require_once "db_config.php";
require_once "fpdf/fpdf.php";

if($_SERVER['REQUEST_METHOD']=="POST"){
    
    $photo_path = $_POST['photo_path'];
    $member_id = $_POST['member_id'];
    $firs_name = $_POST['name'];
    $last_name = $_POST['l_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $trainer = $_POST['trainer_name'];
    $trainer_l_name = $_POST['trainer_l_name'];
    $training_plans_name = $_POST['training_plans_name'];
    $image = $photo_path;
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',20);
    // Move to the right
    $pdf->Cell(80);
    // Title
    $pdf->Cell(40,10,'Maple Gim');
    // Line break
    $pdf->Image($photo_path,  10, 10, 30, 30);
    $pdf->setFont('Arial', 'B', 12);
    $pdf->Cell(40,40, '');
    $pdf->Ln();
    $pdf->Cell(50,8, 'Access Card:');
    $pdf->Ln();
    $pdf->Cell(70,10, 'Member ID: ' . $member_id);
    $pdf->Ln();
    $pdf->Cell(70,10, 'Name: ' . $firs_name . " " . $last_name);
    $pdf->Ln();
    $pdf->Cell(70,10, 'E-email: ' . $email);
    $pdf->Ln();
    $pdf->Cell(70,10, 'Phone number: ' . $phone_number);
    $pdf->Ln();
    $pdf->Cell(70,10, 'Trainer name: ' . $trainer . " " . $trainer_l_name);
    $pdf->Ln();
    $pdf->Cell(70,10, 'Training plans: ' . $training_plans_name);

    $filename = 'access_card/'. $firs_name . " " . $last_name . " " .'.pdf';
    $pdf->Output('D', $filename);

    $sql = "UPDATE members SET access_card_pdf_path = '$filename' WHERE member_id = $member_id";
    $conn->query($sql);
$conn->close();
}
