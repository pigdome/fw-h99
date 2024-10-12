<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->registerJsFile(Yii::getAlias('@web/version6/js/index/cleave.js'), ['depends' => [\yii\web\JqueryAsset::className()]]); 
$this->registerJsFile(Yii::getAlias('@web/version6/js/index/settings.js?1565462336'), ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div id="section-content" class="container">
    <div class="bar-back">
        <a href="<?= Url::to(['setting/bank']) ?>">
            <i class="fas fa-chevron-left"></i> ย้อนกลับ</a>
    </div>
    <div class="p-2 w-100 bg-light_bkk main-content align-self-stretch"
         style="min-height: calc((100vh - 139.566px) - 50px);">
        <div class="bgwhitealpha text-secondary shadow-sm rounded p-2 px-2 xtarget col-lotto d-flex flex-row mb-1 pb-0">
            <div class="lotto-title w-100 d-flex justify-content-between">
                <div class="d-inline">
                    <h4 class="mr-1 d-inline"><i class="fas fa-folder-plus"></i> เพิ่มบัญชีธนาคาร</h4>
                    <small style="display:inline-block">(เติมเครดิตครั้งแรก และเพิ่มบัญชีธนาคารอื่นๆ)</small>
                </div>
                <div class="d-inline">
                    <a href="<?= Url::to(['setting/bank-status']) ?>" class="btn btn-primary btn-sm d-flex justify-content-around align-items-center">
                        <i class="fas fa-search"></i>
                        <span>เช็คสถานะบัญชี</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="bgwhitealpha text-secondary shadow-sm rounded p-2 px-2 xtarget col-lotto d-flex flex-row mb-5 pb-0">
            <?php
            $form = ActiveForm::begin([
                'options' => ['class' => 'col-12'],
                'method' => 'post',
            ]);
            ?>
            <div id="firsttime" style="display:block;">
                <div class="form-row">
                    <div class="col-12 col-sm-12 col-md-6">
                        <label><i class="fas fa-university"></i> เลือกธนาคาร</label>
                        <div class="border rounded mb-2">
                            <div class="dropdown bootstrap-select form-control">
                                <select class="selectpicker form-control" data-container="body" data-size="5" id="bank"
                                        name="UserHasBank[bank_id]" tabindex="-98">
                                    <option value="">กรุณาเลือกธนาคาร</option>
                                    <?php foreach ($arrBank as $bank) { ?>
                                        <option value="<?= $bank['id'] ?>"
                                                data-content="<img style='background:<?= $bank['color'] ?>;padding:2px;border-radius:2px;width:22px;' src='<?= Yii::getAlias('@web') . '/bank/' . $bank['icon'] ?>'><span><?= ucwords($bank['title']) ?></span> "></option>
                                    <?php } ?>
                                </select>
                                <div class="dropdown-menu " role="combobox">
                                    <div class="inner show" role="listbox" aria-expanded="false" tabindex="-1">
                                        <ul class="dropdown-menu inner show"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 mb-1">
                        <label><i class="fas fa-id-card"></i> ชื่อบัญชี</label>
                        <?= $form->field($model, 'bank_account_name')->textInput(['disabled' => true, 'value' => $userHasBank->bank_account_name])->label(false) ?>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 mb-1">
                        <label><i class="fas fa-clipboard-check"></i> เลขที่บัญชี</label>
                        <?= $form->field($model, 'bank_account_no',['options'=>[]])->label(false)?>
                        <small id="checkacc1"></small>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col pr-1">
                    <button class="btn btn-secondary btn-block" type="reset">ยกเลิก</button>
                </div>
                <div class="col pl-1">
                    <input type="submit" value="เพิ่มบัญชี" class="btn btn-success btn-block">
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Modal Qr code  -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bordrt">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">สแกนจ่ายด้วย QR code</h1>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <span class="text-danger">ชื่อบัญชี : <?= htmlspecialchars($config['web_slip_name']); ?></span><br>
                    <img id="qrcodegannew" src="test1.PNG" alt="qr" class="w-50 bordrt">
                    <img src="<?php echo htmlspecialchars($config['logo']); ?>" class="watermark" alt="watermark">
                    <br>
                    <span class="text-danger">จำนวนเงินที่ชำระ</span><br>
                    <h2 id="amount" class="text-danger"></h2>
                    <span class="text-danger">สแกน QR Code เพื่อจ่ายเงิน</span><br>
                    <span class="text-danger">กรุณาจ่ายเงินภายในเวลา</span>
                    <h4 class="text-danger" id="countdown"></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- เพิ่ม Script การจัดการ -->
<script>
    // ใส่ฟังก์ชัน JavaScript ต่างๆ เช่น การสร้าง QR Code, ตรวจสอบสถานะ, และการเริ่มต้น Countdown
</script>
