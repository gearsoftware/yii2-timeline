<?php

/**
 * @package   Yii2-Timeline
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

use gearsoftware\assets\core\CoreAsset;
use gearsoftware\comments\models\Comment;
use gearsoftware\helpers\CoreHelper;
use gearsoftware\media\models\Media;
use gearsoftware\post\models\Post;
use gearsoftware\widgets\TimeAgo;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $model \gearsoftware\timeline\models\Timeline */
CoreAsset::register($this);
?>

<?php if($model->model == Comment::class): ?>
    <?php
        $comment = Comment::find()
          ->active()
          ->andWhere([Comment::tableName().'.id' => $model->model_id])
          ->andFilterWhere(['like', Comment::tableName().'.content', $title])
          ->one();
        ?>
    <?php if($comment): ?>
        <?php
            $modelClass = Yii::createObject(['class' => $comment->model]);
            $modelRecord = $modelClass->findOne([$modelClass->tableName().'.id' => $comment->model_id]);
            if($modelClass->isMultilingual()){
                $title = $modelRecord->title;
            }else{
                //todo add non multilingual model where name or title value names different
            }
        ?>
        <div class="timeline-stat">
            <div class="timeline-icon">
                <img alt="Profile picture" src="<?= $comment->author->getAvatar('large'); ?>">
            </div>
            <div class="timeline-time">
                <?= TimeAgo::widget(['timestamp' => $comment->created_at, 'showDateTime' => true]); ?>
            </div>
        </div>
        <div class="timeline-label">
            <p class="mar-no pad-btm">
                <a class="btn-link text-semibold"><?= $comment->author->fullname; ?></a>
                <?php if($title) :?>
                    <?= Yii::t('core', 'commented on');?>
                    <a class="btn-link text-semibold" href="<?= Url::to($comment->url) ?>" class="text-semibold">"<?= $title; ?>"</a>
                <?php else: ?>
                    <?= Yii::t('core', 'wrote a comment');?>
                    <a class="btn-link text-semibold" href="<?= Url::to($comment->url) ?>" class="text-semibold"><?= Yii::t('core', 'here');?></a>
                <?php endif; ?>
            </p>
            <blockquote class="bq-sm bq-open mar-no"><?= Html::encode($comment->content); ?></blockquote>
        </div>
    <?php endif; ?>
<?php elseif ($model->model == Post::class): ?>
	<?php
	$post = Post::find()
		->joinWith('translations')
        ->active()
        ->andWhere([Post::tableName().'.id' => $model->model_id])
        ->andFilterWhere(['like', 'post_lang.title', $title])
        ->one();
	?>
	<?php if($post): ?>
        <div class="timeline-stat">
            <div class="timeline-icon">
                <img alt="Profile picture" src="<?= $post->author->getAvatar('large'); ?>">
            </div>
            <div class="timeline-time">
				<?= TimeAgo::widget(['timestamp' => $post->created_at, 'showDateTime' => true]); ?>
            </div>
        </div>
        <div class="timeline-label">
            <p class="mar-no pad-btm">
                <a class="btn-link text-semibold"><?= $post->author->fullname; ?></a>
	            <?= Yii::t('core/post', 'posted'); ?>
                <a class="btn-link text-semibold" href="<?= Url::to($post->slug) ?>" class="text-semibold">"<?= $post->title; ?>"</a>
            </p>
            <p class="mar-no">
		        <?= HtmlPurifier::process(mb_substr(strip_tags($post->content), 0, 250, "UTF-8")); ?>
		        <?= (strlen(strip_tags($post->content)) > 250) ? '...' : '' ?>
                <a  href="<?= Url::to($post->slug) ?>"  class="btn btn-trans"><?= Yii::t('core', 'Read more'); ?></a>
            </p>
            <?php if($post->thumbnail): ?>
                <div class="img-holder">
                    <img alt="Image" src="<?= $post->thumbnail ?>">
                </div>
            <?php endif; ?>
        </div>
	<?php endif; ?>
    <?php elseif ($model->model == Media::class): ?>
        <?php
            $media = Media::find()
                  ->joinWith('translations')
                  ->visible()
                  ->andWhere([Media::tableName().'.id' => $model->model_id])
                  ->andFilterWhere(['like', 'media_lang.title', $title])
                  ->one();
        ?>
        <?php if($media): ?>
            <div class="timeline-stat">
                <div class="timeline-icon">
                    <img alt="Profile picture" src="<?= $media->author->getAvatar('large'); ?>">
                </div>
                <div class="timeline-time">
	                <?= TimeAgo::widget(['timestamp' => $media->created_at, 'showDateTime' => true]); ?>
                </div>
            </div>
            <div class="timeline-label">
                <p class="mar-no pad-btm">
                    <a class="btn-link text-semibold"><?= $media->author->fullname; ?></a>
	                <?= Yii::t('core', 'shared'); ?>
                    <a class="btn-link text-semibold" href="<?= Yii::$app->urlManager->hostInfo.'/media/'.$media->id; ?>" class="text-semibold">
                        "<?= $media->title; ?>"
                    </a>
                </p>
		        <?php if ($media->isImage()): ?>
                    <div class="img-holder">
                        <img alt="Image" src="<?= $media->getThumbUrl('original') ?>">
                    </div>
		        <?php elseif ($media->isVideo()): ?>
                    <video controls="controls" width="100%"><source src="<?= $media->getThumbUrl('original'); ?>" type="<?= $media->type ?>"></video>
		        <?php elseif ($media->isAudio()): ?>
                    <audio src="<?= $media->getThumbUrl('original'); ?>" controls="controls" style="width: 100%;"></audio>
		        <?php else: ?>
                    <?php $icon = CoreHelper::getIcon($media->type); ?>
                    <a href="<?= $media->getThumbUrl('original'); ?>" target="_blank">
                        <i class="<?= $icon['name'] ;?>" style="color:<?= $icon['color'] ;?>; font-size: 120px; line-height: 120px; opacity: .9;"></i>
                    </a>
                <?php endif; ?>
                <p class="pad-top mar-no">
		            <?php if($media->description): ?>
			            <?= $media->description ;?>
		            <?php else: ?>
			            <?= Yii::t('core/media', 'The file has no description.'); ?>
		            <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>
<?php endif; ?>