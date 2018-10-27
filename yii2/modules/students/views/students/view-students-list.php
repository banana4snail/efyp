<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\modules\students\models\Faculty;
use app\modules\students\models\Course;
use app\modules\students\models\Title;
use app\modules\students\models\Staff;
$session = Yii::$app->session;
$user = Yii::$app->user->identity->attributes;  
$staff = Staff::find()->where(['userID'=>$user['username']])->one();
$this->params['breadcrumbs'][] = ['label' => 'Allocate Students', 'url' => ['title/allocate-students', 'user' => $staff->id]];
$this->params['breadcrumbs'][] = ['label' => 'Student List'];
?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'studentID',
            'name',
            ['label' => 'Course',
            'value' => function($model){
                return $model->course0->courseID;},
            'attribute' => 'course',
            'filter' => ArrayHelper::map(Course::find()->all(),'courseID','courseID')
            ],
            [
            'attribute' => '',
            'label'=>'Status',
            'format' => 'raw',
            'value' => function($model) use ($registeredStudents){
                 if(in_array($model->studentID, $registeredStudents))
                    return "Registered";
                else
                    return "Unregistered";
                },
            'filter' => ArrayHelper::map(Course::find()->all(),'courseID','courseID')
            ],
            [
            'attribute' => '',
            'format' => 'raw',
            'value' => function ($model) use ($title,$registeredStudents){      
                    if(in_array($model->studentID, $registeredStudents))
                        return "-";
                    else
                        return '<a href="/efyp/yii2/web/index.php?r=students%2Ftitle%2Fregister-student&student='.$model->studentID.'&title='.$title.'" >Select</a>';
                },
            ],
         ],
    ]); ?>



