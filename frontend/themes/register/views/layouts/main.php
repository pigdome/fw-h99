<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAssetRegister;
use yii\helpers\Url;


AppAssetRegister::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:url" content="<?= Url::base('https') ?>/frontend/web/user/login" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="HUAY99" />
    <meta property="og:description" content="หวย99 ออนไลน์ เว็บซื้อหวยออนไลน์ เรทจ่ายที่สุด สมัครง่ายๆ เว็บจ่ายจริง 100% ได้เงินแน่นอน แอดมินตอบไว ทันใจ ปลอดภัย 100%" />
    <meta property="og:image" content="<?= Url::base('https') ?>/img/fav.png" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <style type="text/css">
    	body {
		    background: #333 !important;
		    font-family: tahoma;
		    color: #ccc;
		}
    </style>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<div class="container">
		<div class="row">
    		<?=  $content ?>
		</div>
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
