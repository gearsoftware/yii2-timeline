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

use gearsoftware\comments\models\Comment;
use gearsoftware\media\models\Media;
use gearsoftware\post\models\Post;
use Yii;

/**
 * This is the model class for table "timeline".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property integer $created_at
 *
 */
class Timeline extends \gearsoftware\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%timeline}}';
    }

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('core', 'ID'),
			'model' => Yii::t('core', 'Element'),
			'model_id' => Yii::t('core', 'Model ID'),
			'created_at' => Yii::t('core', 'Date'),
			'title' => Yii::t('core', 'Title'),
		];
	}

	public static function getModelsName(){
		return [
			[
				'name' => Yii::t('core/Post', 'Post'),
				'model' => Post::class,
			],
			[
				'name' => Yii::t('core', 'Comment'),
				'model' => Comment::class,
			],
			[
				'name' => Yii::t('core/Media', 'Media'),
				'model' => Media::class,
			],
		];
	}
}