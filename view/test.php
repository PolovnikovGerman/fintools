<?php
$order_id='36024';
$poch='A';
require('../model/mysql.php');
require('../includes/utility_functions.php');
$obj = new db();
$qry = "select *, a.af_order_id as oid, b.ch_po as chpo, v.v_address as r2_ven_add
from af_child b
join af_master a on a.af_order_id=b.af_order_id
join af_r2 c on c.r2_id=b.ch_id
join af_vendor as v on v.v_id=c.r2_ven_id
where a.af_order_id={$order_id} and b.ch_po='{$poch}'";
$res = $obj->query($qry);
$data = $obj->fetch($res);
// af_child
$i=0;
$data['r2_grand_total']=0;
$qry="select * from af_r2_items itm where itm.r2_id={$data['r2_id']} order by r2i_id";
$res=$obj->query($qry);
while($dat1 = $obj->fetch($res) ) {
    $data['r2_itemid'.$i]=$dat1['r2i_itemid'];
    $data['r2_desc'.$i]=$dat1['r2i_desc'];
    $data['r2_qty'.$i]=$dat1['r2i_qty'];
    $data['r2_price'.$i]=$dat1['r2i_prc'];
    $data['r2_grand_total']+=(floatval($dat1['r2i_qty'])*floatval($dat1['r2i_prc']));
    $i++;
}
$data['r2_grand_total']=round($data['r2_grand_total'],2);
for ($j=$i; $j<=10; $j++) {
    $data['r2_itemid'.$j]=$data['r2_desc'.$j]=$data['r2_qty'.$j]=$data['r2_price'.$j]='';
}
$data['r2_bill']='t00000000000000000000';
// var_dump($data); die();
$newdoc=generate_testpdf($data);
echo $newdoc.PHP_EOL;

function generate_testpdf($details) {
    echo 'Open PDF FOR CREATE '.PHP_EOL;
    require('fpdf.php');
    setlocale(LC_MONETARY, "en_US");
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////PDF FOR 1 ADDRESS///////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if ($details['r2_d2_add'] == '' && $details['r2_d3_add'] == '') {
        echo 'Schema Line 47';
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetMargins(0.25, 0.25);

        $pdf->SetXY(5, 5);
        // $pdf->Image('../images/logo3.png', 5, 5, 55, 18);
        $pdf->Image('../images/login_newlogo.png',5,5,55,18);
//items bg
        $pdf->Image('../images/items_bg.png', 51, 140, 156, 86);
//black boxes
        $pdf->Image('../images/bt_bg.png', 170, 15, 32, 10);
        $pdf->Image('../images/shdate_bg.png', 15, 43, 45, 8);
        $pdf->Image('../images/art_bg.png', 4, 167, 44, 57);
        $pdf->Image('../images/total_bg.png', 175, 227, 32, 8);
        $pdf->Image('../images/pay_bg.png', 160, 245, 48, 13);
        $pdf->Image('../images/msg_bg.png', 15, 231, 131, 13);

        $pdf->SetXY(138, 4);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', '16');
        $pdf->Cell(60, 10, 'Official Purchase Order');
//creating number bullets
        $pdf->Image('../images/circle_bg.png', 140, 15, 9, 9);
        $pdf->SetXY(142, 15);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '1');

        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(20, 10, 'PO #');
        $pdf->SetTextColor(0);
        $pdf->Cell(30, 10, 'BT' . $details['oid'] . $details['chpo'], 0, 0, 'C');
        $pdf->SetXY(57, 22);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(20, 5, 'asi/141984');
        $pdf->SetXY(176, 25);
        $pdf->Cell(10, 5, 'Date');

        $pdf->setTextColor(0);
        $pdf->Cell(15, 5, date('m/d/y',strtotime($details['r2_date'])));

        $pdf->SetXY(8, 25);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(30, 5, '855 Bloomfield Ave');

        $pdf->SetXY(6, 30);
        $pdf->SetFont('Arial', 'B', '11');
        $pdf->Cell(30, 5, 'Clifton, NJ 07012 USA');

        $pdf->SetXY(6, 35);
        $pdf->SetFont('Arial', '', 9);
        $bull = '&bull;';
        $pdf->Cell(75, 5, 'Tel: 201-902-9960 | Fax: 201-604-2688');

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 43, 9, 9);
        $pdf->SetXY(6, 43);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '2');

//Ship Date
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(15, 43);
        $pdf->Cell(45, 8, 'Ship Date:');
        $pdf->SetXY(40, 43);
        $pdf->SetTextColor(0);
        $pdf->Cell(15, 8, date('m/d/y',strtotime($details['r2_ship_date'])));

//Vendor & Address
        $pdf->SetXY(115, 32);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(19, 8, 'Vendor: ');
        $pdf->Rect(135, 32, 66, 25, 'D');

        $pdf->SetXY(136, 32);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(64, 5, $details['r2_ven_add'], 0, 'L');


//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 58, 9, 9);
        $pdf->SetXY(6, 58);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '3');

//Ship Location 1
        $pdf->SetFont('Arial', 'BI', 15);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(15, 59);
        $pdf->Cell(45, 8, 'Ship Location 1:');

//rectangles for ship locations
        $pdf->Rect(4, 68, 65, 65, 'D');
//$pdf->Rect(73,68,65,65,'D');
//$pdf->Rect(142,68,65,65,'D');
//shipmethod Data inside location rectangles -1
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(5, 70);
        $pdf->Cell(25, 5, 'Ship Method:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(40, 5, $details['r2_d1_type']);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(10, 76);
        $pdf->Cell(20, 5, 'Due Date:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(20, 5, date('d/m/y',strtotime($details['r2_d1_date'])));
        $pdf->SetXY(10, 82);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(20, 5, 'Ship Acct:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(35, 5, $details['r2_ship_act']);
        $pdf->Image('../images/add_cover.png', 7, 89, 60, 41);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(8, 100);
        $pdf->MultiCell(58, 5, $details['r2_d1_add']);

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 140, 9, 9);
        $pdf->SetXY(6, 140);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '4');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(15, 139);
        $pdf->Cell(31, 8, 'Order Details:');

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 156, 9, 9);
        $pdf->SetXY(6, 156);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '5');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(15, 156);
        $pdf->Cell(10, 8, 'Art');


//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 150, 227, 9, 9);
        $pdf->SetXY(152, 227);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '8');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(160, 227);
        $pdf->Cell(15, 8, 'Total:');
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor(0);
        $pdf->SetXY(176, 228);
        $pdf->Cell(31, 7, '$' . number_format($details['r2_grand_total'],2,'.',''), 0, 0, 'R');



//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 150, 245, 9, 9);
        $pdf->SetXY(152, 245);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '9');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(160, 240);
        $pdf->Cell(22, 5, 'Payment:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 13);
        $exp = substr($details['r2_bill'], 1, 4);
        $cd = substr($details['r2_bill'], 5);
        $type = substr($details['r2_bill'], 0, 1);
        if ($type == 'z')
            $pdf->Cell(25, 5, 'Amex');
        else if ($type == 'y')
            $pdf->Cell(25, 5, 'MasterCard');
        else if ($type == 'x')
            $pdf->Cell(25, 5, 'Visa');
        else if ($type == 'o')
            $pdf->Cell(25, 5, 'Other');
        else if ($type == 'c')
            $pdf->Cell(25, 5, 'Check');
        else if ($type == 't')
            $pdf->Cell(25, 5, 'Terms');
        else
            $pdf->Cell(25, 5, 'Other');
//payamount
        if ($type != 'a') {
            $pdf->SetXY(161, 246);
            $pdf->SetFont('Arial', '', 12);
            if ($type == 'z')
                $pdf->Cell(45, 6, substr($cd, 0, 4) . "-" . substr($cd, 4, 6) . "-" . substr($cd, 10, 5), 0, 0, 'R');
            else
                $pdf->Cell(45, 6, substr($cd, 0, 4) . "-" . substr($cd, 4, 4) . "-" . substr($cd, 8, 4) . "-" . substr($cd, 12), 0, 0, 'R');
            $pdf->SetXY(161, 251);
            $pdf->Cell(45, 6, substr($exp, 0, 2) . "/" . substr($exp, 2), 0, 0, 'R');
        }

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 150, 262, 9, 9);
        $pdf->SetXY(150, 262);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '10');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(160, 261);
        $pdf->Cell(22, 5, 'Confirmation:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', '', 10.5);
        $pdf->SetXY(160, 266);
        $pdf->MultiCell(50, 5, 'Please click the link on our PO email to confirm this.', 0, 'L');





//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 5, 227, 9, 9);
        $pdf->SetXY(7, 227);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '6');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(13, 225);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(40, 5, ' Message:');
        $pdf->SetXY(15, 232);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(134, 4, $details['r2_ven_msg'], 0, 'L');


//displaying items qty etc
        $pdf->SetFont('Arial', 'B', 11);
        $mark = 141;
        for ($i = 0; $i < 10; $i++) {
            $mark+=8;
            $pdf->SetXY(52, $mark);
            $pdf->Cell(18, 4, $details['r2_qty' . $i], 0, 0, 'C');
            $pdf->Cell(91, 4, $details['r2_desc' . $i], 0, 0, 'L');
            if ($details['r2_qty' . $i] > 0)
                $pdf->Cell(21, 4, "$" . $details['r2_price' . $i], 0, 0, 'C');
            if (is_numeric($details['r2_qty' . $i]) && is_numeric($details['r2_price' . $i])) {
//$x = $details['r2_price'.$i] * $details['r2_qty'.$i];
//MONEY_FORMAT WILL NOT WORK ON YOUR SYSTEM, DOESNOT WORK ON WINDOWS OS
                $x = money_format("%(#1n", $details['r2_price' . $i] * $details['r2_qty' . $i]);
                $pdf->Cell(25, 4, $x, 0, 0, 'R');
            }
            else
                $pdf->Cell(25, 4, '', 0, 0, 'R');
        }

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 5, 247, 9, 9);
        $pdf->SetXY(7, 247);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '7');
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0);
        $pdf->SetXY(13, 247);
        $pdf->MultiCell(134, 4, "                  By accepting this order you agree to the terms listed here. All orders must be shipped blind & on our account  with PO# as reference. No overage or underage is allowed & no fee will be paid. For shipments going outside the U.S. all duties and taxes must be charged to the recipient & you must call us to get authorized pricing info to put on the docs. We are only responsible for charges on this PO. If a change is needed you must contact us to get it approved in writing. This PO supercedes any conflict from your catalog.");
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(13, 246);
        $pdf->Cell(17, 5, 'Terms :');


//art text message
        $pdf->SetXY(5, 168);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(42, 5, "Artwork should be on the PO email. It is also available online at bluetrack.net/vendors\n\n Simply enter username and password emailed to you to access this and any other art. No proof needed. Just match our art exactly.", 0, 'L');
        $save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT" . $details['oid'] . $details['chpo'] . "_new.pdf";
        $pdf->Output($save_name, 'F');
        // $pdf->Output();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////PDF FOR 2 ADDRESS//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
    else if ($details['r2_d3_add'] == '') {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetMargins(0.25, 0.25);

        $pdf->SetXY(5, 5);
        // $pdf->Image('../images/logo3.png', 5, 5, 55, 18);
        $pdf->Image('../images/login_newlogo.png',5,5,55,18);
//items bg
        $pdf->Image('../images/items_bg.png', 51, 140, 156, 86);
//black boxes
        $pdf->Image('../images/bt_bg.png', 170, 15, 32, 10);
        $pdf->Image('../images/shdate_bg.png', 15, 43, 45, 8);
        $pdf->Image('../images/art_bg.png', 4, 167, 44, 57);
        $pdf->Image('../images/total_bg.png', 175, 227, 32, 8);
        $pdf->Image('../images/pay_bg.png', 160, 245, 48, 13);
        $pdf->Image('../images/msg_bg.png', 15, 231, 131, 13);

        $pdf->SetXY(138, 4);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', '16');
        $pdf->Cell(60, 10, 'Official Purchase Order');
//creating number bullets
        $pdf->Image('../images/circle_bg.png', 140, 15, 9, 9);
        $pdf->SetXY(142, 15);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '1');

        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(20, 10, 'PO #');
        $pdf->SetTextColor(0);
        $pdf->Cell(30, 10, 'BT' . $details['oid'] . $details['chpo'], 0, 0, 'C');
        $pdf->SetXY(57, 22);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(20, 5, 'asi/141984');
        $pdf->SetXY(176, 25);
        $pdf->Cell(10, 5, 'Date');

        $pdf->setTextColor(0);
        $pdf->Cell(15, 5, $details['r2_date']);

        $pdf->SetXY(8, 25);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(30, 5, '855 Bloomfield Ave');

        $pdf->SetXY(6, 30);
        $pdf->SetFont('Arial', 'B', '11');
        $pdf->Cell(30, 5, 'Clifton, NJ 07012 USA');

        $pdf->SetXY(6, 35);
        $pdf->SetFont('Arial', '', 9);
        $bull = '&bull;';
        $pdf->Cell(75, 5, 'Tel: 201-902-9960 | Fax: 201-604-2688');

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 43, 9, 9);
        $pdf->SetXY(6, 43);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '2');

//Ship Date
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(15, 43);
        $pdf->Cell(45, 8, 'Ship Date:');
        $pdf->SetXY(40, 43);
        $pdf->SetTextColor(0);
        $pdf->Cell(15, 8, $details['r2_ship_date']);

//Vendor & Address
        $pdf->SetXY(115, 32);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(19, 8, 'Vendor: ');
        $pdf->Rect(135, 32, 66, 25, 'D');

        $pdf->SetXY(136, 32);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(64, 5, $details['r2_ven_add'], 0, 'L');


//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 58, 9, 9);
        $pdf->SetXY(6, 58);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '3');

//Ship Location 1
        $pdf->SetFont('Arial', 'BI', 15);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(15, 59);
        $pdf->Cell(45, 8, 'Ship Location 1:');

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 74, 58, 9, 9);
        $pdf->SetXY(76, 58);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '4');

//Ship Location 2
        $pdf->SetFont('Arial', 'BI', 15);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(85, 59);
        $pdf->Cell(45, 8, 'Ship Location 2:');

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
        $pdf->Rect(4, 68, 65, 65, 'D');
        $pdf->Rect(73, 68, 65, 65, 'D');
//$pdf->Rect(142,68,65,65,'D');
//shipmethod Data inside location rectangles -1
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(5, 70);
        $pdf->Cell(25, 5, 'Ship Method:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(40, 5, $details['r2_d1_type']);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(10, 76);
        $pdf->Cell(20, 5, 'Due Date:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(20, 5, $details['r2_d1_date']);
        $pdf->SetXY(10, 82);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(20, 5, 'Ship Acct:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(35, 5, $details['r2_ship_act']);
        $pdf->Image('../images/add_cover.png', 7, 89, 60, 41);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(8, 100);
        $pdf->MultiCell(58, 5, $details['r2_d1_add']);


//shipmethod Data inside location rectangles -2
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(74, 70);
        $pdf->Cell(25, 5, 'Ship Method:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(40, 5, $details['r2_d2_type']);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(79, 76);
        $pdf->Cell(20, 5, 'Due Date:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(20, 5, $details['r2_d2_date']);
        $pdf->SetXY(79, 82);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(20, 5, 'Ship Acct:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(35, 5, $details['r2_ship_act']);
        $pdf->Image('../images/add_cover.png', 76, 89, 60, 41);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(77, 100);
        $pdf->MultiCell(58, 5, $details['r2_d2_add']);

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 140, 9, 9);
        $pdf->SetXY(6, 140);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '5');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(15, 139);
        $pdf->Cell(31, 8, 'Order Details:');

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 156, 9, 9);
        $pdf->SetXY(6, 156);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '6');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(15, 156);
        $pdf->Cell(10, 8, 'Art');


//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 150, 227, 9, 9);
        $pdf->SetXY(152, 227);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '9');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(160, 227);
        $pdf->Cell(15, 8, 'Total:');
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor(0);
        $pdf->SetXY(176, 228);
        $pdf->Cell(31, 7, '$' . $details['r2_grand_total'], 0, 0, 'R');





//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 150, 245, 9, 9);
        $pdf->SetXY(150, 245);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '10');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(160, 240);
        $pdf->Cell(22, 5, 'Payment:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 13);
        $exp = substr($details['r2_bill'], 1, 4);
        $cd = substr($details['r2_bill'], 5);
        $type = substr($details['r2_bill'], 0, 1);
        if ($type == 'z')
            $pdf->Cell(25, 5, 'Amex');
        else if ($type == 'y')
            $pdf->Cell(25, 5, 'MasterCard');
        else if ($type == 'x')
            $pdf->Cell(25, 5, 'Visa');
        else if ($type == 'o')
            $pdf->Cell(25, 5, 'Other');
        else if ($type == 'c')
            $pdf->Cell(25, 5, 'Check');
        else if ($type == 't')
            $pdf->Cell(25, 5, 'Terms');
        else
            $pdf->Cell(25, 5, 'Other');
//payamount
        if ($type != 'a') {
            $pdf->SetXY(161, 246);
            $pdf->SetFont('Arial', '', 12);
            if ($type == 'z')
                $pdf->Cell(45, 6, substr($cd, 0, 4) . "-" . substr($cd, 4, 6) . "-" . substr($cd, 10, 5), 0, 0, 'R');
            else
                $pdf->Cell(45, 6, substr($cd, 0, 4) . "-" . substr($cd, 4, 4) . "-" . substr($cd, 8, 4) . "-" . substr($cd, 12), 0, 0, 'R');
            $pdf->SetXY(161, 251);
            $pdf->Cell(45, 6, substr($exp, 0, 2) . "/" . substr($exp, 2), 0, 0, 'R');
        }

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 150, 262, 9, 9);
        $pdf->SetXY(150, 262);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '11');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(160, 261);
        $pdf->Cell(22, 5, 'Confirmation:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', '', 10.5);
        $pdf->SetXY(160, 266);
        $pdf->MultiCell(50, 5, 'Please click the link on our PO email to confirm this.', 0, 'L');





//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 5, 227, 9, 9);
        $pdf->SetXY(7, 227);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '7');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(13, 225);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(40, 5, ' Message:');
        $pdf->SetXY(15, 232);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(134, 4, $details['r2_ven_msg'], 0, 'L');


//displaying items qty etc
        $pdf->SetFont('Arial', 'B', 11);
        $mark = 141;
        for ($i = 0; $i < 10; $i++) {
            $mark+=8;
            $pdf->SetXY(52, $mark);
            $pdf->Cell(18, 4, $details['r2_qty' . $i], 0, 0, 'C');
            $pdf->Cell(91, 4, $details['r2_desc' . $i], 0, 0, 'L');
            if ($details['r2_qty' . $i] > 0)
                $pdf->Cell(21, 4, "$" . $details['r2_price' . $i], 0, 0, 'C');
            if (is_numeric($details['r2_qty' . $i]) && is_numeric($details['r2_price' . $i])) {
//$x=$details['r2_price'.$i] * $details['r2_qty'.$i];
                $x = money_format("%(#1n", $details['r2_price' . $i] * $details['r2_qty' . $i]);
                $pdf->Cell(25, 4, $x, 0, 0, 'R');
            }
            else
                $pdf->Cell(25, 4, '', 0, 0, 'R');
        }

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 5, 247, 9, 9);
        $pdf->SetXY(7, 247);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '8');
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0);
        $pdf->SetXY(13, 247);
        $pdf->MultiCell(134, 4, "                  By accepting this order you agree to the terms listed here. All orders must be shipped blind & on our account (if listed) with PO# as reference. No overage or underage is allowed & no fee will be paid. For shipments going outside the U.S. all duties and taxes must be charged to the recipient & you must call us to get authorized pricing info to put on the docs. We are only responsible for charges on this PO. If a change is needed you must contact us to get it approved in writing. This PO supercedes any conflict from your catalog.");
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(13, 246);
        $pdf->Cell(17, 5, 'Terms :');


//art text message
        $pdf->SetXY(5, 168);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(42, 5, "Artwork should be on the PO email. It is also available online at bluetrack.com/vendors\n\n Simply enter username and password emailed to you to access this and any other art. No proof needed. Just match our art exactly.", 0, 'L');
        $save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT" . $details['oid'] . $details['chpo'] . "_new.pdf";
        $pdf->Output($save_name, 'F');
        // $pdf->Output();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////PDF FOR 3 ADDRESS//////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
    else {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetMargins(0.25, 0.25);

        $pdf->SetXY(5, 5);
        // $pdf->Image('../images/logo3.png', 5, 5, 55, 18);
        $pdf->Image('../images/login_newlogo.png',5,5,55,18);
//items bg
        $pdf->Image('../images/items_bg.png', 51, 140, 156, 86);
//black boxes
        $pdf->Image('../images/bt_bg.png', 170, 15, 32, 10);
        $pdf->Image('../images/shdate_bg.png', 15, 43, 45, 8);
        $pdf->Image('../images/art_bg.png', 4, 167, 44, 57);
        $pdf->Image('../images/total_bg.png', 175, 227, 32, 8);
        $pdf->Image('../images/pay_bg.png', 160, 245, 48, 13);
        $pdf->Image('../images/msg_bg.png', 15, 231, 131, 13);

        $pdf->SetXY(138, 4);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', '16');
        $pdf->Cell(60, 10, 'Official Purchase Order');
//creating number bullets
        $pdf->Image('../images/circle_bg.png', 140, 15, 9, 9);
        $pdf->SetXY(142, 15);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '1');

        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(20, 10, 'PO #');
        $pdf->SetTextColor(0);
        $pdf->Cell(30, 10, 'BT' . $details['oid'] . $details['chpo'], 0, 0, 'C');
        $pdf->SetXY(57, 22);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(20, 5, 'asi/141984');
        $pdf->SetXY(176, 25);
        $pdf->Cell(10, 5, 'Date');

        $pdf->setTextColor(0);
        $pdf->Cell(15, 5, $details['r2_date']);

        $pdf->SetXY(8, 25);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(30, 5, '855 Bloomfield Ave');

        $pdf->SetXY(6, 30);
        $pdf->SetFont('Arial', 'B', '11');
        $pdf->Cell(30, 5, 'Clifton, NJ 07012 USA');

        $pdf->SetXY(6, 35);
        $pdf->SetFont('Arial', '', 9);
        $bull = '&bull;';
        $pdf->Cell(75, 5, 'Tel: 201-902-9960 | Fax: 201-604-2688');

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 43, 9, 9);
        $pdf->SetXY(6, 43);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '2');

//Ship Date
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(15, 43);
        $pdf->Cell(45, 8, 'Ship Date:');
        $pdf->SetXY(40, 43);
        $pdf->SetTextColor(0);
        $pdf->Cell(15, 8, $details['r2_ship_date']);

//Vendor & Address
        $pdf->SetXY(115, 32);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->Cell(19, 8, 'Vendor: ');
        $pdf->Rect(135, 32, 66, 25, 'D');

        $pdf->SetXY(136, 32);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(64, 5, $details['r2_ven_add'], 0, 'L');


//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 58, 9, 9);
        $pdf->SetXY(6, 58);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '3');

//Ship Location 1
        $pdf->SetFont('Arial', 'BI', 15);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(15, 59);
        $pdf->Cell(45, 8, 'Ship Location 1:');

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 74, 58, 9, 9);
        $pdf->SetXY(76, 58);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '4');

//Ship Location 2
        $pdf->SetFont('Arial', 'BI', 15);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(85, 59);
        $pdf->Cell(45, 8, 'Ship Location 2:');


//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 144, 58, 9, 9);
        $pdf->SetXY(146, 58);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '5');

//Ship Location 3
        $pdf->SetFont('Arial', 'BI', 15);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(155, 59);
        $pdf->Cell(45, 8, 'Ship Location 3:');

//rectangles for ship locations
        $pdf->Rect(4, 68, 65, 65, 'D');
        $pdf->Rect(73, 68, 65, 65, 'D');
        $pdf->Rect(142, 68, 65, 65, 'D');

//shipmethod Data inside location rectangles -1
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(5, 70);
        $pdf->Cell(25, 5, 'Ship Method:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(40, 5, $details['r2_d1_type']);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(10, 76);
        $pdf->Cell(20, 5, 'Due Date:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(20, 5, $details['r2_d1_date']);
        $pdf->SetXY(10, 82);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(20, 5, 'Ship Acct:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(35, 5, $details['r2_ship_act']);
        $pdf->Image('../images/add_cover.png', 7, 89, 60, 41);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(8, 100);
        $pdf->MultiCell(58, 5, $details['r2_d1_add']);


//shipmethod Data inside location rectangles -2
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(74, 70);
        $pdf->Cell(25, 5, 'Ship Method:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(40, 5, $details['r2_d2_type']);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(79, 76);
        $pdf->Cell(20, 5, 'Due Date:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(20, 5, $details['r2_d2_date']);
        $pdf->SetXY(79, 82);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(20, 5, 'Ship Acct:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(35, 5, $details['r2_ship_act']);
        $pdf->Image('../images/add_cover.png', 76, 89, 60, 41);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(77, 100);
        $pdf->MultiCell(58, 5, $details['r2_d2_add']);


//shipmethod Data inside location rectangles -3
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(144, 70);
        $pdf->Cell(25, 5, 'Ship Method:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(40, 5, $details['r2_d3_type']);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(149, 76);
        $pdf->Cell(20, 5, 'Due Date:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(20, 5, $details['r2_d3_date']);
        $pdf->SetXY(149, 82);
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(20, 5, 'Ship Acct:');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetTextColor(0);
        $pdf->Cell(35, 5, $details['r2_ship_act']);
        $pdf->Image('../images/add_cover.png', 145, 89, 60, 41);
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(146, 100);
        $pdf->MultiCell(58, 5, $details['r2_d3_add']);


//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 140, 9, 9);
        $pdf->SetXY(6, 140);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '6');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(15, 139);
        $pdf->Cell(31, 8, 'Order Details:');

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 4, 156, 9, 9);
        $pdf->SetXY(6, 156);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '7');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(15, 156);
        $pdf->Cell(10, 8, 'Art');


//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 150, 227, 9, 9);
        $pdf->SetXY(150, 227);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '10');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(160, 227);
        $pdf->Cell(15, 8, 'Total:');
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor(0);
        $pdf->SetXY(176, 228);
        $pdf->Cell(31, 7, '$' . $details['r2_grand_total'], 0, 0, 'R');



        //creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 150, 245, 9, 9);
        $pdf->SetXY(150, 245);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '11');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(160, 240);
        $pdf->Cell(22, 5, 'Payment:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', 'B', 13);
        $exp = substr($details['r2_bill'], 1, 4);
        $cd = substr($details['r2_bill'], 5);
        $type = substr($details['r2_bill'], 0, 1);
        if ($type == 'z')
            $pdf->Cell(25, 5, 'Amex');
        else if ($type == 'y')
            $pdf->Cell(25, 5, 'MasterCard');
        else if ($type == 'x')
            $pdf->Cell(25, 5, 'Visa');
        else if ($type == 'o')
            $pdf->Cell(25, 5, 'Other');
        else if ($type == 'c')
            $pdf->Cell(25, 5, 'Check');
        else if ($type == 't')
            $pdf->Cell(25, 5, 'Terms');
        else
            $pdf->Cell(25, 5, 'Other');
        //payamount
        if ($type != 'a') {
            $pdf->SetXY(161, 246);
            $pdf->SetFont('Arial', '', 12);
            if ($type == 'z')
                $pdf->Cell(45, 6, substr($cd, 0, 4) . "-" . substr($cd, 4, 6) . "-" . substr($cd, 10, 5), 0, 0, 'R');
            else
                $pdf->Cell(45, 6, substr($cd, 0, 4) . "-" . substr($cd, 4, 4) . "-" . substr($cd, 8, 4) . "-" . substr($cd, 12), 0, 0, 'R');
            $pdf->SetXY(161, 251);
            $pdf->Cell(45, 6, substr($exp, 0, 2) . "/" . substr($exp, 2), 0, 0, 'R');
        }

        //creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 150, 262, 9, 9);
        $pdf->SetXY(150, 262);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '12');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(160, 261);
        $pdf->Cell(22, 5, 'Confirmation:');
        $pdf->SetTextColor(0);
        $pdf->SetFont('Arial', '', 10.5);
        $pdf->SetXY(160, 266);
        $pdf->MultiCell(50, 5, 'Please click the link on our PO email to confirm this.', 0, 'L');





        //creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 5, 227, 9, 9);
        $pdf->SetXY(7, 227);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '8');
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetXY(13, 225);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(40, 5, ' Message:');
        $pdf->SetXY(15, 232);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(134, 4, $details['r2_ven_msg'], 0, 'L');


        //displaying items qty etc
        $pdf->SetFont('Arial', 'B', 11);
        $mark = 141;
        for ($i = 0; $i < 10; $i++) {
            $mark+=8;
            $pdf->SetXY(52, $mark);
            $pdf->Cell(18, 4, $details['r2_qty' . $i], 0, 0, 'C');
            $pdf->Cell(91, 4, $details['r2_desc' . $i], 0, 0, 'L');
            if ($details['r2_qty' . $i] > 0)
                $pdf->Cell(21, 4, "$" . $details['r2_price' . $i], 0, 0, 'C');
            if (is_numeric($details['r2_qty' . $i]) && is_numeric($details['r2_price' . $i])) {
                //$x=$details['r2_price'.$i] * $details['r2_qty'.$i];
                $x = money_format("%(#1n", $details['r2_price' . $i] * $details['r2_qty' . $i]);
                $pdf->Cell(25, 4, $x, 0, 0, 'R');
            }
            else
                $pdf->Cell(25, 4, '', 0, 0, 'R');
        }

//creating number bullets
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('../images/circle_bg.png', 5, 247, 9, 9);
        $pdf->SetXY(7, 247);
        $pdf->SetTextColor(255);
        $pdf->Cell(10, 10, '9');
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0);
        $pdf->SetXY(13, 247);
        $pdf->MultiCell(134, 4, "                  By accepting this order you agree to the terms listed here. All orders must be shipped blind & on our account (if listed) with PO# as reference. No overage or underage is allowed & no fee will be paid. For shipments going outside the U.S. all duties and taxes must be charged to the recipient & you must call us to get authorized pricing info to put on the docs. We are only responsible for charges on this PO. If a change is needed you must contact us to get it approved in writing. This PO supercedes any conflict from your catalog.");
        $pdf->SetTextColor(0, 0, 255);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetXY(13, 246);
        $pdf->Cell(17, 5, 'Terms :');


        //art text message
        $pdf->SetXY(5, 168);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetTextColor(0);
        $pdf->MultiCell(42, 5, "Artwork should be on the PO email. It is also available online at bluetrack.com/vendors\n\n Simply enter username and password emailed to you to access this and any other art. No proof needed. Just match our art exactly.", 0, 'L');
        $save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT".$details['oid'].$details['chpo']."_new.pdf";
        $pdf->Output($save_name, 'F');
        // $pdf->Output();
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////END OF PRINTING PDF'S////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    }
    $save_name = "../docs/art_af_fl_uploads/poart/BLUETRACK_PO_BT" . $details['oid'] . $details['chpo']."_new.pdf";
    return $save_name;
}
?>
