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
use gearsoftware\comments\Comments;
use gearsoftware\comments\models\Comment;
use gearsoftware\helpers\CoreHelper;
use gearsoftware\media\models\Media;
use gearsoftware\post\models\Post;
use gearsoftware\widgets\TimeAgo;
use yii\helpers\Url;

CoreAsset::register($this);
$coreBaseUrl = $this->assetBundles[CoreAsset::class]->baseUrl;
?>

<li class="dropdown" <?= ($borderLeft) ? 'style="border-left: 1px solid rgba(0, 0, 0, 0.05);"' : ''; ?>>
    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
        <i class="demo-pli-bell"></i>
	    <?php if(count($recentNotifications) > 0): ?>
            <span class="badge badge-header badge-danger"></span>
	    <?php endif; ?>
    </a>
    <div class="dropdown-menu dropdown-menu-md">
        <div class="pad-all bord-btm">
            <p class="text-semibold text-main mar-no">
	            <?php if(count($recentNotifications) > 0): ?>
	                <?= Yii::t('core', 'Latest notifications for today.')?>
                <?php else: ?>
	                <?= Yii::t('core', 'You don\'t have notifications for today.')?>
                <?php endif; ?>
            </p>
        </div>
        <div class="nano scrollable">
            <div class="nano-content">
                <ul class="head-list">
	                <?php if(count($recentNotifications) > 0): ?>
		                <?php $limit = 0; ?>
		                <?php foreach ($recentNotifications as $notification) : ?>
			                <?php if($notification->model == Comment::class): ?>
				                <?php
				                $comment = Comment::find()
                                  ->active()
                                  ->andWhere([Comment::tableName().'.id' => $notification->model_id])
                                  ->one();
				                ?>
				                <?php if($comment): ?>
					                <?php if($limit++ == $recentLimit) break; ?>
					                <?php
					                $modelClass = Yii::createObject(['class' => $comment->model]);
					                $modelRecord = $modelClass->findOne([$modelClass->tableName().'.id' => $comment->model_id]);
					                if($modelClass->isMultilingual()){
						                $title = $modelRecord->title;
					                }else{
						                //todo add non multilingual model where name or title value names different
					                }
					                ?>
                                    <li class="bg-gray">
                                        <a class="media" href="<?= Url::to($comment->url) ?>">
                                            <div class="media-left">
                                                <img class="img-circle img-sm" alt="Profile Picture" src="<?= $comment->author->getAvatar('large'); ?>">
                                            </div>
                                            <div class="media-body">
                                                <h5 class="mar-no text-main text-semibold"><?= $comment->author->fullname; ?>
									                <?php if($title): ?>
										                <?= Yii::t('core', 'wrote a comment in'); ?>
                                                        "<?= $title; ?>"
									                <?php else: ?>
										                <?= Yii::t('core', 'wrote a comment'); ?>
									                <?php endif; ?>
                                                </h5>
                                                <small>
									                <?= TimeAgo::widget(['timestamp' => $comment->created_at, 'showDateTime' => true]); ?>
                                                </small>
                                            </div>
                                        </a>
                                    </li>
				                <?php endif; ?>
			                <?php elseif ($notification->model == Post::class): ?>
				                <?php
				                $post = Post::find()
                                    ->active()
                                    ->andWhere([Post::tableName().'.id' => $notification->model_id])
                                    ->multilingual()
                                    ->one();
				                ?>
				                <?php if($post): ?>
					                <?php if($limit++ == $recentLimit) break; ?>
                                    <li>
                                        <a class="media" href="<?= Url::to($post->slug) ?>">
                                            <div class="media-left">
								                <?php if($post->thumbnail) :?>
                                                    <img class="img-circle img-sm" src="<?= $post->thumbnail ?>" alt="Image">
								                <?php else: ?>
                                                    <i class="demo-pli-file-edit icon-2x"></i>
								                <?php endif; ?>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="mar-no text-main text-semibold">
									                <?= $post->author->fullname; ?>
									                <?= Yii::t('core/post', 'posted'); ?>
                                                    "<?= $post->title; ?>"
                                                </h5>
                                                <small>
									                <?= TimeAgo::widget(['timestamp' => $post->created_at, 'showDateTime' => true]); ?>
                                                </small>
                                            </div>
                                        </a>
                                    </li>
				                <?php endif; ?>
			                <?php elseif ($notification->model == Media::class): ?>
				                <?php
				                $media = Media::find()
                                      ->visible()
                                      ->andWhere([Media::tableName().'.id' => $notification->model_id])
                                      ->multilingual()
                                      ->one();
				                ?>
				                <?php if($media): ?>
					                <?php if($limit++ == $recentLimit) break; ?>
                                    <li>
                                        <a class="media" href="<?= Yii::$app->urlManager->hostInfo.'/media/'.$media->id; ?>">
                                            <div class="media-left">
								                <?php if ($media->isImage()): ?>
                                                    <img class="img-circle img-sm" alt="Media Picture" src="<?= $media->getThumbUrl('small') ?>">
								                <?php else: ?>
									                <?php $icon = CoreHelper::getIcon($media->type); ?>
                                                    <i class="<?= $icon['name'] ?> icon-2x"></i>
								                <?php endif; ?>
                                            </div>
                                            <div class="media-body">
                                                <h5 class="mar-no text-main text-semibold">
									                <?= $media->author->fullname; ?>
									                <?= Yii::t('core', 'shared'); ?>
                                                    "<?= $media->title; ?>"
                                                </h5>
                                                <small>
									                <?= TimeAgo::widget(['timestamp' => $media->created_at, 'showDateTime' => true]); ?>
                                                </small>
                                            </div>
                                        </a>
                                    </li>
				                <?php endif; ?>
			                <?php endif; ?>
		                <?php endforeach; ?>
	                <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="pad-all bord-top">
            <a href="<?= Url::to('/timeline'); ?>" class="btn-link text-dark box-block">
                <i class="fa fa-angle-right fa-lg pull-right"></i>
                <?= Yii::t('core', 'Show All Notifications')?>
            </a>
        </div>
    </div>
</li>
