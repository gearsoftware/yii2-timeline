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

use gearsoftware\controllers\BaseController;

/**
 * TimelineController implements the CRUD actions for gearsoftware\timeline\models\Timeline model.
 */
class DefaultController extends BaseController
{
    public $enableOnlyActions = ['index'];

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
	    return $this->render('index');
    }
}