<?php

use yii\bootstrap4\Dropdown;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

?>

<h1>ПИЦЦЫ</h1>

<? if (Yii::$app->session->hasFlash('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong><?= Yii::$app->session->getFlash('success') ?></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<? endif ?>

<? if (Yii::$app->session->hasFlash('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><?= Yii::$app->session->getFlash('error') ?></strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<? endif ?>

<?php
echo '<ul>';
foreach($pizzas as $pizza){
    echo '<li>'. $pizza->name ." (Цена: {$pizza->price} руб.)".'</li>';
    // var_dump($pizza->ingredients); die;
    $ingredients = $pizza->ingredients;
    echo '<ul>';
        foreach($ingredients as $ingredient){
            echo '<li>'. $ingredient->name .'</li>';
        }
    echo '</ul>';
}
echo '</ul>';
?>
<h1>Добавить новую пиццу</h1>
<?php
$form = ActiveForm::begin(['options' => ['id' => 'pizzaForm']]);
echo $form->field($pizzaModel, 'name');
echo $form->field($pizzaModel, 'price')->input('number');
echo $form->field($pizzaModel, 'ingredients')->dropDownList(ArrayHelper::map($allIngredients, 'id', 'name'),  ['multiple' => 'true']);
echo Html::submitButton('Добавить', ['class' => 'btn btn-dark']);
ActiveForm::end();
?>