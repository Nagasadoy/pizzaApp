<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $time
 * @property string|null $note
 *
 * @property OrderRow[] $orderRows
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{

    public $pizzas;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'default', 'value' => null],
            [['user_id'], 'integer'],
            [['time'], 'safe'],
            [['note'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'time' => 'Time',
            'note' => 'Примечание',
            'pizzas' => 'Пиццы'
        ];
    }

    /**
     * Gets query for [[OrderRows]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderRows()
    {
        return $this->hasMany(OrderRow::className(), ['order_id' => 'id']);
    }

    public static function pp($idOrder){
        $orderRows = OrderRow::find()->where(['in', 'order_id', $idOrder])->all();
        $pizzasId = [];
        foreach($orderRows as $orderRow){
            array_push($pizzasId, $orderRow->id);
        }
        $pizzas = Pizza::find()->where(['in', 'id', $pizzasId])->all();
        return $pizzas;
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
