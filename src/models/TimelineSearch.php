<?php

/**
 * @package   Yii2-Timeline
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\timeline\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TimelineSearch represents the model behind the search form about `gearsoftware\timeline\models\Timeline`.
 *
 * @property string $title
 */
class TimelineSearch extends Timeline
{
	public $title;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['id'], 'integer'],
			[['created_at', 'model', 'title'], 'safe'],
		];
	}
	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
		// bypass scenarios() implementation in the parent class
		return Model::scenarios();
	}

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params = [])
	{
		$query = Timeline::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				],
			],
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		if ($this->created_at) {
			$tmp = explode(' - ', $this->created_at);
			if (isset($tmp[0], $tmp[1])) {
				$query->andFilterWhere(['between', static::tableName() . '.created_at',
					strtotime($tmp[0]), strtotime($tmp[1])]);
			}
		}

		$query->andFilterWhere(['like',  static::tableName() . '.model', $this->model]);

		return $dataProvider;
	}
}