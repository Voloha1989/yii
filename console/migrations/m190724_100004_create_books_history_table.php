<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books_history}}`.
 */
class m190724_100004_create_books_history_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_history}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text(),
            'book_id' => $this->smallInteger(8)->notNull(),
            'created_at' => $this->timestamp()->notNull(),
        ]);

        $this->alterColumn('books_history', 'id', $this->smallInteger(8) . ' NOT NULL AUTO_INCREMENT');

        $this->addForeignKey(
            'books',
            'books_history',
            'book_id',
            'books',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books_history}}');

        $this->dropForeignKey(
            'books',
            'books'
        );
    }
}
