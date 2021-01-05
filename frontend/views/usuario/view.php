<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Usuario */

$this->title = $usuario->username;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuario-view">
    <p>
        <?= Html::a('Usuarios', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $usuario,
        'attributes' => [
            'iduser',
            'username',
            'auth_key',
            'password',
            'password_reset_token',
            'email:email',
            'status',
            'created_at',
            'updated_at',
            'verification_token',
            'fkdepart',
        ],
    ]) ?>

</div>
