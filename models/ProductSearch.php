<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

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
class ProductSearch extends Model
{
    public $search;

    public function formName() {
        return '';
    }

    public function rules() {
        return [
            [['search'],'string'],
        ];
    }


    public function search() {
        $this->validate();
        $query = Product::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);

        $query->andFilterWhere([
            'or',
                ['like', 'sku', $this->search],
                ['like', 'title', $this->search]
            ]
        );

        return $dataProvider;
    }

}
