<?php

/**
 * @package   Yii2-Timeline
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

namespace gearsoftware\timeline\controllers;

use gearsoftware\timeline\models\Timeline;

trait TimelineTrait
{
	public $writeTimeline = true;
	public $model_class, $model_class_id, $model_created_at = NULL;

	public function saveTimeline(){
		if($this->writeTimeline){
			if($this->model_class && $this->model_class_id){
				\Yii::$app->cache->flush();
				$timeline = new Timeline();
				$timeline->model = $this->model_class;
				$timeline->model_id = $this->model_class_id;
				$timeline->created_at = $this->model_created_at;
				$timeline->save(false);
			}
		}
	}
}