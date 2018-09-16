<?php

/**
 * @package   Yii2-Timeline
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\timeline\widgets;

use gearsoftware\timeline\models\Timeline;
use gearsoftware\timeline\models\TimelineSearch;
use Yii;

class TimelineWidget extends \yii\base\Widget
{
	/**
	 * @var TimelineSearch
	 */
	public $modelSearchClass = 'gearsoftware\timeline\models\TimelineSearch';

	public $pageSize = 4;

	public function run()
	{
		$searchModel = $this->modelSearchClass ? new $this->modelSearchClass : null;
		$params = Yii::$app->request->getQueryParams();
		$dataProvider = $searchModel->search($params);
		$dataProvider->pagination->defaultPageSize = $this->pageSize;

		return $this->render('timeline', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]
		);
	}
}