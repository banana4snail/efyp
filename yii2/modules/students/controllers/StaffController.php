<?php

namespace app\modules\students\controllers;

use Yii;
use app\modules\students\models\Staff;
use app\modules\students\models\StaffSearch;
use app\modules\students\models\CsvForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use yii\db\Query;
use yii\web\UploadedFile;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class StaffController extends Controller
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
                    'export' => ['POST']
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','view','create','update','delete','export','import'],
                        'roles' => ['manageStaff'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        var_dump(Yii::$app->request->queryParams);
//        exit;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Staff model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Staff model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Staff();

        if ($model->load($post = Yii::$app->request->post())) {

            // var_dump($model);exit();
            $password = sha1($post['Staff']['password']);
            //var_dump($password);exit();
            $auth = Yii::$app->authManager;
            if($post['Staff']['roleArray']){
                $model->role = implode(",", $post['Staff']['roleArray']);

            }

            $y = sizeof($post['Staff']['roleArray']);
            $model->save();
            // var_dump($model->id);exit();
            $user = new User();
            $user->username= $model->userID;
            $user->password = $password;
            $user->role = $model->role;
            $user->save();
            //var_dump($user);exit();

            for($i=0; $i<$y; $i++) {

                if($post['Staff']['roleArray'][$i] == '1'){
                    $authorRole = $auth->getRole('admin');
                }elseif ($post['Staff']['roleArray'][$i] == '2'){
                    $authorRole = $auth->getRole('fypCoordinator');
                }elseif ($post['Staff']['roleArray'][$i] == '3') {
                    $authorRole = $auth->getRole('supervisor');
                }
                 // var_dump($authorRole->name);exit();
                //var_dump($user->id);exit();
                $auth->assign($authorRole, $user->id);
            }

            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing Staff model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load($post = Yii::$app->request->post())) {

            $auth = Yii::$app->authManager;
              // var_dump($post);exit();
            if($post['Staff']['roleArray'][1]){
                // var_dump("ddd");
                array_shift($post['Staff']['roleArray']);
                $model->role = implode(",", $post['Staff']['roleArray']);
            }
          
            $model->save();
         

            $user = User::find()
            ->where(['username'=> $model->userID])
            ->one();

            $user->role = $model->role;
            $user->save();

            $connection = \Yii::$app->db;
            $sql = $connection->createCommand('DELETE FROM auth_assignment WHERE user_id='.$user->id)->execute();

            $y = sizeof($post['Staff']['roleArray']);
            

            for($i=0; $i<$y; $i++) {

                if($post['Staff']['roleArray'][$i] == '1'){
                    $authorRole = $auth->getRole('admin');
                }elseif ($post['Staff']['roleArray'][$i] == '2'){
                    $authorRole = $auth->getRole('fypCoordinator');
                }elseif ($post['Staff']['roleArray'][$i] == '3') {
                    $authorRole = $auth->getRole('supervisor');
                }
                // var_dump($post['Staff']['roleArray'][$i]);
                $auth->assign($authorRole, $user->id);
            }
            // exit();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $roleArray = explode(",", $model->role);

            return $this->render('update', [
                'model' => $model,
                'roleArray' => $roleArray,
            ]);
        }
    }

    /**
     * Deletes an existing Staff model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        //var_dump($model);exit();
        
        $user = User::find()
              ->where(['username'=> $model->userID])
              ->one();

        $auth = Yii::$app->authManager;

        $connection = \Yii::$app->db;
        $sql = $connection->createCommand('DELETE FROM auth_assignment WHERE user_id='.$user->id)->execute();
        $model->delete();
        $user->delete();
        


        return $this->redirect(['index']);
    }

     public function actionExport(/*$dataProvider*/){

         //$searchModel = new StaffSearch();
         $id = Yii::$app->request->getQueryParam('userID');

//         $searchModel = new StaffSearch();
//         $dataProvider = $searchModel->search($id);




         var_dump($id);
         exit;

        //$this->render('index',array('model'=>$dataProvider)); 

        //$users = $dataProvider->getModels();
         
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Users.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('No', 'First Name', 'Last Name', 'Email'));


        foreach($dataProvider->models as $model){
            $name = $model->name;
            $id = $model->id;
            fputcsv($output, array($name, $id));

            //var_dump($model);
         
       //  //if (count($users) > 0) {
       //     // foreach ($users -> attributes as $attributes => $row) {
       //      foreach ($users as $row) {
       //         fputcsv($output, $row);
       //      }
                
       //     // }
       // // }

        // $count = 0;
        // for($count=0; $count<=6; $count++){

        //     $row = $users->limit($count)->one();

        //     fputcsv($output, array($row-> name, $row-> email));

        // }

        // foreach($users as $row){
        //     $name = $row -> name;
        //     $id = $row -> id;
        //     fputcsv($output, $dataProvider->totalCount);
        // }

        }

        fclose($output);  
        

    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Staff::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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

            $skip = 0; //skip first line
            foreach($filecsv as $data){
                if ($skip!=0){
                    $hasil = explode(",",$data);
                    $user = new User();
                    $user->username = $hasil[0];
                    $staff = new Staff();
                    $staff->userID= $hasil[0];
                    
                    if(strlen($hasil[1]) == 1){
                        $user->password = sha1(preg_replace('/\s+/', '', $hasil[7])); //escape all whitespace
                        $user->role = $hasil[1];
                        $user->save();
                        
                        $staff->role = $hasil[1]; 
                        $staff->name = $hasil[2];
                        $staff->faculty_fk=$hasil[3];
                        $staff->departments_fk=$hasil[4];
                        $staff->email=$hasil[5];
                        $staff->contactNo =$hasil[6];
                        
                            if($hasil[1] == '1'){
                                $auth->assign($auth->getRole('admin'), $user->id);
                            }elseif ($hasil[1] == '2'){
                                $auth->assign($auth->getRole('fypCoordinator'), $user->id);
                            }elseif ($hasil[1] == '3') {
                                $auth->assign($auth->getRole('supervisor'), $user->id);
                            }

                    }elseif(strlen($hasil[2]) == 2){
                        $user->password = sha1(preg_replace('/\s+/', '', $hasil[8])); 
                        $user->role = preg_replace('/\"/', '', $hasil[1].','.$hasil[2]);
                        $user->save();
                        
                        $staff->role = preg_replace('/\"/', '', $hasil[1].','.$hasil[2]);
                        $staff->name = $hasil[3];
                        $staff->faculty_fk=$hasil[4];
                        $staff->departments_fk=$hasil[5];
                        $staff->email=$hasil[6];
                        $staff->contactNo =$hasil[7];
                        
                        $role1 = preg_replace('/\"/', '', $hasil[1]);
                        $role2 = preg_replace('/\"/', '', $hasil[2]);
                        
                            if($role1||$role2 == '1'){
                                $auth->assign($auth->getRole('admin'), $user->id);
                            }elseif ($role1||$role2 == '2'){
                                $auth->assign($auth->getRole('fypCoordinator'), $user->id);
                            }elseif ($role1||$role2 == '3') {
                                $auth->assign($auth->getRole('supervisor'), $user->id);
                            }
                                    
                    }elseif(strlen($hasil[3]) == 2){
                        $user->password = sha1(preg_replace('/\s+/', '', $hasil[9])); 
                        $user->role = preg_replace('/\"/', '', $hasil[1].','.$hasil[2].','.$hasil[3]);
                        $user->save();
                        
                        $staff->role = preg_replace('/\"/', '', $hasil[1].','.$hasil[2].','.$hasil[3]);
                        $staff->name = $hasil[4];
                        $staff->faculty_fk=$hasil[5];
                        $staff->departments_fk=$hasil[6];
                        $staff->email=$hasil[7];
                        $staff->contactNo =$hasil[8];
                    
                        $auth->assign($auth->getRole('admin'), $user->id);
                        $auth->assign($auth->getRole('fypCoordinator'), $user->id);
                        $auth->assign($auth->getRole('supervisor'), $user->id);
                    }
                    $staff->save();
                }
                $skip++;
            }   
            unlink('uploads/'.$filename);
            return $this->redirect(['staff/index']);
        }
        else{
            return $this->render('../import',['model'=>$model]);
        }
    }   
}


