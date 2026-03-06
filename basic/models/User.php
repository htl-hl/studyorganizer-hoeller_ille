<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface; // WICHTIG: Das Interface importieren

/**
 * This is the model class for table "User".
 *
 * @property int $U_ID
 * @property string|null $Name
 * @property string|null $Pwd
 *
 * @property Hausaufgaben[] $hausaufgabens
 */
class User extends ActiveRecord implements IdentityInterface
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
            [['is_admin'], 'integer'],
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

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
    public function getId()
    {
        return $this->U_ID;
    }
    public function getAuthKey()
    {
        return null;
    }
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    public static function findByUsername($username)
    {
        return static::findOne(['Name' => $username]);
    }
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->Pwd);
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
    public function getUsername(){
        return $this->Name;
    }
    public function isAdmin() {
        return $this->is_admin == 1;
    }
}