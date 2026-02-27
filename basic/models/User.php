<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "User".
 *
 * @property int $U_ID
 * @property string|null $Name
 * @property string|null $Pwd
 *
 * @property Hausaufgaben[] $hausaufgabens
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'User';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name', 'Pwd'], 'default', 'value' => null],
            [['Name'], 'string', 'max' => 100],
            [['Pwd'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'U_ID' => 'U ID',
            'Name' => 'Name',
            'Pwd' => 'Pwd',
        ];
    }

    /**
     * Gets query for [[Hausaufgabens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHausaufgabens()
    {
        return $this->hasMany(Hausaufgaben::class, ['U_ID' => 'U_ID']);
    }

}
