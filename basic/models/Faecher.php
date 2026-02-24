<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Faecher".
 *
 * @property string $F_Name
 *
 * @property Hausaufgaben[] $hausaufgabens
 * @property LehrerFaecher[] $lehrerFaechers
 * @property Lehrer[] $ls
 */
class Faecher extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Faecher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['F_Name'], 'required'],
            [['F_Name'], 'string', 'max' => 50],
            [['F_Name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'F_Name' => 'F Name',
        ];
    }

    /**
     * Gets query for [[Hausaufgabens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHausaufgabens()
    {
        return $this->hasMany(Hausaufgaben::class, ['F_Name' => 'F_Name']);
    }

    /**
     * Gets query for [[LehrerFaechers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLehrerFaechers()
    {
        return $this->hasMany(LehrerFaecher::class, ['F_Name' => 'F_Name']);
    }

    /**
     * Gets query for [[Ls]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLs()
    {
        return $this->hasMany(Lehrer::class, ['L_ID' => 'L_ID'])->viaTable('Lehrer_Faecher', ['F_Name' => 'F_Name']);
    }

}
