<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Usuario */

$this->title = 'Crear Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuario', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-create">
    <p>
        <?= Html::a('Usuarios', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'usuario' => $usuario,
        'departamento'=>$departamento,
    ]) ?>

</div>
