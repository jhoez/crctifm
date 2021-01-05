<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\Perscomedor */

$this->title = 'Personal';
$this->params['breadcrumbs'][] = ['label' => 'Personal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="pers-index">
    <?php if ( Yii::$app->user->can('personal') || Yii::$app->user->can('superadmin') ): ?>
        <p>
            <?= Html::a('Agregar personal', ['create'], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Crear personal', ['createpers'], ['class' => 'btn btn-primary']) ?>
        </p>
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
                    return $data->getpersdepart() !== null ? $data->getpersdepart()->nombdepart : 'Sin departamento';
                }
            ],
            [
                'label'=>'Personal',
                'attribute'=>'nombcompleto',
                'value'=>function($data){
                    return $data->nombcompleto;
                }
            ],
            [
                'label'=>'Cedula',
                'attribute'=>'ci',
                'value'=>function($data){
                    return $data->ci;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Acción',
                'headerOptions'=>['width'=>'30'],
                'template'=>'{viewpers}{updatepers}{deletepers}',
                'visible'=> Yii::$app->user->can('superadmin'),
                'buttons'=> [
                    'viewpers' => function($url,$model){
                        return Html::a(
                            Html::img('@web/fonts/view.svg'),
                            $url//,
                            //['data' => ['confirm' => 'Esta seguro de eliminar el registro?']]
                        );
                    },
                    'updatepers' => function($url,$model){
                        return Html::a(
                            Html::img('@web/fonts/pencil.svg'),
                            $url//,
                            //['data' => ['confirm' => 'Esta seguro de eliminar el registro?']]
                        );
                    },
                    'deletepers' => function($url,$model){
                        return Html::a(
                            Html::img('@web/fonts/cross.svg'),
                            $url//,
                            //['data' => ['confirm' => 'Esta seguro de eliminar el registro?']]
                        );
                    },
                ],
            ],
        ],
    ]); ?>

</div>
