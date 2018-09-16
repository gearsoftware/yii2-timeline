<?php

/**
 * @package   Yii2-Timeline
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\assets\language\LanguagePillsAsset;

/* @var $this yii\web\View */

$this->title = Yii::t('core', 'Timeline');
$this->params['breadcrumbs'][] = $this->title;

LanguagePillsAsset::register($this);
?>
<div class="timeline-index">
	<?= \gearsoftware\timeline\widgets\TimelineWidget::widget() ?>
</div>