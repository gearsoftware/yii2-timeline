<?php

/**
 * @package   Yii2-Timeline
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\grid\DateRangePicker;
use gearsoftware\helpers\Html;
use gearsoftware\timeline\models\Timeline;
use kartik\widgets\Select2;
use yii\grid\GridViewAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use gearsoftware\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel gearsoftware\timeline\models\TimelineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

GridViewAsset::register($this);

?>

<?php
$form = ActiveForm::begin([
	'id' => 'timeline',
	'action' => Url::to('/timeline'),
	'method' => 'get',
	'validateOnBlur' => true,
	'fieldConfig' => ['template' => "{label}{input}\n{hint}\n{error}"],
]);
?>

<div class="panel" style="padding: 15px 15px 0;">
	<div class="row" id="timeline-grid-filters">
		<div class="col-sm-4">
			<div class="form-group mar-no">
				<?= $form->field($searchModel, 'model')->widget(Select2::classname(), [
					'data' => ArrayHelper::map(Timeline::getModelsName(), 'model', 'name'),
					'options' => [
						'placeholder' => Yii::t('core', 'Select an {element}...', ['element' => Yii::t('core', 'Element')]),
					],
					'pluginOptions' => [
						'allowClear' => true
					],
					'addon' => [
						'prepend' => [
							'content' => '<i class="ti-sharethis"></i>'
						],
					]
				]);?>
			</div>
		</div>
        <!--<div class="col-sm-3">
            <div class="form-group">
				<?php /*$form->field($searchModel, 'title',
					[
						'addon' => [
							'prepend' => [
								'content' => '<i class="ti-bookmark-alt"></i>'
							],
						],
					]
				)->textInput(['placeholder' => $searchModel->attributeLabels()['title']])*/ ?>
            </div>
        </div>!-->
		<div class="col-sm-4">
			<div class="form-group">
				<?= $form->field($searchModel, 'created_at')
			         ->widget(DateRangePicker::className(), [
				         'options' => [
					         'class' => 'form-control mar-no',
				         ]
			         ]) ?>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label class="control-label"><?= Yii::t('core', 'Clear filters'); ?></label>
				<?= Html::a(Yii::t('core', 'Clear filters'), Url::to('/timeline'), ['class' => 'form-control btn btn-mint']) ?>
			</div>
		</div>
	</div>
</div>

<?php ActiveForm::end(); ?>

<?php
    $widget = ListView::begin([
        'dataProvider' => $dataProvider,
        'layout' => '{items}',
        'itemOptions' => ['tag' => 'div', 'class' => 'timeline-entry'],
        'itemView' => function ($model, $key, $index, $widget) use($searchModel) {
            $title = $searchModel->title;
            return $this->render('item', compact('model', 'key', 'title'));
        },
        'pager' => [
            'class' => \gearsoftware\grid\InfiniteScrollPager::className(),
            'triggerTemplate' =>
                '<div class="timeline-header">
                    <div class="timeline-header-title bg-primary">
                        <div class="ias-trigger" style="text-align: center; cursor: pointer;"><a>{text}</a></div>
                    </div>
                </div>',
            'historyPrevTemplate' =>
	            '<div class="timeline-header">
                    <div class="timeline-header-title bg-primary">
                        <div class="ias-trigger ias-trigger-prev" style="text-align: center; cursor: pointer;">{text}</div>
                    </div>
                </div>',
            'spinnerTemplate' =>
	            '<div class="timeline-header">
                    <div class="timeline-header-title bg-warning">
                        <div class="ias-spinner" style="text-align: center;"><img src="{src}"/></div>
                    </div>
                </div>',
            'noneLeftTemplate' =>
	            '<div class="timeline-header">
                    <div class="timeline-header-title bg-success">
                        <div class="ias-noneleft" style="text-align: center;">{text}</div>
                    </div>
                </div>',
            'container' => '.timeline',
            'item' => '.timeline-entry',
            'historyPrev' => '.prev a',
            'triggerOffset' => 3
        ],
    ]);
?>

<?php if($dataProvider->totalCount > 0): ?>
<div class="timeline two-column">
	<div class="timeline-header">
		<div class="timeline-header-title bg-success"><?= Yii::t('core', 'Now');?></div>
	</div>
    <?= $widget->renderItems(); ?>
	<div class="clearfix"></div>
</div>
<div class="text-center">
	<?= $widget->renderPager(); ?>
</div>
<?php else: ?>
    <div class="panel">
        <div class="panel-body">
            <div class="empty"><?= Yii::t('core', 'No results found.');?></div>
        </div>
    </div>
<?php endif; ?>
<?php

//Init AJAX filter submit
$options = '{"filterUrl":"' . Url::to(['default/index']) . '","filterSelector":"#timeline-grid-filters input, #timeline-grid-filters select"}';
$this->registerJs("jQuery('#timeline').yiiGridView($options);");
//Remove empty ListView elements
$js = <<<JS
$('.timeline .timeline-entry').each(function(index, item) {
    if($.trim($(item).text()) === "") {
        $(item).remove();
    }
});
JS;
$this->registerJs($js);

?>
