<?php

use yii\db\Migration;
use yii\helpers\Json;

/**
 * Class m221108_062827_AlterStatusTable
 */
class m221108_062827_AlterStatusTable extends Migration
{


    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     */
    public function safeUp()
    {
        $this->addColumn('status', 'options', $this->json());
        $this->update('status',
            [
                'options' => Json::encode([
                    'tag' => 'span',
                    'options' => [
                        'class' => 'badge bg-warning'
                    ]
                ])
            ],
            [
                'id' => 1
            ]
        );

        $this->update('status',
            [
                'options' => Json::encode([
                    'tag' => 'span',
                    'options' => [
                        'class' => 'badge bg-danger'
                    ]
                ])
            ],
            [
                'id' => 2
            ]
        );

        $this->update('status',
            [
                'options' => Json::encode([
                    'tag' => 'span',
                    'options' => [
                        'class' => 'badge bg-success'
                    ]
                ])
            ],
            [
                'id' => 3
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('status', 'options');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221108_062827_AlterStatusTable cannot be reverted.\n";

        return false;
    }
    */
}