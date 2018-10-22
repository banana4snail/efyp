<?php

namespace app\modules\students\models;

use Yii;
use app\modules\students\models\Faculty;

/**
 * This is the model class for table "staff".
 *
 * @property integer $id
 * @property string $userID
 * @property integer $role
 * @property string $name
 * @property integer $faculty_fk
 * @property string $departments_fk
 * @property string $email
 * @property string $contactNo
 *
 * @property Roles $role0
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $roleArray;
    public $password;
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'role', 'name', 'faculty_fk', 'departments_fk', 'email', 'contactNo','password'], 'required'],
            /*Regular Expression*/
            ['userID','match','pattern'=> '/^.{5,}$/','message'=>'UserID must be minimum five characters(letters and numbers).'],
            ['name','match','pattern'=> '/^[a-zA-Z]{1}[a-zA-Z\`\'\/\s]{0,50}$/','message'=>'Please enter a valid name.'],
            ['email', 'match', 'pattern' => '/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/','message'=>'Please enter a valid email address. Example: abc@gmail.com'],
            ['contactNo', 'match', 'pattern' => '/^(\+?6?01)[0-9]-*[0-9]{7,8}$/','message'=>'Please enter a valid phone number. Example: 0123456789 / 012-3456789'],
            ['password', 'match', 'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/','message'=>'Password must be minimum eight characters, at least one letter and one number.'],
            // /*Validate Input Type*/
            [['userID', 'name', 'departments_fk', 'email','role'], 'string', 'max' => 255],
            [['faculty_fk'], 'integer'],
            [['contactNo'], 'string', 'max' => 20],
            [['userID'], 'unique'],
            [['faculty'], 'exist', 'skipOnError' => true, 'targetClass' => Faculty::className(), 'targetAttribute' => ['faculty' => 'facultyID']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userID' => 'User ID',
            'role' => 'Role',
            'name' => 'Name',
            'faculty_fk' => 'Faculty',
            'departments_fk' => 'Departments',
            'email' => 'Email',
            'contactNo' => 'Contact No',
            'password' => 'Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolesText(){

        $roleArr = explode(",", $this->role);
        $roleInTextArr = array();
        foreach($roleArr as $arole){
            array_push($roleInTextArr, $this->roles[$arole]);

        }

        return implode(", ", $roleInTextArr);
    }

    public function getRoles()
    {
        return array(1 => 'Admin',
                     2 => 'FYP Coordinator',
                     3 => 'Lecturer (Supervisors/Co-supervisors/Moderators)');
    }

    public function getFaculty()
    {
        return $this->hasOne(Faculty::className(), ['facultyID' => 'faculty_fk']);
    }


}
