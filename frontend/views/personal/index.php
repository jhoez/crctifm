<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchPerscomedor */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personal comedor';
$this->params['breadcrumbs'][] = $this->title;
$fecha = date("Y-m-d");
?>
<div class="pers-index">
    <?php if ( Yii::$app->user->can('personal') || Yii::$app->user->can('superadmin') ): ?>
        <p>
            <?= Html::a('Agregar personal', ['create'], ['class' => 'btn btn-primary']) ?>
            <?php if(Yii::$app->user->can('superadmin')): ?>
                <?= Html::a('Crear personal', ['createpers'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Personal', ['indexpers'], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
        </p>
    <?php endif; ?>

    <?php if ( Yii::$app->user->can('administrador') || Yii::$app->user->can('superadmin') ): ?>
        <div class="pers-form">
            <div class="row clearfix">
                <div class="col-md-offset-4 col-md-4">
                    <h4 class="text-center">Exportar PDF de personal del dia</h4>
                    <?php $form = ActiveForm::begin([
                        'id'=>'reportedia',
                        'method' => 'post',
                        'action'=>Url::toRoute('/personal/reportespdf'),
                        'enableClientValidation'=>true,
                        //'enableAjaxValidation' => true,
                    ]); ?>
                    <div class="form-group">
                        <?= Html::activeHiddenInput($perscomedor,'created_at',['value'=>$fecha]);?>
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Exportar', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Departamento',
                'attribute'=>'nombdepart',
                'value'=>function($data){
                    return $data->getdepartamento() !== null ? $data->getdepartamento()->nombdepart : 'Sin departamento';
                }
            ],
            [
                'label'=>'Personal',
                'attribute'=>'nombcompleto',
                'value'=>function($data){
                    return $data->getpersonal()->nombcompleto;
                }
            ],
            [
                'label'=>'Cedula',
                'attribute'=>'ci',
                'value'=>function($data){
                    return $data->getpersonal()->ci;
                }
            ],
            [
                'label'=>'Fecha',
                'attribute'=>'created_at',
                'value'=> function($data){
                    return $data->created_at;
                },
                'filter'=> DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'language' => 'es',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
                'visible'=>Yii::$app->user->can('administrador') || Yii::$app->user->can('superadmin')
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Acción',
                'headerOptions'=>['width'=>'30'],
                'template'=>'{delete}',
                'visible'=> (
                                Yii::$app->user->can('superadmin') ||
                                Yii::$app->user->can('personal') ||
                                Yii::$app->user->can('despacho')
                            ) &&
                            ( date('H:i:s am') <= '09:00:00 am' && date('H:i:s am') >= '05:00:00 am' ),
                'buttons'=> [
                    'delete' => function($url,$model){
                        return Html::a(
                            Html::img('@web/fonts/cross.svg'),
                            $url,
                            ['data' => ['confirm' => 'Esta seguro de eliminar el registro?']]
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>
