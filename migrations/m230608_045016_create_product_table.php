<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m230608_045016_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'picture' => $this->string(),
            'sku' => $this->string(20),
            'title' => $this->string(100),
            'count' => $this->integer(),
            'type' => $this->integer(),
        ]);
        $this->createIndex('sku','{{%product}}','sku');
        $this->createIndex('title','{{%product}}','title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('sku','{{%product}}');
        $this->dropIndex('title','{{%product}}');
        $this->dropTable('{{%product}}');
    }
}
