<?php

use yii\db\Schema;
use yii\db\Migration;
use robot72\components\helpers\MigrationHelper;

class m141025_074801_url_rule extends MigrationHelper
{
    public $tableName = '{{%url_rule}}';

    public function up()
    {
        $this->setTableOptions();
        $this->createTable($this->tableName, [
            'id'            => 'pk',
            'slug'          => Schema::TYPE_STRING  . ' NOT NULL',
            'route'         => Schema::TYPE_STRING  . ' NOT NULL',
            'params'        => Schema::TYPE_STRING  . " DEFAULT 'a:0:{}'",
            'redirect'      => Schema::TYPE_BOOLEAN . " DEFAULT '0'",
            'redirect_code' => Schema::TYPE_INTEGER . " DEFAULT '302'",
            'status'        => Schema::TYPE_BOOLEAN . " DEFAULT '1'"
        ]);
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
}