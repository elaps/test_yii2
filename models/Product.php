<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string|null $picture
 * @property string|null $sku
 * @property string|null $title
 * @property int|null $count
 * @property int|null $type
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count', 'type'], 'integer'],
            [['picture'], 'string', 'max' => 255],
            [['picture'], 'url'],
            [['sku'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'picture' => 'Picture',
            'sku' => 'Sku',
            'title' => 'Title',
            'count' => 'Count',
            'type' => 'Type',
        ];
    }

    public static function types(){
        return [
            0 => Yii::t('app','Тип 1'),
            1 => Yii::t('app','Тип 2'),
        ];
    }

    public function getType(){
        return self::types()[$this->type]??'-';
    }
}
