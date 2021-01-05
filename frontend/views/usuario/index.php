<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SearchUsuario */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Administrar Usuarios', ['/admin'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Usuario',
                'attribute'=>'username',
                'value'=>function($data){
                    return $data->username;
                }
            ],
            [
                'label'=>'Correo',
                'attribute'=>'email',
                'value'=>function($data){
                    return $data->email;
                }
            ],
            [
                'label'=>'Estado',
                'attribute'=>'status',
                'value'=>function($data){
                    return $data->status === 1 ? 'Usuario Activo':'Usuario Inactivo';
                }
            ],
            [
                'label'=>'F. creado',
                'attribute'=>'created_at',
                'value'=>function($data){
                    return $data->created_at;
                }
            ],
            [
                'label'=>'Departamento',
                'attribute'=>'nombdepart',
                'value'=>function($data){
                    return $data->getdepartamento() !== null ? $data->getdepartamento()->nombdepart : 'sin departamento';
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
