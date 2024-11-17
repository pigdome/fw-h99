<?php
header('Content-type: application/json');

$endpoint = "https://www.tmweasy.com/api_verify_slip.php";

$qrcode = $_REQUEST['qrcode'];
$ref1  = $_REQUEST['ref1'];
$amount = $_REQUEST['amount'];

$params = array('username' => 'huay6666', 'password' => 'Met159753xx.', 'qrcode' => $qrcode, 'focus_bank' => '006', 'ip' => '49.229.127.232', 'ref1' => $ref1);

$url = $endpoint . '?' . http_build_query($params);

$json = file_get_contents($url);

$object = json_decode($json);
if ($object->status == 1) {
  if ($object->amout != $amount) {
    $status = "❌ ไม่ถูกต้อง";
  } else {
    $status = "✅ ถูกต้อง";
  }
  $msg =
    "ผลการตรวจสอบ: " . $status .
    "\nสถานะการชำระเงิน: " . $object->msg .
    "\nเวลา: " . $object->slip_time .
    "\nชื่อบัญชี: " . $object->sender_data->name .
    "\nเลขที่บัญชี: " . $object->sender_data->acc_no .
    "\nธนาคาร: " . $object->sender_data->bank_name .
    "\nจำนวนเงินที่ได้รับ: " . $object->amount .
    "\nยอดแจ้งฝากเงิน(credit): " . $amount .
    "\nref1: " . $ref1;


  $bot_api_token = '7840375811:AAG-Qa6vlyFstnBaphfAFMd-cG7BkY-IjgY';
  $chat_id = '-4593520082';
  $query = http_build_query([
    'chat_id' => $chat_id,
    'text' => $msg,
  ]);
  $url = "https://api.telegram.org/bot{$bot_api_token}/sendMessage?{$query}";
  file_get_contents($url);
}

echo $json;
