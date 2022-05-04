<?php

use app\models\Order;
use app\models\Pizza;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html as HelpersHtml;

// $dataProvider = new ActiveDataProvider([
//     'query' => Order::find()
//         ->joinWith('orderRows')
//         ->orderBy(['time' => SORT_DESC]),
//         // ->joinWith('pizzas'),
//         // ->joinWith('pizza', '"pizza".id = "order_row".pizza_id')
//         // ->with('user')
//         // ->with('orderRows'),

//     'pagination' => [
//         'pageSize' => 20,
//     ],
// ]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
        [
            'attribute' => 'time',
            'header' => 'Дата заказа',
            'format' =>  ['date', 'php:d.m.Y h:i:s'],
            'options' => ['width' => '300']
        ],
        [
            'header' => 'Пожелания',
            'attribute' => 'note',
            'value' => function ($data) {
                if (empty($data->note)) {
                    return 'Нет пожеланий';
                }
                return $data->note;
                // return $firstName . ' ' . $lastName;
            },
        ],
        [
            'header' => 'Клиент',
            'value' => function ($model, $key, $index, $column) {
                $firstName = $model->user->first_name;
                $lastName = $model->user->last_name;
                return $firstName . ' ' . $lastName;
            },
        ],
        [
            'header' => 'Пиццы',
            'format' => 'raw',
            'value' => function ($model, $key, $index, $column) {
                $orderRows = $model->orderRows;
                $pizzaNames = '<ol> ';
                foreach ($orderRows as $order) {
                    $pizzaNames .= '<li>' . $order->pizza->name . '</li>';
                }
                return $pizzaNames . '</ol>';
            },
        ],
    ],
]);
if (!Yii::$app->user->isGuest) {
    $form = ActiveForm::begin(['options' => ['id' => 'orderForm']]);
    // echo $form->field($modelOrder, 'time')->input('date');
    echo $form->field($modelOrder, 'pizzas')->dropDownList(ArrayHelper::map($pizzas, 'id', 'name'),  ['multiple' => 'true']);
    echo $form->field($modelOrder, 'note')->textarea(['rows' => 5]);
    echo Html::submitButton('Добавить', ['class' => 'btn btn-dark']);
    ActiveForm::end();
}


function debug($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}
