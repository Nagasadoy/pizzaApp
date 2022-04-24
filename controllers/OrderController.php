<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderRow;
use app\models\Pizza;
use app\models\User;
use Yii;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            $dataPost = Yii::$app->request->post();
            // Пользователь пока всегда первый
            $user = User::findOne(1);
            $pizzasId = $dataPost['Order']['pizzas'];

            // Создаем заказ 
            $newOrder = new Order();
            $newOrder->note = $dataPost['Order']['note'];
            $newOrder->user_id = $user->id;
            $newOrder->time = date('d-m-y h:i:s');

            if($newOrder->save()){
                $id = Yii::$app->db->getLastInsertID();
                // Создаем строки заказа
                foreach ($pizzasId as $pizzaId) {
                    $orderRow = new OrderRow();
                    $orderRow->pizza_id = $pizzaId;
                    $orderRow->order_id = $id;
                    $orderRow->save();
                }
            }

        }

        $allOrders = Order::find()->all();
        $modelOrder = new Order();
        $pizzas = Pizza::find()->all();
        return $this->render('index', [
            'modelOrder' => $modelOrder,
            'pizzas' => $pizzas,
            'allOrders' => $allOrders
        ]);
    }

}
