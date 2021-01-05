<?php
namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
* This is the model class for table "comedor.usuario".
*
* @property int $iduser
* @property string $username
* @property string $auth_key
* @property string $password
* @property string|null $password_reset_token
* @property string $email
* @property int $status
* @property string|null $created_at
* @property string|null $updated_at
* @property string|null $verification_token
* @property int|null $fkdepart
 */
class Usuario extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comedor.usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','password', 'email'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            //[['created_at', 'updated_at'], 'date', 'format'=>'yyyy-MM-dd'],
            [['status', 'fkdepart'], 'default', 'value' => null],
            [['status', 'fkdepart'], 'integer'],
            //['status', 'default', 'value' => self::STATUS_ACTIVE],
            //['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
            [['username', 'password', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['username'], 'unique'],
            [['fkdepart'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['fkdepart' => 'iddepart']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iduser' => 'ID',
            'username' => 'Usuario',
            'auth_key' => 'Auth Key',
            'password' => 'Contraseña',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
            'fkdepart' => 'Departamento',
        ];
    }

    public function getdepartamento()
    {
        $departamento = Departamento::find()->where(['iddepart'=>$this->fkdepart])->one();
        return $departamento;
    }

    public function getuserdepart()
    {
        return $this->hasOne(Departamento::className(), ['iddepart'=>'fkdepart']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['iduser' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
