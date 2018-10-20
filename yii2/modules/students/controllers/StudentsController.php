<?php

namespace app\modules\students\controllers;

use Yii;
use app\modules\students\models\Students;
use app\modules\students\models\StudentsSearch;
use app\modules\students\models\CsvForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\User;
use yii\db\Query;
use app\modules\students\models\Title;
use app\modules\students\models\Staff;
use app\modules\students\models\Ganttchart;
use app\modules\students\models\Logbook;
/**
 * StudentsController implements the CRUD actions for Students model.
 */
class StudentsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            // 'access' => [
            //     'class' => \yii\filters\AccessControl::className(),
            //     'rules' => [
            //         [
            //             'allow' => true,
            //             'actions' => ['index','view','create','update','delete','import'],
            //             'roles' => ['manageStudents'],
            //         ],
            //         [
            //             'allow' => true,
            //             'actions' => ['view-students-profile'],
            //             'roles' => ['viewStudents'],
            //         ],
            //     ],
            // ],
        ];
    }

    /**
     * Lists all Students models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Students model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Students model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Students();

        if ($model->load($post=Yii::$app->request->post())) {
            $password = sha1($post['Students']['password']);
            $image = UploadedFile::getInstance($model,'picture');
            $auth = Yii::$app->authManager;
            if ($image != ""){
                $model->picture = $image->baseName  . '.' . $image->extension;

                $image->saveAs('profilepic/'. $model->picture);
            }

            $model->save();

            $user = new User();
            $user->username = $model->studentID;
            $user->password = $password;
            $user->role = "4";
            $user->save();

            $authorRole = $auth->getRole('students');
            $auth->assign($authorRole, $user->id);

            return $this->redirect(['view', 'id' => $model->studentID]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Students model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        $imageTemp = $model->picture;

        if ($model->load(Yii::$app->request->post())) {

            $imageLocation = "profilepic/";

            $image = UploadedFile::getInstance($model,'picture');

            if($image != ""){
                $model->picture = $image->baseName  . '.' . $image->extension;

                $image->saveAs('profilepic/'.$model->picture);
                $model->save();
            }else{
                $model->picture = $imageTemp;
                $model->save();

            }


            return $this->redirect(['view', 'id' => $model->studentID]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Students model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $user = User::find()
              ->where(['username'=> $model->studentID])
              ->one();
        $auth = Yii::$app->authManager;

        $connection = \Yii::$app->db;
        $sql = $connection->createCommand('DELETE FROM auth_assignment WHERE user_id='.$user->id)->execute();
        $model->delete();
        $user->delete(); 

        return $this->redirect(['index']);
    }

    /**
     * Finds the Students model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Students the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Students::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewStudentsProfile($id){
        $students = Students::find()
        ->where(['studentID'=>$id])
        ->one();

        $title = Title::find()
        ->where(['student_fk'=>$id])
        ->one();

        // if($title!=null){
        //     var_dump($title->title);
        // }
        // var_dump($title);exit();

        return $this->render('view-students',['students'=>$students,'title'=>$title]);
    }

    public function actionViewStudentsList($title){


        $students = Students::find()
        ->all();

        $searchModel = new StudentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $registeredStudentsTitle = Title::find()->where(['not', ['student_fk' => null]])->all();
        $registeredStudents = [];

        foreach ($registeredStudentsTitle as $title2) {
            array_push($registeredStudents, $title2->student_fk);
        }

        return $this->render('view-students-list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title'=> $title,
            'registeredStudents'=>$registeredStudents,
        ]);
    }

    public function actionViewOwnStudents(){
        $user = Yii::$app->user->identity->attributes;
        $staff = Staff::find()->where(['userID'=>$user['username']])->one();
        $titles = Title::find()->where(['supervisor'=>$staff->id])
                            ->orwhere(['coSupervisor'=>$staff->id])
                            ->orwhere(['moderator'=>$staff->id])
                            ->andwhere(['status'=>1])
                            ->all();




        return $this->render('view-own-students',['titles'=>$titles]);
    }

    public function actionUpdatePhone($id){

        $model = $this->findModel($id);
        //var_dump($model->password);exit();
        if($model->load($post=Yii::$app->request->post())){
            //var_dump($post['Students']['email']);exit();
            $model->email = $post['Students']['email'];
            $model->phone = $post['Students']['phone'];
            //$model->password = $model->password;
            //var_dump($model->email);exit();
            //var_dump($model->password);exit();
            $model->save();
            //var_dump($model);exit();
            return $this->redirect(['view-students-profile','id'=>$model->studentID]);
        } else{

            return $this->render('update_form',['model'=>$model,
                ]);
        }

    }

    public function actionViewOwnStudentsProfile($id){
        $students = Students::find()
        ->where(['studentID'=>$id])
        ->one();

        $title = Title::find()
        ->where(['student_fk'=>$id])
        ->one();
        return $this->render('view-own-students-profile',['students'=>$students,'title'=>$title]);
    }

    public function actionImport()
    {
        $model = new CsvForm;

        if ($model->load($post = Yii::$app->request->post())) {
            
            $file = UploadedFile::getInstance($model,'file');
            $filename = 'Data.'.$file->extension;
            $upload = $file->saveAs('uploads/'.$filename);

            if($upload){
                define('CSV_PATH','uploads/');
                $csv_file = CSV_PATH . $filename;
                $filecsv = file($csv_file);
                print_r($filecsv);
            }
            $auth = Yii::$app->authManager;

            $skip = 0;
            foreach($filecsv as $data){
                if ($skip != 0){
 
                    $hasil = explode(",",$data);   
                    $student = new Students();
                    $student->studentID = $hasil[0];
                    $student->name= $hasil[1];
                    $student->race= $hasil[2];
                    $student->gender= $hasil[3];
                    $student->email=  $hasil[4];
                    $student->phone=  $hasil[5];
                    $student->faculty= $hasil[6];
                    $student->course= $hasil[7];
                    $student->fypType= $hasil[8];
                    $save_status = $student->save();
                    var_dump($save_status);
                    
                    $user = new User();
                    $user->username = $student->studentID;
                    $user->password = sha1("password");
                    $user->role = "4";
                    $user->save();  

                    $auth->assign($auth->getRole('students'), $user->id);

                }
                $skip++;    
            }   
            unlink('uploads/'.$filename);
             return $this->redirect(['students/index']);
        }
        else{
            return $this->render('../import',['model'=>$model]);
        }
    }   


}
