<?php

namespace app\controllers;

use app\models\Ingredient;
use app\models\Pizza;
use Yii;

class PizzaController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            $dataPost = Yii::$app->request->post();
            $newPizza = new Pizza();
            $newPizza->name = $dataPost['Pizza']['name'];
            $newPizza->price = $dataPost['Pizza']['price'];

            $ingredients = [];
            // если добавили ингредиенты, тогда ищем их по id (? Может быть можно сразу записать их по id)
            if (!empty($dataPost['Pizza']['ingredients'])) {
                $ingredients = Ingredient::find()->where(['in', 'id', $dataPost['Pizza']['ingredients']])->all();
            }

            if ($newPizza->save()) {
                if (count($ingredients) != 0) {
                    // достаем id добавленной пиццы
                    $id = Yii::$app->db->getLastInsertID();
                    // ищем по id эту пиццу
                    $newPizza = Pizza::findOne($id);
                    //пробегаемся по всем добавленным ингредиентам и создаем связь с пиццей, которую только что добавили
                    foreach ($ingredients as $ing) {
                        $ing->link('pizzas', $newPizza);
                    }
                }
                Yii::$app->session->setFlash('success', 'Пицца добавлена!');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка!');
            }
        }
  
        $pizzaModel = new Pizza();

        $pizzas = Pizza::find()->with('ingredients')->all();
        $allIngredients = Ingredient::find()->all();

        return $this->render('index', [
            'pizzas' => $pizzas,
            'pizzaModel' => $pizzaModel,
            'allIngredients' => $allIngredients
        ]);
    }

}
