<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Lehrer".
 *
 * @property int $L_ID
 * @property string|null $Vorname
 * @property string|null $Nachname
 * @property string|null $Kuerzel
 * @property string|null $Status
 *
 * @property Faecher[] $fNames
 * @property Hausaufgaben[] $hausaufgabens
 * @property LehrerFaecher[] $lehrerFaechers
 */
class Lehrer extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Lehrer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Vorname', 'Nachname', 'Kuerzel', 'Status'], 'default', 'value' => null],
            [['Vorname', 'Nachname'], 'string', 'max' => 50],
            [['Kuerzel'], 'string', 'max' => 10],
            [['Status'], 'string', 'max' => 20],
            [['Kuerzel'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'L_ID' => 'L ID',
            'Vorname' => 'Vorname',
            'Nachname' => 'Nachname',
            'Kuerzel' => 'Kuerzel',
            'Status' => 'Status',
        ];
    }

    /**
     * Gets query for [[FNames]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFNames()
    {
        return $this->hasMany(Faecher::class, ['F_Name' => 'F_Name'])->viaTable('Lehrer_Faecher', ['L_ID' => 'L_ID']);
    }

    /**
     * Gets query for [[Hausaufgabens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHausaufgabens()
    {
        return $this->hasMany(Hausaufgaben::class, ['L_ID' => 'L_ID']);
    }

    /**
     * Gets query for [[LehrerFaechers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLehrerFaechers()
    {
        return $this->hasMany(LehrerFaecher::class, ['L_ID' => 'L_ID']);
    }

}
