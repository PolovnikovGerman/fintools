<?php
require('fpdf.php');
setlocale(LC_MONETARY, "en_US");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////PDF FOR 1 ADDRESS///////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($_POST['r2_d2_add'] == '' && $_POST['r2_d3_add'] == ''){
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$pdf->SetMargins(0.25,0.25);

$pdf->SetXY(5,5);
$pdf->Image('../images/logo3.png',5,5,55,18);
// $pdf->Image('../images/login_newlogo.png',5,5,55,18);
//items bg
$pdf->Image('../images/items_bg.png',51,140,156,86);
//black boxes
$pdf->Image('../images/bt_bg.png',170,15,32,10);
$pdf->Image('../images/shdate_bg.png',15,43,45,8);
$pdf->Image('../images/art_bg.png',4,167,44,57);
$pdf->Image('../images/total_bg.png',175,227,32,8);
$pdf->Image('../images/pay_bg.png',160,245,48,13);
$pdf->Image('../images/msg_bg.png',15,231,131,13);

$pdf->SetXY(138,4);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B','16');
$pdf->Cell(60,10,'Official Purchase Order');
//creating number bullets
$pdf->Image('../images/circle_bg.png',140,15,9,9);
$pdf->SetXY(142,15);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'1');

$pdf->SetTextColor(0,0,255);
$pdf->Cell(20,10,'PO #');
$pdf->SetTextColor(0);
$pdf->Cell(30,10,'BT'.$_POST['oid'].$_POST['chpo'],0,0,'C');
$pdf->SetXY(57,22);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,255);
$pdf->Cell(20,5,'asi/141984');
$pdf->SetXY(176,25);
$pdf->Cell(10,5,'Date');

$pdf->setTextColor(0);
$pdf->Cell(15,5,$_POST['r2_date']);

$pdf->SetXY(8, 25);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(30,5,'855 Bloomfield Ave');

$pdf->SetXY(6,30);
$pdf->SetFont('Arial','B','11');
$pdf->Cell(30,5,'Clifton, NJ 07012 USA');

$pdf->SetXY(6,35);
$pdf->SetFont('Arial','',9);
$bull = '&bull;';
$pdf->Cell(75,5,'Tel: 201-902-9960 | Fax: 201-604-2688');

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,43,9,9);
$pdf->SetXY(6,43);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'2');

//Ship Date
$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(15,43);
$pdf->Cell(45,8,'Ship Date:');
$pdf->SetXY(40,43);
$pdf->SetTextColor(0);
$pdf->Cell(15,8,$_POST['r2_ship_date']);

//Vendor & Address
$pdf->SetXY(115,32);
$pdf->SetTextColor(0,0,255);
$pdf->Cell(19,8,'Vendor: ');
$pdf->Rect(135,32,66,25,'D');

$pdf->SetXY(136,32);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->MultiCell(64,5,$_POST['r2_ven_add'],0,'L');


//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,58,9,9);
$pdf->SetXY(6,58);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'3');

//Ship Location 1
$pdf->SetFont('Arial','BI',15);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(15,59);
$pdf->Cell(45,8,'Ship Location 1:');
/*
//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',74,58,9,9);
$pdf->SetXY(76,58);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'4');

//Ship Location 2
$pdf->SetFont('Arial','BI',15);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(85,59);
$pdf->Cell(45,8,'Ship Location 2:');


//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',144,58,9,9);
$pdf->SetXY(146,58);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'5');

//Ship Location 3
$pdf->SetFont('Arial','BI',15);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(155,59);
$pdf->Cell(45,8,'Ship Location 3:');
*/
//rectangles for ship locations
$pdf->Rect(4,68,65,65,'D');
//$pdf->Rect(73,68,65,65,'D');
//$pdf->Rect(142,68,65,65,'D');

//shipmethod Data inside location rectangles -1
$pdf->SetFont('Arial','',11);
$pdf->SetXY(5,70);
$pdf->Cell(25,5,'Ship Method:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);
switch ($_POST['r2_d1_type']) {
    case 'NextDay':
        $vendship='NextDay';
        break;
    case 'NextDay AM':
        $vendship='Next Day Standard';
        break;
    case 'NextDay Early':
        $vendship='Next Day Early AM';
        break;
    default :
        $vendship=$_POST['r2_d1_type'];
        break;
}

$pdf->Cell(40,5, $vendship);
// $pdf->Cell(40,5,$_POST['r2_d1_type']);


$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(10,76);
$pdf->Cell(20,5,'Due Date:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(20,5,$_POST['r2_d1_date']);
$pdf->SetXY(10,82);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(20,5,'Ship Acct:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(35,5,$_POST['r2_ship_act']);
$pdf->Image('../images/add_cover.png',7,89,60,41);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(8,100);
$pdf->MultiCell(58,5,$_POST['r2_d1_add']);

/*
//shipmethod Data inside location rectangles -2
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(74,70);
$pdf->Cell(25,5,'Ship Method:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,5,$_POST['r2_d2_type']);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(79,76);
$pdf->Cell(20,5,'Due Date:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(20,5,$_POST['r2_d2_date']);
$pdf->SetXY(79,82);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(20,5,'Ship Acct:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(35,5,$_POST['r2_ship_act']);
$pdf->Image('../images/add_cover.png',76,89,60,41);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(77,100);
$pdf->MultiCell(58,5,$_POST['r2_d2_add']);


//shipmethod Data inside location rectangles -3
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(144,70);
$pdf->Cell(25,5,'Ship Method:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,5,$_POST['r2_d3_type']);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(149,76);
$pdf->Cell(20,5,'Due Date:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(20,5,$_POST['r2_d3_date']);
$pdf->SetXY(149,82);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(20,5,'Ship Acct:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(35,5,$_POST['r2_ship_act']);
$pdf->Image('../images/add_cover.png',145,89,60,41);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(146,100);
$pdf->MultiCell(58,5,$_POST['r2_d3_add']);

*/
//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,140,9,9);
$pdf->SetXY(6,140);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'4');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(15, 139);
$pdf->Cell(31,8,'Order Details:');

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,156,9,9);
$pdf->SetXY(6,156);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'5');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(15, 156);
$pdf->Cell(10,8,'Art');


//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',150,227,9,9);
$pdf->SetXY(152,227);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'8');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(160,227);
$pdf->Cell(15,8,'Total:');
$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(0);
$pdf->SetXY(176,228);
$pdf->Cell(31,7,'$'.$_POST['r2_grand_total'],0,0,'R');



//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',150,245,9,9);
$pdf->SetXY(152,245);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'9');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(160,240);
$pdf->Cell(22,5,'Payment:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);
$exp = substr($_POST['r2_bill'],1,4);
$cd = substr($_POST['r2_bill'],5);
$type = substr($_POST['r2_bill'],0,1);
if($type == 'z')
$pdf->Cell(25,5,'Amex');
else if($type == 'y')
$pdf->Cell(25,5,'MasterCard');
else if($type == 'x')
$pdf->Cell(25,5,'Visa');
else if($type == 'o')
$pdf->Cell(25,5,'Other');
else if($type == 'c')
$pdf->Cell(25,5,'Check');
else if($type == 't')
$pdf->Cell(25,5,'Terms');
else
$pdf->Cell(25,5,'Other');
//payamount
if($type!='a'){
$pdf->SetXY(161,246);
$pdf->SetFont('Arial','',12);
if($type == 'z')
$pdf->Cell(45,6,substr($cd,0,4)."-".substr($cd,4,6)."-".substr($cd,10,5),0,0,'R');
else
$pdf->Cell(45,6,substr($cd,0,4)."-".substr($cd,4,4)."-".substr($cd,8,4)."-".substr($cd,12),0,0,'R');
$pdf->SetXY(161,251);
$pdf->Cell(45,6,substr($exp,0,2)."/".substr($exp,2),0,0,'R');
}

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',150,262,9,9);
$pdf->SetXY(150,262);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'10');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(160,261);
$pdf->Cell(22,5,'Confirmation:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',10.5);
$pdf->SetXY(160,266);
$pdf->MultiCell(50,5,'Please click the link on our PO email to confirm this.',0,'L');





//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',5,227,9,9);
$pdf->SetXY(7,227);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'6');
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(13,225);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(40,5,' Message:');
$pdf->SetXY(15,232);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->MultiCell(134,4,$_POST['r2_ven_msg'],0,'L');


//displaying items qty etc
$pdf->SetFont('Arial','B',11);
$mark = 141;
for($i=0;$i<10;$i++)
{
$mark+=8;
$pdf->SetXY(52,$mark);
$pdf->Cell(18,4,$_POST['r2_qty'.$i],0,0,'C');
$pdf->Cell(91,4,$_POST['r2_desc'.$i],0,0,'L');
if($_POST['r2_qty'.$i] > 0)
$pdf->Cell(21,4,"$".$_POST['r2_price'.$i],0,0,'C');
if(is_numeric($_POST['r2_qty'.$i]) && is_numeric($_POST['r2_price'.$i]))
{
//$x = $_POST['r2_price'.$i] * $_POST['r2_qty'.$i];
//MONEY_FORMAT WILL NOT WORK ON YOUR SYSTEM, DOESNOT WORK ON WINDOWS OS
$x=money_format("%(#1n",$_POST['r2_price'.$i] * $_POST['r2_qty'.$i]);
$pdf->Cell(25,4,$x,0,0,'R');
}
else
$pdf->Cell(25,4,'',0,0,'R');
}

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',5,247,9,9);
$pdf->SetXY(7,247);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'7');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0);
$pdf->SetXY(13,247);
$pdf->MultiCell(134,4,"                  By accepting this order you agree to the terms listed here. All orders must be shipped blind & on our account  with PO# as reference. No overage or underage is allowed & no fee will be paid. For shipments going outside the U.S. all duties and taxes must be charged to the recipient & you must call us to get authorized pricing info to put on the docs. We are only responsible for charges on this PO. If a change is needed you must contact us to get it approved in writing. This PO supercedes any conflict from your catalog.");
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(13,246);
$pdf->Cell(17,5,'Terms :');


//art text message
$pdf->SetXY(5,168);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->MultiCell(42,5,"Artwork should be on the PO email. It is also available online at bluetrack.net/vendors\n\n Simply enter username and password emailed to you to access this and any other art. No proof needed. Just match our art exactly.",0,'L');
// Bt Print 
if ($_POST['r2_ven_id']=='184') {
    $pdf->AddPage();
    $pdf->SetXY(17, 7);
    $pdf->SetFont('Arial', 'BU', 16);
    $pdf->Cell(177, 12, 'Printing and Shipping Details',0,2,'C');
    $pdf->Image('../images/print_reports4.jpg', 17, 21, 177, 66);
    $pdf->Image('../images/print_reports4.jpg', 17, 90, 177, 66);
    $pdf->Image('../images/print_reports4.jpg', 17, 160, 177, 66);
}
$save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT".$_POST['oid'].$_POST['chpo'].".pdf";
$pdf->Output($save_name,'F');
// $pdf->Output();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////PDF FOR 2 ADDRESS//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else if($_POST['r2_d3_add'] == ''){
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$pdf->SetMargins(0.25,0.25);

$pdf->SetXY(5,5);
$pdf->Image('../images/logo3.png',5,5,55,18);
// $pdf->Image('../images/login_newlogo.png',5,5,55,18);
//items bg
$pdf->Image('../images/items_bg.png',51,140,156,86);
//black boxes
$pdf->Image('../images/bt_bg.png',170,15,32,10);
$pdf->Image('../images/shdate_bg.png',15,43,45,8);
$pdf->Image('../images/art_bg.png',4,167,44,57);
$pdf->Image('../images/total_bg.png',175,227,32,8);
$pdf->Image('../images/pay_bg.png',160,245,48,13);
$pdf->Image('../images/msg_bg.png',15,231,131,13);

$pdf->SetXY(138,4);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B','16');
$pdf->Cell(60,10,'Official Purchase Order');
//creating number bullets
$pdf->Image('../images/circle_bg.png',140,15,9,9);
$pdf->SetXY(142,15);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'1');

$pdf->SetTextColor(0,0,255);
$pdf->Cell(20,10,'PO #');
$pdf->SetTextColor(0);
$pdf->Cell(30,10,'BT'.$_POST['oid'].$_POST['chpo'],0,0,'C');
$pdf->SetXY(57,22);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,255);
$pdf->Cell(20,5,'asi/141984');
$pdf->SetXY(176,25);
$pdf->Cell(10,5,'Date');

$pdf->setTextColor(0);
$pdf->Cell(15,5,$_POST['r2_date']);

$pdf->SetXY(8, 25);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(30,5,'855 Bloomfield Ave');

$pdf->SetXY(6,30);
$pdf->SetFont('Arial','B','11');
$pdf->Cell(30,5,'Clifton, NJ 07012 USA');

$pdf->SetXY(6,35);
$pdf->SetFont('Arial','',9);
$bull = '&bull;';
$pdf->Cell(75,5,'Tel: 201-902-9960 | Fax: 201-604-2688');

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,43,9,9);
$pdf->SetXY(6,43);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'2');

//Ship Date
$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(15,43);
$pdf->Cell(45,8,'Ship Date:');
$pdf->SetXY(40,43);
$pdf->SetTextColor(0);
$pdf->Cell(15,8,$_POST['r2_ship_date']);

//Vendor & Address
$pdf->SetXY(115,32);
$pdf->SetTextColor(0,0,255);
$pdf->Cell(19,8,'Vendor: ');
$pdf->Rect(135,32,66,25,'D');

$pdf->SetXY(136,32);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->MultiCell(64,5,$_POST['r2_ven_add'],0,'L');


//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,58,9,9);
$pdf->SetXY(6,58);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'3');

//Ship Location 1
$pdf->SetFont('Arial','BI',15);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(15,59);
$pdf->Cell(45,8,'Ship Location 1:');

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',74,58,9,9);
$pdf->SetXY(76,58);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'4');

//Ship Location 2
$pdf->SetFont('Arial','BI',15);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(85,59);
$pdf->Cell(45,8,'Ship Location 2:');

/*
//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',144,58,9,9);
$pdf->SetXY(146,58);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'5');

//Ship Location 3
$pdf->SetFont('Arial','BI',15);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(155,59);
$pdf->Cell(45,8,'Ship Location 3:');
*/
//rectangles for ship locations
$pdf->Rect(4,68,65,65,'D');
$pdf->Rect(73,68,65,65,'D');
//$pdf->Rect(142,68,65,65,'D');

//shipmethod Data inside location rectangles -1
$pdf->SetFont('Arial','',11);
$pdf->SetXY(5,70);
$pdf->Cell(25,5,'Ship Method:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,5,$_POST['r2_d1_type']);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(10,76);
$pdf->Cell(20,5,'Due Date:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(20,5,$_POST['r2_d1_date']);
$pdf->SetXY(10,82);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(20,5,'Ship Acct:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(35,5,$_POST['r2_ship_act']);
$pdf->Image('../images/add_cover.png',7,89,60,41);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(8,100);
$pdf->MultiCell(58,5,$_POST['r2_d1_add']);


//shipmethod Data inside location rectangles -2
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(74,70);
$pdf->Cell(25,5,'Ship Method:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);

switch ($_POST['r2_d2_type']) {
    case 'NextDay':
        $vendship='NextDay';
        break;
    case 'NextDay AM':
        $vendship='Next Day Standard';
        break;
    case 'NextDay Early':
        $vendship='Next Day Early AM';
        break;
    default :
        $vendship=$_POST['r2_d2_type'];
        break;
}
$pdf->Cell(40,5,$vendship);
// $pdf->Cell(40,5,$_POST['r2_d2_type']);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(79,76);
$pdf->Cell(20,5,'Due Date:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(20,5,$_POST['r2_d2_date']);
$pdf->SetXY(79,82);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(20,5,'Ship Acct:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(35,5,$_POST['r2_ship_act']);
$pdf->Image('../images/add_cover.png',76,89,60,41);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(77,100);
$pdf->MultiCell(58,5,$_POST['r2_d2_add']);

/*
//shipmethod Data inside location rectangles -3
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(144,70);
$pdf->Cell(25,5,'Ship Method:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,5,$_POST['r2_d3_type']);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(149,76);
$pdf->Cell(20,5,'Due Date:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(20,5,$_POST['r2_d3_date']);
$pdf->SetXY(149,82);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(20,5,'Ship Acct:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(35,5,$_POST['r2_ship_act']);
$pdf->Image('../images/add_cover.png',145,89,60,41);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(146,100);
$pdf->MultiCell(58,5,$_POST['r2_d3_add']);

*/
//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,140,9,9);
$pdf->SetXY(6,140);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'5');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(15, 139);
$pdf->Cell(31,8,'Order Details:');

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,156,9,9);
$pdf->SetXY(6,156);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'6');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(15, 156);
$pdf->Cell(10,8,'Art');


//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',150,227,9,9);
$pdf->SetXY(152,227);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'9');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(160,227);
$pdf->Cell(15,8,'Total:');
$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(0);
$pdf->SetXY(176,228);
$pdf->Cell(31,7,'$'.$_POST['r2_grand_total'],0,0,'R');





//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',150,245,9,9);
$pdf->SetXY(150,245);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'10');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(160,240);
$pdf->Cell(22,5,'Payment:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);
$exp = substr($_POST['r2_bill'],1,4);
$cd = substr($_POST['r2_bill'],5);
$type = substr($_POST['r2_bill'],0,1);
if($type == 'z')
$pdf->Cell(25,5,'Amex');
else if($type == 'y')
$pdf->Cell(25,5,'MasterCard');
else if($type == 'x')
$pdf->Cell(25,5,'Visa');
else if($type == 'o')
$pdf->Cell(25,5,'Other');
else if($type == 'c')
$pdf->Cell(25,5,'Check');
else if($type == 't')
$pdf->Cell(25,5,'Terms');
else
$pdf->Cell(25,5,'Other');
//payamount
if($type!='a'){
$pdf->SetXY(161,246);
$pdf->SetFont('Arial','',12);
if($type == 'z')
$pdf->Cell(45,6,substr($cd,0,4)."-".substr($cd,4,6)."-".substr($cd,10,5),0,0,'R');
else
$pdf->Cell(45,6,substr($cd,0,4)."-".substr($cd,4,4)."-".substr($cd,8,4)."-".substr($cd,12),0,0,'R');
$pdf->SetXY(161,251);
$pdf->Cell(45,6,substr($exp,0,2)."/".substr($exp,2),0,0,'R');
}

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',150,262,9,9);
$pdf->SetXY(150,262);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'11');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(160,261);
$pdf->Cell(22,5,'Confirmation:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',10.5);
$pdf->SetXY(160,266);
$pdf->MultiCell(50,5,'Please click the link on our PO email to confirm this.',0,'L');





//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',5,227,9,9);
$pdf->SetXY(7,227);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'7');
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(13,225);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(40,5,' Message:');
$pdf->SetXY(15,232);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->MultiCell(134,4,$_POST['r2_ven_msg'],0,'L');


//displaying items qty etc
$pdf->SetFont('Arial','B',11);
$mark = 141;
for($i=0;$i<10;$i++)
{
$mark+=8;
$pdf->SetXY(52,$mark);
$pdf->Cell(18,4,$_POST['r2_qty'.$i],0,0,'C');
$pdf->Cell(91,4,$_POST['r2_desc'.$i],0,0,'L');
if($_POST['r2_qty'.$i] > 0)
$pdf->Cell(21,4,"$".$_POST['r2_price'.$i],0,0,'C');
if(is_numeric($_POST['r2_qty'.$i]) && is_numeric($_POST['r2_price'.$i]))
{
//$x=$_POST['r2_price'.$i] * $_POST['r2_qty'.$i];
$x=money_format("%(#1n",$_POST['r2_price'.$i] * $_POST['r2_qty'.$i]);
$pdf->Cell(25,4,$x,0,0,'R');
}
else
$pdf->Cell(25,4,'',0,0,'R');
}

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',5,247,9,9);
$pdf->SetXY(7,247);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'8');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0);
$pdf->SetXY(13,247);
$pdf->MultiCell(134,4,"                  By accepting this order you agree to the terms listed here. All orders must be shipped blind & on our account (if listed) with PO# as reference. No overage or underage is allowed & no fee will be paid. For shipments going outside the U.S. all duties and taxes must be charged to the recipient & you must call us to get authorized pricing info to put on the docs. We are only responsible for charges on this PO. If a change is needed you must contact us to get it approved in writing. This PO supercedes any conflict from your catalog.");
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(13,246);
$pdf->Cell(17,5,'Terms :');


//art text message
$pdf->SetXY(5,168);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->MultiCell(42,5,"Artwork should be on the PO email. It is also available online at bluetrack.com/vendors\n\n Simply enter username and password emailed to you to access this and any other art. No proof needed. Just match our art exactly.",0,'L');
if ($_POST['r2_ven_id']=='184') {
    $pdf->AddPage();
    $pdf->SetXY(17, 7);
    $pdf->SetFont('Arial', 'BU', 16);
    $pdf->Cell(177, 12, 'Printing and Shipping Details',0,2,'C');
    $pdf->Image('../images/print_reports4.jpg', 17, 21, 177, 66);
    $pdf->Image('../images/print_reports4.jpg', 17, 90, 177, 66);
    $pdf->Image('../images/print_reports4.jpg', 17, 160, 177, 66);
}
$save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT".$_POST['oid'].$_POST['chpo'].".pdf";
$pdf->Output($save_name,'F');
// $pdf->Output();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////PDF FOR 3 ADDRESS//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else
{
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
$pdf->SetMargins(0.25,0.25);

$pdf->SetXY(5,5);
$pdf->Image('../images/logo3.png',5,5,55,18);
// $pdf->Image('../images/login_newlogo.png',5,5,55,18);
//items bg
$pdf->Image('../images/items_bg.png',51,140,156,86);
//black boxes
$pdf->Image('../images/bt_bg.png',170,15,32,10);
$pdf->Image('../images/shdate_bg.png',15,43,45,8);
$pdf->Image('../images/art_bg.png',4,167,44,57);
$pdf->Image('../images/total_bg.png',175,227,32,8);
$pdf->Image('../images/pay_bg.png',160,245,48,13);
$pdf->Image('../images/msg_bg.png',15,231,131,13);

$pdf->SetXY(138,4);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B','16');
$pdf->Cell(60,10,'Official Purchase Order');
//creating number bullets
$pdf->Image('../images/circle_bg.png',140,15,9,9);
$pdf->SetXY(142,15);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'1');

$pdf->SetTextColor(0,0,255);
$pdf->Cell(20,10,'PO #');
$pdf->SetTextColor(0);
$pdf->Cell(30,10,'BT'.$_POST['oid'].$_POST['chpo'],0,0,'C');
$pdf->SetXY(57,22);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,255);
$pdf->Cell(20,5,'asi/141984');
$pdf->SetXY(176,25);
$pdf->Cell(10,5,'Date');

$pdf->setTextColor(0);
$pdf->Cell(15,5,$_POST['r2_date']);

$pdf->SetXY(8, 25);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(30,5,'855 Bloomfield Ave');

$pdf->SetXY(6,30);
$pdf->SetFont('Arial','B','11');
$pdf->Cell(30,5,'Clifton, NJ 07012 USA');

$pdf->SetXY(6,35);
$pdf->SetFont('Arial','',9);
$bull = '&bull;';
$pdf->Cell(75,5,'Tel: 201-902-9960 | Fax: 201-604-2688');

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,43,9,9);
$pdf->SetXY(6,43);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'2');

//Ship Date
$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(15,43);
$pdf->Cell(45,8,'Ship Date:');
$pdf->SetXY(40,43);
$pdf->SetTextColor(0);
$pdf->Cell(15,8,$_POST['r2_ship_date']);

//Vendor & Address
$pdf->SetXY(115,32);
$pdf->SetTextColor(0,0,255);
$pdf->Cell(19,8,'Vendor: ');
$pdf->Rect(135,32,66,25,'D');

$pdf->SetXY(136,32);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->MultiCell(64,5,$_POST['r2_ven_add'],0,'L');


//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,58,9,9);
$pdf->SetXY(6,58);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'3');

//Ship Location 1
$pdf->SetFont('Arial','BI',15);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(15,59);
$pdf->Cell(45,8,'Ship Location 1:');

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',74,58,9,9);
$pdf->SetXY(76,58);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'4');

//Ship Location 2
$pdf->SetFont('Arial','BI',15);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(85,59);
$pdf->Cell(45,8,'Ship Location 2:');


//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',144,58,9,9);
$pdf->SetXY(146,58);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'5');

//Ship Location 3
$pdf->SetFont('Arial','BI',15);
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(155,59);
$pdf->Cell(45,8,'Ship Location 3:');

//rectangles for ship locations
$pdf->Rect(4,68,65,65,'D');
$pdf->Rect(73,68,65,65,'D');
$pdf->Rect(142,68,65,65,'D');

//shipmethod Data inside location rectangles -1
$pdf->SetFont('Arial','',11);
$pdf->SetXY(5,70);
$pdf->Cell(25,5,'Ship Method:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,5,$_POST['r2_d1_type']);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(10,76);
$pdf->Cell(20,5,'Due Date:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(20,5,$_POST['r2_d1_date']);
$pdf->SetXY(10,82);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(20,5,'Ship Acct:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(35,5,$_POST['r2_ship_act']);
$pdf->Image('../images/add_cover.png',7,89,60,41);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(8,100);
$pdf->MultiCell(58,5,$_POST['r2_d1_add']);


//shipmethod Data inside location rectangles -2
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(74,70);
$pdf->Cell(25,5,'Ship Method:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,5,$_POST['r2_d2_type']);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(79,76);
$pdf->Cell(20,5,'Due Date:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(20,5,$_POST['r2_d2_date']);
$pdf->SetXY(79,82);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(20,5,'Ship Acct:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(35,5,$_POST['r2_ship_act']);
$pdf->Image('../images/add_cover.png',76,89,60,41);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(77,100);
$pdf->MultiCell(58,5,$_POST['r2_d2_add']);


//shipmethod Data inside location rectangles -3
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(144,70);
$pdf->Cell(25,5,'Ship Method:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',11);

switch ($_POST['r2_d3_type']) {
    case 'NextDay':
        $vendship='NextDay';
        break;
    case 'NextDay AM':
        $vendship='Next Day Standard';
        break;
    case 'NextDay Early':
        $vendship='Next Day Early AM';
        break;
    default :
        $vendship=$_POST['r2_d2_type'];
        break;
}
$pdf->Cell(40,5,$vendship);
// $pdf->Cell(40,5,$_POST['r2_d3_type']);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(149,76);
$pdf->Cell(20,5,'Due Date:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(20,5,$_POST['r2_d3_date']);
$pdf->SetXY(149,82);
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','',11);
$pdf->Cell(20,5,'Ship Acct:');
$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(0);
$pdf->Cell(35,5,$_POST['r2_ship_act']);
$pdf->Image('../images/add_cover.png',145,89,60,41);
$pdf->SetFont('Arial','',11);
$pdf->SetXY(146,100);
$pdf->MultiCell(58,5,$_POST['r2_d3_add']);


//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,140,9,9);
$pdf->SetXY(6,140);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'6');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(15, 139);
$pdf->Cell(31,8,'Order Details:');

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',4,156,9,9);
$pdf->SetXY(6,156);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'7');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(15, 156);
$pdf->Cell(10,8,'Art');


//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',150,227,9,9);
$pdf->SetXY(150,227);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'10');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(160,227);
$pdf->Cell(15,8,'Total:');
$pdf->SetFont('Arial','B',13);
$pdf->SetTextColor(0);
$pdf->SetXY(176,228);
$pdf->Cell(31,7,'$'.$_POST['r2_grand_total'],0,0,'R');



//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',150,245,9,9);
$pdf->SetXY(150,245);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'11');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(160,240);
$pdf->Cell(22,5,'Payment:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','B',13);
$exp = substr($_POST['r2_bill'],1,4);
$cd = substr($_POST['r2_bill'],5);
$type = substr($_POST['r2_bill'],0,1);
if($type == 'z')
$pdf->Cell(25,5,'Amex');
else if($type == 'y')
$pdf->Cell(25,5,'MasterCard');
else if($type == 'x')
$pdf->Cell(25,5,'Visa');
else if($type == 'o')
$pdf->Cell(25,5,'Other');
else if($type == 'c')
$pdf->Cell(25,5,'Check');
else if($type == 't')
$pdf->Cell(25,5,'Terms');
else
$pdf->Cell(25,5,'Other');
//payamount
if($type!='a'){
$pdf->SetXY(161,246);
$pdf->SetFont('Arial','',12);
if($type == 'z')
$pdf->Cell(45,6,substr($cd,0,4)."-".substr($cd,4,6)."-".substr($cd,10,5),0,0,'R');
else
$pdf->Cell(45,6,substr($cd,0,4)."-".substr($cd,4,4)."-".substr($cd,8,4)."-".substr($cd,12),0,0,'R');
$pdf->SetXY(161,251);
$pdf->Cell(45,6,substr($exp,0,2)."/".substr($exp,2),0,0,'R');
}

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',150,262,9,9);
$pdf->SetXY(150,262);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'12');
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(160,261);
$pdf->Cell(22,5,'Confirmation:');
$pdf->SetTextColor(0);
$pdf->SetFont('Arial','',10.5);
$pdf->SetXY(160,266);
$pdf->MultiCell(50,5,'Please click the link on our PO email to confirm this.',0,'L');





//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',5,227,9,9);
$pdf->SetXY(7,227);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'8');
$pdf->SetTextColor(0,0,255);
$pdf->SetXY(13,225);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(40,5,' Message:');
$pdf->SetXY(15,232);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->MultiCell(134,4,$_POST['r2_ven_msg'],0,'L');


//displaying items qty etc
$pdf->SetFont('Arial','B',11);
$mark = 141;
for($i=0;$i<10;$i++)
{
$mark+=8;
$pdf->SetXY(52,$mark);
$pdf->Cell(18,4,$_POST['r2_qty'.$i],0,0,'C');
$pdf->Cell(91,4,$_POST['r2_desc'.$i],0,0,'L');
if($_POST['r2_qty'.$i] > 0)
$pdf->Cell(21,4,"$".$_POST['r2_price'.$i],0,0,'C');
if(is_numeric($_POST['r2_qty'.$i]) && is_numeric($_POST['r2_price'.$i]))
{
//$x=$_POST['r2_price'.$i] * $_POST['r2_qty'.$i];
$x=money_format("%(#1n",$_POST['r2_price'.$i] * $_POST['r2_qty'.$i]);
$pdf->Cell(25,4,$x,0,0,'R');
}
else
$pdf->Cell(25,4,'',0,0,'R');
}

//creating number bullets
$pdf->SetFont('Arial','B',14);
$pdf->Image('../images/circle_bg.png',5,247,9,9);
$pdf->SetXY(7,247);
$pdf->SetTextColor(255);
$pdf->Cell(10,10,'9');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0);
$pdf->SetXY(13,247);
$pdf->MultiCell(134,4,"                  By accepting this order you agree to the terms listed here. All orders must be shipped blind & on our account (if listed) with PO# as reference. No overage or underage is allowed & no fee will be paid. For shipments going outside the U.S. all duties and taxes must be charged to the recipient & you must call us to get authorized pricing info to put on the docs. We are only responsible for charges on this PO. If a change is needed you must contact us to get it approved in writing. This PO supercedes any conflict from your catalog.");
$pdf->SetTextColor(0,0,255);
$pdf->SetFont('Arial','B',13);
$pdf->SetXY(13,246);
$pdf->Cell(17,5,'Terms :');


//art text message
$pdf->SetXY(5,168);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0);
$pdf->MultiCell(42,5,"Artwork should be on the PO email. It is also available online at bluetrack.com/vendors\n\n Simply enter username and password emailed to you to access this and any other art. No proof needed. Just match our art exactly.",0,'L');
if ($_POST['r2_ven_id']=='184') {
    $pdf->AddPage();
    $pdf->SetXY(17, 7);
    $pdf->SetFont('Arial', 'BU', 16);
    $pdf->Cell(177, 12, 'Printing and Shipping Details',0,2,'C');
    $pdf->Image('../images/print_reports4.jpg', 17, 21, 177, 66);
    $pdf->Image('../images/print_reports4.jpg', 17, 90, 177, 66);
    $pdf->Image('../images/print_reports4.jpg', 17, 160, 177, 66);
}
$save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT".$_POST['oid'].$_POST['chpo'].".pdf";
$pdf->Output($save_name,'F');
// $pdf->Output();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////END OF PRINTING PDF'S////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
$save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT".$_POST['oid'].$_POST['chpo'].".pdf";
require('../model/mysql.php');
require('../includes/utility_functions.php');
$error=array('flag'=>false);
$obj = new db();
$qry = "delete from af_attach where att_ch = ".$_POST['chid']." and att_type = 'poart'";
$res=$obj->query($qry);
if(!$res){
$error['flag']=true;
$error['msg'][]="delete from af_attach query failed for PO ".$_POST['oid'].$_POST['chpo']."<br>";
}

$qry = "insert into af_attach(att_ref, att_ch, att_path, att_name, att_type,att_datetime, att_edit) values(0,".$_POST['chid'].",'".$save_name."','BLUETRACK_PO_BT".$_POST['oid'].$_POST['chpo'].".pdf','poart',now(),".$_POST['chid'].")";
$res = $obj->query($qry);
if(!$res){
$error['flag']=true;
$error['msg'][]="insert into af_attach query failed for PO ".$_POST['oid'].$_POST['chpo']."<br>";
}
$qry="select count(*) as cnt from af_r2 where r2_id=".$_POST['chid'];
$res=$obj->query($qry);
$data = $obj->fetch($res);
if ($data['cnt']==0) {
    $sql="INSERT INTO af_r2 (r2_id, r2_ven_id, r2_date, r2_ven_msg, r2_ship_date,
            r2_ship_act, r2_d1_date, r2_d1_type, r2_d1_add, r2_d2_date,
            r2_d2_type, r2_d2_add, r2_d3_date, r2_d3_type,
            r2_d3_add, r2_histid, r2_datetime)
    VALUES (".$_POST['chid'].", ".$_POST['r2_ven_id'].", '" . format_date($_POST['r2_date']) . "', '" . mysql_real_escape_string($_POST['r2_ven_msg']) . "', '" . format_date($_POST['r2_ship_date']) . "',
        '" . $_POST['r2_ship_act'] . "','" . format_date($_POST['r2_d1_date']) . "',  '" . $_POST['r2_d1_type'] . "', '" . mysql_real_escape_string($_POST['r2_d1_add']) . "', '" . format_date($_POST['r2_d2_date']) . "',
        '" . $_POST['r2_d2_type'] . "', '" . mysql_real_escape_string($_POST['r2_d2_add']) . "', '" . format_date($_POST['r2_d3_date']) . "', '" . $_POST['r2_d3_type'] . "',
        '" . mysql_real_escape_string($_POST['r2_d3_add']) . "', 5, now())";
    $res = $obj->query($sql);
} else {
    $qry = "update af_r2 set
    r2_ven_id = ".$_POST['r2_ven_id'].",
    r2_date = '".format_date($_POST['r2_date'])."',
    r2_ven_msg = '".mysql_real_escape_string($_POST['r2_ven_msg'])."',
    r2_ship_date = '".format_date($_POST['r2_ship_date'])."',
    r2_ship_act = '".$_POST['r2_ship_act']."',
    r2_d1_date = '".format_date($_POST['r2_d1_date'])."',
    r2_d1_type = '".$_POST['r2_d1_type']."',
    r2_d1_add = '".mysql_real_escape_string($_POST['r2_d1_add'])."',
    r2_d2_date = '".format_date($_POST['r2_d2_date'])."',
    r2_d2_type = '".$_POST['r2_d2_type']."',
    r2_d2_add = '".mysql_real_escape_string($_POST['r2_d2_add'])."',
    r2_d3_date = '".format_date($_POST['r2_d3_date'])."',
    r2_d3_type = '".$_POST['r2_d3_type']."',
    r2_d3_add = '".mysql_real_escape_string($_POST['r2_d3_add'])."',
    r2_histid = 5,
    r2_datetime = now() where r2_id = ".$_POST['chid'];
    $res=$obj->query($qry);
}
if(!$res){
$error['flag']=true;
$error['msg'][]="update af_r2 query failed for PO ".$_POST['oid'].$_POST['chpo']."<br>";
}

$qry = "select v_abbr from af_vendor where v_id = ".$_POST['r2_ven_id'];
$res = $obj->query($qry);
if(!$res){
$error['flag']=true;
$error['msg'][]="select v_abbr query failed for PO ".$_POST['oid'].$_POST['chpo']."<br>";
}
$data = $obj->fetch($res);
$ch_rush_ck=(isset($_POST['ch_rush_ck']) ? $_POST['ch_rush_ck'] : 0);
$qry = "update af_child set ch_placed_ck = 'yes', ch_ship_date = '".format_date($_POST['r2_ship_date'])."', "
        . "ch_vendor = '".$data['v_abbr']."', ch_poTotal = ".$_POST['r2_grand_total'].", ch_active = 'on', "
        . "ch_printqty=".intval($_POST['ch_printqty']).","
        . "ch_printcolor='".$_POST['ch_printcolor']."', "
        . "ch_rush_ck = ".$ch_rush_ck.", "
        . "ch_itemcolor='".$_POST['ch_itemcolor']."' where ch_id = ".$_POST['chid'];
$res = $obj->query($qry);
if(!$res){
$error['flag']=true;
$error['msg'][]="update af_child query failed for PO ".$_POST['oid'].$_POST['chpo']."<br>";
}
if (intval($_POST['af_itemqty'])>0) {
    $qry = "update af_master set af_itemqty=".intval($_POST['af_itemqty'])." where af_order_id = ".$_POST['oid'];
    $res = $obj->query($qry);
    if(!$res){
        $error['flag']=true;
        $error['msg'][]="update af_master query failed for PO ".$_POST['oid']."<br>";
    }    
}

$last_id = $_POST['chid'];
$go=0;
$qry = "delete from af_r2_items where r2_id = $last_id";
$obj->query($qry);
 $qry = "insert into af_r2_items values";
for($i=0;$i<10;$i++)
{

if(!empty($_POST['r2_itemid'.$i]) && !empty($_POST['r2_desc'.$i]) )
{
 $_POST['r2_qty'.$i] = ($_POST['r2_qty'.$i] > 0 ) ?  $_POST['r2_qty'.$i] : 0 ;
 $_POST['r2_price'.$i] = ($_POST['r2_price'.$i] > 0 ) ? $_POST['r2_price'.$i] : 0.00;

$qry.="(null,$last_id, '".$_POST['r2_itemid'.$i]."','".$_POST['r2_desc'.$i]."',".$_POST['r2_qty'.$i].",".$_POST['r2_price'.$i]."),";
$go=1;
}
}

if($go){

 $qry = substr($qry,0, strlen($qry)-1);
$res = $obj->query($qry);
if(!$res){
$error['flag']=true;
$error['msg'][]="delete from af_attach query failed for PO ".$_POST['oid'].$_POST['chpo']."<br>";
}

}

$qry = "select * from af_vendor where v_id = '".$_POST['r2_ven_id']."'";
$res = $obj->query($qry);
$data2 = $obj->fetch($res);

$arr = array(); $arr2 = array();
$arr[0] = $save_name; $arr2[0] = "BLUETRACK_PO_BT".$_POST['oid'].$_POST['chpo'].".pdf";

if($_POST['chpo'] == 'A'){
$qry = "select att_path, att_name from af_attach where att_ref = ".$_POST['oid']." and att_type = 'art'";
$res = $obj->query($qry);
while($data = $obj->fetch($res)){
$arr[]=$data['att_path'];
$arr2[]=$data['att_name'];
}
}


$par=array($data2['v_name'],'BT'.$_POST['oid'].$_POST['chpo']);
$msg=emailTemplate('po',$par);
//tester email
//send_email_attach('bluetrack_niladhar@hotmail.com','Purchase Order #BT'.$_POST['oid'].$_POST['chpo'],$msg,$arr,$arr2);
//live email
// $to=$data2['v_email'];
// $to.=','.$data2['v_additional_email'];
if ($_SERVER['SERVER_NAME']=='fintool.dev') {
    $data2['v_email']='to_german@yahoo.com';    
    $data2['v_additional_email']='';
}
send_email_attach($data2['v_email'],'Purchase Order #BT'.$_POST['oid'].$_POST['chpo'],$msg,$arr,$arr2);
if ($data2['v_additional_email']!='') {
    send_email_attach($data2['v_additional_email'],'Purchase Order #BT'.$_POST['oid'].$_POST['chpo'],$msg,$arr,$arr2);
}
if($error['flag'])
{
$msg = implode(",",$error['msg']);
send_email_TEXT('niladhar8@gmail.com', 'Error on PO', $msg, $frm = 'error@bluetrack.com');

} else {
    $error['docfile']=$save_name;
}    
echo json_encode($error);

?>
