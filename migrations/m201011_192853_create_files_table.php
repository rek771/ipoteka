<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%files}}`.
 */
class m201011_192853_create_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('files', [
            'id' => $this->primaryKey(),
            'file_path' => $this->text(),
            'date_upload' => $this->dateTime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('files');
    }
}
