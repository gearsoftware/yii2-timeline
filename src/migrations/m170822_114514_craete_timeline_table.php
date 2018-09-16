<?php

/**
 * @package   Yii2-Timeline
 * @author    José Peña <joepa37@gmail.com>
 * @link https://plus.google.com/+joepa37/
 * @copyright Copyright (c) 2018 José Peña
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @version   1.0.0
 */

class m170822_114514_craete_timeline_table extends yii\db\Migration
{
	const TABLE_NAME = '{{%timeline}}';

    public function up()
    {
	    $tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		    $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
	    }

	    $this->createTable(self::TABLE_NAME, [
		    'id' => $this->primaryKey(),
		    'model' => $this->string(64)->notNull()->defaultValue(''),
		    'model_id' => $this->integer(),
		    'created_at' => $this->integer()->notNull(),
	    ], $tableOptions);

	    $this->createIndex('timeline_model', self::TABLE_NAME, 'model');
	    $this->createIndex('timeline_model_id', self::TABLE_NAME, ['model', 'model_id']);
    }

    public function down()
    {
	    $this->dropTable(self::TABLE_NAME);
    }
}
