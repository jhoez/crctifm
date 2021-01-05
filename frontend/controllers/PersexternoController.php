<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Invitado;
use frontend\models\InvitadoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\HtmlPurifier;

/**
 * PersonalinvController implements the CRUD actions for Invitado model.
 */
class PersexternoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Invitado models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InvitadoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ( Yii::$app->user->can('administrador') ) {
            $dataProvider->query->where(['created_at'=>date('Y-m-d')]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invitado model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $purifier = new HtmlPurifier;
        $param = $purifier->process(Yii::$app->request->get('id'));
        $persexterno = $this->findModel($param);
        return $this->render('view', [
            'persexterno' => $persexterno,
        ]);
    }

    /**
     * Creates a new Invitado model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $persexterno = new Invitado;

        if ( $persexterno->load(Yii::$app->request->post()) ) {
            if ($persexterno->validate()) {
                $inv = Invitado::find()->where(['nombcompleto'=>$persexterno->nombcompleto])->one();
                if ($inv === NULL ) {
                    $persexterno->fkuser = Yii::$app->user->getId();
                    if ($persexterno->save()) {
                        return $this->redirect(['view', 'id' => $persexterno->idinv]);
                    }
                }else {
                    Yii::$app->session->setFlash('error','El personal externo que intenta registrar ya esta registrado!!');
                    return $this->redirect(['create']);
                }
            }
        }

        if (
            (
                Yii::$app->user->can('personal') ||
                Yii::$app->user->can('despacho') ||
                Yii::$app->user->can('administrador')
            ) && ( date('H:i:s pm') <= '19:00:00 pm' && date('H:i:s am') >= '05:00:00 am' )
        ) {
            return $this->render('create', [
                'persexterno' => $persexterno,
            ]);
        }else {
            return $this->redirect(['/site/notfound']);
        }

        if( Yii::$app->user->can('superadmin') ){
            return $this->render('create', [
                'persexterno' => $persexterno,
            ]);
        }

    }// fin action

    /**
     * Updates an existing Invitado model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $purifier = new HtmlPurifier;
        $param = $purifier->process(Yii::$app->request->get('id'));
        $model = $this->findModel($param);

        /*if ( $model->load(Yii::$app->request->post()) ) {
            if ($model->validate()){
                $persexterno->fkuser = Yii::$app->user->getId();
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->idinv]);
                }
            }
        }*/

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Invitado model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $purifier = new HtmlPurifier;
        $param = $purifier->process(Yii::$app->request->get('id'));
        $this->findModel($param)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Invitado model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invitado the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invitado::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
