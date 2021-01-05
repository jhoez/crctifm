<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\InvitadoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Personal externo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invitado-index">
    <p>
        <?= Html::a('Añadir Personal Externo', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Cedula',
                'attribute'=>'ci',
                'value'=>function($data){
                    return $data->ci;
                },
            ],
            [
                'label'=>'Nombre',
                'attribute'=>'nombcompleto',
                'value'=>function($data){
                    return $data->nombcompleto;
                },
            ],
            [
                'label'=>'Ente',
                'attribute'=>'ente',
                'value'=>function($data){
                    return $data->ente;
                },
            ],
            [
                'label'=>'Fecha',
                'attribute'=>'created_at',
                'filter'=> DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'language' => 'es',
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
                'value'=>function($data){
                    return $data->created_at;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Acción',
                'headerOptions'=>['width'=>'30'],
                'template'=>'{view}{update}{delete}',
                'visible'=> (
                                Yii::$app->user->can('superadmin') ||
                                Yii::$app->user->can('personal') ||
                                Yii::$app->user->can('despacho')
                            ) &&
                            ( date('H:i:s am') <= '09:00:00 am' && date('H:i:s am') >= '05:00:00 am' ),
                'buttons'=>[
                    'view'=>function($url,$model){
                        return Html::a(
                            Html::img('@web/fonts/view.svg'),
                            $url
                        );
                    },
                    'update'=>function($url,$model){
                        return Html::a(
                            Html::img('@web/fonts/pencil.svg'),
                            $url
                        );
                    },
                    'delete'=>function($url,$model){
                        return Html::a(
                            Html::img('@web/fonts/cross.svg'),
                            $url
                        );
                    },
                ]
            ],
        ],
    ]); ?>


</div>
