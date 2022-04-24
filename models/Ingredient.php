<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingredient".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property PizzaHasIngredient[] $pizzaHasIngredients
 */
class Ingredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public function getPizzas()
    {
        return $this->hasMany(Pizza::className(), ['id' => 'pizza_id'])
            ->viaTable('pizza_has_ingredient', ['ingredient_id' => 'id']);
    }
}
