<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Lehrer_Faecher".
 *
 * @property int $L_ID
 * @property string $F_Name
 *
 * @property Faecher $fName
 * @property Lehrer $l
 */
class LehrerFaecher extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Lehrer_Faecher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['L_ID', 'F_Name'], 'required'],
            [['L_ID'], 'integer'],
            [['F_Name'], 'string', 'max' => 50],
            [['L_ID', 'F_Name'], 'unique', 'targetAttribute' => ['L_ID', 'F_Name']],
            [['L_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Lehrer::class, 'targetAttribute' => ['L_ID' => 'L_ID']],
            [['F_Name'], 'exist', 'skipOnError' => true, 'targetClass' => Faecher::class, 'targetAttribute' => ['F_Name' => 'F_Name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'L_ID' => 'L ID',
            'F_Name' => 'F Name',
        ];
    }

    /**
     * Gets query for [[FName]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFName()
    {
        return $this->hasOne(Faecher::class, ['F_Name' => 'F_Name']);
    }

    /**
     * Gets query for [[L]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getL()
    {
        return $this->hasOne(Lehrer::class, ['L_ID' => 'L_ID']);
    }

}
