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

use gearsoftware\comments\models\Comment;
use gearsoftware\media\models\Media;
use gearsoftware\post\models\Post;
use gearsoftware\timeline\models\Timeline;
use yii\base\Widget;

class NotificationsDropdown extends Widget
{
	public $recentLimit = 5;

	public $borderLeft = false;

    public function run()
    {
	    $today = strtotime('today');
	    $recentNotifications = Timeline::find()
           ->where(['>=', Timeline::tableName() . '.created_at', $today])
           ->orderBy([Timeline::tableName() . '.created_at' => SORT_DESC])
           ->all();
	    return $this->render('notifications', [
			'recentNotifications' => $recentNotifications,
		    'recentLimit' => $this->recentLimit,
		    'borderLeft' => $this->borderLeft,
        ]);
    }
}