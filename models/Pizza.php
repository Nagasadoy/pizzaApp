<?php

namespace app\models;

use yii\db\ActiveRecord;

class Pizza extends ActiveRecord
{

    // public $ingredients;
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'price' => 'Цена',
            'ingredients' => 'Ингредиенты'
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Вы не указали название!'],
            ['price', 'number', 'min' => 1, 'tooSmall' => 'Цена не может быть отрицательной'],
            ['ingredients', 'safe']
        ];
    }


    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['id' => 'ingredient_id'])
            ->viaTable('pizza_has_ingredient', ['pizza_id' => 'id']);
    }
}