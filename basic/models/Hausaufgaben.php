<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Hausaufgaben".
 *
 * @property int $HU_ID
 * @property string|null $Titel
 * @property string|null $Beschreibung
 * @property string|null $Faelligkeitsdatum
 * @property string|null $Status
 * @property string|null $F_Name
 * @property int|null $U_ID
 * @property int|null $L_ID
 *
 * @property Faecher $fName
 * @property Lehrer $l
 * @property User $u
 */
class Hausaufgaben extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Hausaufgaben';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Titel', 'Beschreibung', 'Faelligkeitsdatum', 'Status', 'F_Name', 'U_ID', 'L_ID'], 'default', 'value' => null],
            [['Beschreibung'], 'string'],
            [['Faelligkeitsdatum'], 'safe'],
            [['U_ID', 'L_ID'], 'integer'],
            [['Titel'], 'string', 'max' => 100],
            [['Status'], 'string', 'max' => 20],
            [['F_Name'], 'string', 'max' => 50],
            [['F_Name'], 'exist', 'skipOnError' => true, 'targetClass' => Faecher::class, 'targetAttribute' => ['F_Name' => 'F_Name']],
            [['U_ID'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['U_ID' => 'U_ID']],
            [['L_ID'], 'exist', 'skipOnError' => true, 'targetClass' => Lehrer::class, 'targetAttribute' => ['L_ID' => 'L_ID']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'HU_ID' => 'Hu ID',
            'Titel' => 'Titel',
            'Beschreibung' => 'Beschreibung',
            'Faelligkeitsdatum' => 'Faelligkeitsdatum',
            'Status' => 'Status',
            'F_Name' => 'F Name',
            'U_ID' => 'U ID',
            'L_ID' => 'L ID',
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

    /**
     * Gets query for [[U]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::class, ['U_ID' => 'U_ID']);
    }

}
