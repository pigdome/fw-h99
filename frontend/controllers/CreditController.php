<?php

namespace frontend\controllers;

use common\models\Credit;
use yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\PostCreditTransection;
use common\models\CreditTransection;
use common\models\CreditTransectionSearch;
use common\models\Commission;
use common\libs\Constants;


/**
 * Site controller
 */
class CreditController extends Controller
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionGetCreditBalance()
    {
        $user_id = \Yii::$app->user->id;
        $credit = Credit::findOne(['user_id' => $user_id]);
        if (!$credit) {
            return 0;
        }
        return $credit->balance;
    }

    public function actionApproveCredit()
    {
        $admin_id = 1;
        $reason_id = Constants::reason_credit_top_up;

        $credit_id = Yii::$app->request->get('credit_id');
        $amount = Yii::$app->request->get('amount');

        $requestModel = PostCreditTransection::findOne(['id' => $credit_id]);

        if (round($requestModel->amount, 2) != round($amount, 2)) {
            return "ยอดแจ้งฝากเงินไม่ตรงกับยอดเงินที่ได้รับ. โปรดติดต่อเจ้าหน้าที่";
        }

        // status is waiting
        if ($requestModel->status != Constants::status_waitting) {
            return "สถานะไม่ตรง. โปรดติดต่อเจ้าหน้าที่";
        }

        // check credit master
        $CreditMasterBalance = CreditTransectionSearch::checkCreditMasterBalance($requestModel->action_id, $reason_id, $requestModel->amount);
        if (!empty($CreditMasterBalance) && isset($CreditMasterBalance['amount']) && $CreditMasterBalance['amount'] < 0) {
            return 'ยอดเงินไม่พอ. โปรดติดต่อเจ้าหน้าที่';
        }

        // save
        $requestModel->remark = '';
        $requestModel->status = Constants::status_approve;
        $requestModel->save();
        // try catch?
        Credit::creditWalk($requestModel->action_id, $requestModel->poster_id, $admin_id, $reason_id, $requestModel->amount);

        Constants::notify("ตัดเงินสำเร็จ");
        return "ok";
    }
}
