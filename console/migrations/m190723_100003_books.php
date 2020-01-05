<?php

use yii\db\Migration;

/**
 * Class m190723_100003_books
 */
class m190723_100003_books extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        {
            $this->createTable('{{%books}}', [
                'id' => $this->primaryKey(),
                'appellation' => $this->string()->notNull(),
                'text' => $this->text(),
                'author_id' => $this->smallInteger(8)->notNull(),
                'hero_id' => $this->smallInteger(8),
                'created_at' => $this->timestamp()->notNull(),
                'updated_at' => $this->timestamp()->notNull(),
            ]);

            $this->alterColumn('books', 'id', $this->smallInteger(8) . ' NOT NULL AUTO_INCREMENT');

            $this->addForeignKey(
                'author',
                'books',
                'author_id',
                'author',
                'id',
                'CASCADE'
            );

            $this->addForeignKey(
                'hero',
                'books',
                'hero_id',
                'hero',
                'id',
                'CASCADE'
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        {
            $this->dropTable('{{%books}}');

            $this->dropForeignKey(
                'books',
                'books'
            );
        }
    }
}
