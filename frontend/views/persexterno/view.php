<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Invitado */

$this->title = 'Detalles';
$this->params['breadcrumbs'][] = ['label' => 'Personal externo', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="invitado-view">
    <p>
        <?= Html::a('Personal externo', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <h1 class="text-center"><?= Html::encode($persexterno->nombcompleto) ?></h1>


    <?= DetailView::widget([
        'model' => $persexterno,
        'attributes' => [
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
                'value'=>function($data){
                    return $data->created_at;
                },
            ],
            /*[
                'label'=>'Usuario',
                'attribute'=>'username',
                'value'=>function($data){
                    return $data->getUsuar()->username;
                },
            ],*/
        ],
    ]) ?>

</div>
