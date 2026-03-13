<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Dies ist die Model-Klasse für die Tabelle "faecher".
 *
 * @property string $F_Name
 */
class Faecher extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        // Hier muss der exakte Name deiner Datenbank-Tabelle stehen
        return 'Faecher';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['F_Name'], 'required'],
            [['F_Name'], 'string', 'max' => 255],
            [['F_Name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'F_Name' => 'Fachname',
        ];
    }

}