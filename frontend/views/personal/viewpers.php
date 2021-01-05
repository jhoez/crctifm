<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Perscomedor */
$this->title = 'Detalles';
$this->params['breadcrumbs'][] = ['label' => 'Personal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="perscomedor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Personal', ['indexpers'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $personal,
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
                'label'=>'Sexo',
                'attribute'=>'sexo',
                'value'=>function($data){
                    return $data->sexo == 'M' ? 'Masculino': 'Femenino';
                },
            ],
            [
                'label'=>'User Departamento',
                'attribute'=>'username',
                'value'=>function($data){
                    return $data->getpersuser()->username;
                },
            ],
            [
                'label'=>'Departamento',
                'attribute'=>'nombdepart',
                'value'=>function($data){
                    return $data->getpersdepart()->nombdepart;
                },
            ],
        ],
        ]) ?>
</div>
