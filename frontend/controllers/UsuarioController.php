<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Usuario;
use frontend\models\UsuarioSearch;
use frontend\models\Departamento;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
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
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $usuario = $this->findModel($id);
        return $this->render('view', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $usuario = new Usuario;
        $departamento = Departamento::find()->all();

        if ( $usuario->load(Yii::$app->request->post()) ) {
            if ( $usuario->validate() ) {
                $usuario->generateAuthKey();
                $usuario->generatePasswordResetToken();
                $usuario->status=1;
                $usuario->generateEmailVerificationToken();
                $usuario->created_at= date( "Y-m-d H:i:s" );
                if ( $usuario->save() ) {
                    // se asigna por defecto el role tutor al usuario creado.
                    $auth = Yii::$app->authManager;
                    $personalRole = $auth->getRole('personal');
                    $auth->assign($personalRole, $usuario->getId());
                    Yii::$app->session->setFlash('succes','El usuario fue registrado con Role de Personal!!');
                    return $this->redirect(['view', 'id' => $usuario->id]);
                } else {
                    Yii::$app->session->setFlash('error','El usuario no fue registrado!!');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'usuario' => $usuario,
            'departamento'=>$departamento,
        ]);
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $usuario = $this->findModel( Yii::$app->request->get('id') );
        $departamento = Departamento::find()->all();

        if ( $usuario->load(Yii::$app->request->post()) ) {
            if ( $usuario->validate() ) {
                $usuario->updated_at= date( "Y-m-d H:i:s" );
                if ( $usuario->save() ) {
                    Yii::$app->session->setFlash('succes','El usuario fue registrado Actualizado!!');
                    return $this->redirect(['view', 'id' => $usuario->id]);
                } else {
                    Yii::$app->session->setFlash('error','El usuario no fue Actualizado!!');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'usuario' => $usuario,
            'departamento'=>$departamento,
        ]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $this->findModel( Yii::$app->request->get('id') )->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
