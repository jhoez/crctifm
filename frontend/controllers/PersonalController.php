<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use frontend\models\Perscomedor;
use frontend\models\PerscomedorSearch;
use frontend\models\Personal;
use frontend\models\PersonalSearch;
use frontend\models\Departamento;
use frontend\models\DepartamentoSearch;
use frontend\models\Invitado;
use frontend\models\Usuario;
use kartik\mpdf\Pdf;
use yii\helpers\HtmlPurifier;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * PersonalController implements the CRUD actions for Perscomedor model.
 */
class PersonalController extends Controller
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

    public function actionReportespdf()
    {
        $perscomedor = new Perscomedor;

        if ( $perscomedor->load(Yii::$app->request->post()) ) {
            if ( $perscomedor->validate() ) {
                //API MPDF
                $pdf = Yii::$app->pdf;
                $API = $pdf->api;
                $API->setAutoTopMargin = 'stretch';
                $API->setAutoBottomMargin = true;
                $cabecera = Html::img(Yii::$app->getBasePath().'/web/img/cintillotifm.jpg');
                $API->SetHTMLHeader($cabecera);
                // Yii::$app->basePath igual a Yii::$app->getBasePath()
                $stylesheet = file_get_contents(Yii::$app->getBasePath().'/web/css/csspdf.css');
                $API->WriteHTML($stylesheet,1);
                $pdfFilename = 'Reporte_de_fecha_'.$perscomedor->created_at.'.pdf';

                $query = new Query;
                $query->select(['dep.nombdepart,count(fkdepart) as contador'])
                    ->from('comedor.perscomedor')
                    ->join(
                        'INNER JOIN',
                        'comedor.departamento as dep',
                        'dep.iddepart = comedor.perscomedor.fkdepart'
                    )
                    ->where(['created_at'=>$perscomedor->created_at])
                    ->groupBy('fkdepart,dep.nombdepart')
                    ->orderBy('fkdepart');
                $command = $query->createCommand();
                $personalinterno = $command->queryAll();

                $query = new Query;
                $query->select(['ente,count(ente) as contador'])
                    ->from('comedor.invitado')
                    ->where(['created_at'=>$perscomedor->created_at])
                    ->groupBy('ente')
                    ->orderBy('ente');
                $command = $query->createCommand();
                $personalexterno = $command->queryAll();

                if ($personalinterno !== [] || $personalexterno !== []) {
                    Yii::$app->session->setFlash('error','No existe la data del personal a exportar!!');
                }

                $vista = $this->renderPartial('_reportespdf',[
                    'personalinterno'=>$personalinterno,
                    'personalexterno'=>$personalexterno
                ]);
                $API->WriteHtml($vista);
                $API->Output($pdfFilename,'D');
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Lists all Perscomedor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $perscomedor = new Perscomedor;
        $searchModel = new PerscomedorSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ( Yii::$app->user->can('administrador') ) {
            $dataProvider->query->where([
                'created_at' => date("Y-m-d")
            ]);
        }

        if ( Yii::$app->user->can('personal') ) {
            $dataProvider->query->where([
                'fkdepart'=>Yii::$app->user->identity->fkdepart,
                'created_at' => date("Y-m-d"),
            ]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'perscomedor' => $perscomedor
        ]);

    }

    /**
     * Displays a single Perscomedor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $purifier = new HtmlPurifier;
        $param = [];
        foreach (Yii::$app->request->get('aux') as $key => $value) {
            $param[$key] = $purifier->process($value);
        }
        $comedor = Perscomedor::find()->where([
            'created_at'=>date('Y-m-d'),
            'idperscom'=>$param,
        ])->all();
        return $this->render('view', [
            'comedor' => $comedor,
        ]);
    }

    /**
     * Creates a new Perscomedor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $comedor = null;
        $aux = null;
        $personal = personal::find()->where(['fkdepart'=>Yii::$app->user->identity->fkdepart])->all();
        $perscomedor = new Perscomedor;

        /*if ($perscomedor->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            Yii::$app->session->setFlash('error', 'El trabajador ya fue registrado para el ALMUERZO!!');
            $this->refresh();
            return ActiveForm::validate($perscomedor);
        }*/

        if ( $perscomedor->load(Yii::$app->request->post()) ) {
            $formpers = Perscomedor::find()->where([
                'created_at'=>date('Y-m-d'),
                'fkpers'=>$perscomedor->fkpers,
            ])->one();
            if ( $formpers === NULL ) {
                foreach ($perscomedor->fkpers as $key => $value) {
                    $comedor = new Perscomedor;
                    $comedor->fkuser = Yii::$app->user->getId();
                    $comedor->fkpers = $value;
                    $comedor->fkdepart = Yii::$app->user->identity->fkdepart;
                    $comedor->created_at = $perscomedor->created_at;
                    $comedor->save();
                    $aux[] = $comedor->idperscom;
                }
            } else {
                Yii::$app->session->setFlash('error', "El trabajador que intenta registrar ya fue registrado!!");
                return $this->redirect(['create']);
            }
            return $this->redirect(['view', 'aux'=>$aux]);
        }

        if (
            (
                Yii::$app->user->can('personal') ||
                Yii::$app->user->can('despacho') ||
                Yii::$app->user->can('administrador')
            ) && ( date('H:i:s am') <= '09:00:00 am' && date('H:i:s am') >= '05:00:00 am' )
        ) {
            return $this->render('create', [
                'personal' => $personal,
                'perscomedor' => $perscomedor,
            ]);
        }else {
            return $this->redirect(['/site/notfound']);
        }

        if( Yii::$app->user->can('superadmin') ){
            return $this->render('create', [
                'personal' => $personal,
                'perscomedor' => $perscomedor,
            ]);
        }
    }

    /**
     * Updates an existing Perscomedor model.
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

        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->idperscom]);
        //}

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Perscomedor model.
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
     * Finds the Perscomedor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Perscomedor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Perscomedor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     *  vista index de personal
     *  @return Objet Personal
     */
    public function actionIndexpers()
    {
        $searchModel = new PersonalSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexpers',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     *
     *
     */
    public function actionCreatepers()
    {
        $personal = new Personal;
        $userpers = Usuario::find()->where(['!=','fkdepart',0])->all();
        $departamento = Departamento::find()->all();

        if ( $personal->load(Yii::$app->request->post()) ) {
            if ( $personal->validate() ) {
                //echo "<pre>";var_dump($personal);die;
                if ( $personal->save() ) {
                    return $this->redirect(['viewpers','id'=>$personal->idpers]);
                }
            }
        }

        return $this->render('createpers',[
            'personal' => $personal,
            'departamento'=>$departamento,
            'userpers'=>$userpers
        ]);
    }

    /**
     * Displays a single Perscomedor model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewpers()
    {
        $purifier = new HtmlPurifier;
        $param = $purifier->process( Yii::$app->request->get('id') );
        $personal = Personal::find()->where(['idpers'=>$param])->one();
        return $this->render('viewpers', [
            'personal' => $personal,
        ]);
    }

    /**
     *
     *
     */
    public function actionUpdatepers()
    {
        $userpers = Usuario::find()->where(['!=','fkdepart',0])->all();
        $departamento = Departamento::find()->all();

        $purifier = new HtmlPurifier;
        $param = $purifier->process( Yii::$app->request->get('id') );
        $personal = Personal::findOne($param);

        if ( $personal->load(Yii::$app->request->post()) ) {
            if ( $personal->validate() ) {

                if ($personal->save()) {
                    return $this->redirect(['viewpers', 'id' => $personal->idpers]);
                }
            }
        }

        return $this->render('updatepers',[
            'personal' => $personal,
            'departamento'=>$departamento,
            'userpers'=>$userpers
        ]);
    }

    /**
     * Deletes an existing Perscomedor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeletepers()
    {
        $purifier = new HtmlPurifier;
        $param = $purifier->process(Yii::$app->request->get('id'));
        Personal::findOne($param)->delete();

        return $this->redirect(['indexpers']);
    }
}
