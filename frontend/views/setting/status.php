<?php
/* @var $userHasBank \common\models\UserHasBank */
use yii\helpers\Url;
?>
<div class="bar-back">
    <a href="<?= Url::to(['setting/bank']) ?>">
        <i class="fas fa-chevron-left"></i> บัญชีธนาคาร
    </a>
</div>

<div class="p-2 w-100 bg-light_bkk main-content align-self-stretch" style="min-height: calc((100vh - 140px) - 50px);">
    <div class="bgwhitealpha text-secondary shadow-sm rounded p-2 px-2 xtarget col-lotto d-flex flex-row justify-content-between mb-1 pb-0">
        <div class="lotto-title w-100 d-flex justify-content-between">
            <div class="d-inline">
                <h4 class="mr-1 d-inline">
                    <i class="fas fa-tasks"></i> สถานะบัญชีธนาคาร
                </h4>
            </div>
        </div>
    </div>
    <div class="bgwhitealpha text-secondary shadow-sm rounded xtarget col-lotto d-flex flex-column mb-5 pb-0">
        <?php foreach ($userHasBanks as $userHasBank) { ?>
            <div class="row px-3 addbankstatus mb-3">
                <div class="col-12 col-sm-12 px-0 table-dark rounded-top border border-secondary d-flex justify-content-between">
                    <div class="py-1 px-2 d-flex align-items-center">
                        <img class="bank-logo" style="background:<?= $userHasBank->bank->color ?>;" 
                             src="<?= Yii::getAlias('@web/bank/') . $userHasBank->bank->icon ?>">
                        <span class="ml-2"><?= $userHasBank->bank->title ?></span>
                    </div>
                    <?php 
                    // กำหนดสถานะและข้อความตามสถานะของบัญชีธนาคาร
                    switch ($userHasBank->status) {
                        case \common\libs\Constants::status_waitting:
                            $shotStatus = 'รออนุมัติ';
                            $status = 'บัญชีของท่านอยู่ระหว่างดำเนินการ';
                            $class = 'status-wait';
                            $icon = 'far fa-clock';
                            break;
                        case \common\libs\Constants::status_cancel:
                            $shotStatus = 'ไม่ผ่าน';
                            $status = 'บัญชีของท่านไม่ผ่านการตรวจสอบ กรุณาติดต่อ admin';
                            $class = 'status-cancel';
                            $icon = 'far fa-times-circle';
                            break;
                        default:
                            $shotStatus = 'ผ่าน';
                            $status = 'บัญชีของท่านได้รับการอนุมัติ';
                            $class = 'status-confirm';
                            $icon = 'far fa-check-circle';
                    }
                    ?>
                    <div class="status <?= $class ?> d-flex align-items-center">
                        <span class="status-icon"><i class="<?= $icon ?>"></i></span>
                        <small class="ml-1">สถานะ: </small>
                        <span class="ml-1"><?= $shotStatus ?></span>
                    </div>
                </div>
                <div class="col-12 rounded-bottom border border-top-0 border-secondary bg-light p-2">
                    <div class="row">
                        <div class="col-12 col-md-6 py-1">
                            <span class="text-info">ชื่อบัญชี: </span> <?= $userHasBank->bank_account_name ?>
                        </div>
                        <div class="col-12 col-md-6 py-1">
                            <span class="text-info">เลขที่บัญชี: </span> <?= $userHasBank->bank_account_no ?>
                        </div>
                        <div class="col-12 py-1 table-warning">
                            <i class="fas fa-comment-alt"></i> <?= $status ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="col-12 mb-3 mt-1">
            <a href="<?= Url::to(['post-credit-transection/create-topup']) ?>" class="btn btn-success d-flex justify-content-around align-items-center">
                <span><i class="fas fa-plus-square"></i> ฝากเงิน</span>
            </a>
        </div>
    </div>
</div>
