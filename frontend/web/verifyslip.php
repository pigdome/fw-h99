<?php
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/../../common/config/bootstrap.php';
require __DIR__ . '/../config/bootstrap.php';

use common\libs\Constants;

header('Content-type: application/json');

$endpoint = "https://www.tmweasy.com/api_verify_slip.php";

$qrcode = $_REQUEST['qrcode'];
$ref1  = $_REQUEST['ref1'];
$credit_id = $_REQUEST['credit_id'];

$params = array('username' => 'huay6666', 'password' => 'Met159753xx.', 'qrcode' => $qrcode, 'focus_bank' => '004', 'ip' => '49.229.127.232', 'ref1' => $ref1);

$url = $endpoint . '?' . http_build_query($params);

$json = file_get_contents($url);

$object = json_decode($json);

$status = "";
if ($object->status == 1) {
  $status = "✅ ถูกต้อง";
} else {
  $status = "❌ ไม่ถูกต้อง";
}

$msg =
  "ผลการตรวจสอบสลิป: " . $status .
  "\nสถานะการชำระเงิน: " . $object->msg .
  "\nเวลา: " . $object->slip_time .
  "\nชื่อบัญชี: " . $object->sender_data->name .
  "\nเลขที่บัญชี: " . $object->sender_data->acc_no .
  "\nธนาคาร: " . $object->sender_data->bank_name .
  "\nจำนวนเงินที่ได้รับ: " . $object->amount .
  "\nref1: " . $ref1;

Constants::notify($msg);

echo $json;
