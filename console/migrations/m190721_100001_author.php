<?php

use yii\db\Migration;

/**
 * Class m190721_100001_author
 */
class m190721_100001_author extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'patronymic' => $this->string(255),
            'surname' => $this->string(255),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ]);

        $this->alterColumn('author', 'id', $this->smallInteger(8) . ' NOT NULL AUTO_INCREMENT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%author}}');
    }
}
