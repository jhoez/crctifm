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
        <?= Html::a('Personal', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <div class="row clearfix">
        <div class="col-md-offset-4 col-md-4">
            <table class="table">
                <thead>
                    <tr>
                      <th scope="col">Personal</th>
                      <th scope="col">Departamento</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=0; for($i; $i < count($comedor);$i++): ?>
                    <tr>
                        <td><?=$comedor[$i]->getpersonal()->nombcompleto; ?></td>
                        <td><?=$comedor[$i]->getdepartamento()->nombdepart; ?></td>
                    </tr>
                    <?php endfor; ?>
                    <tr>
                        <td colspan="<?=$i ?>" class='text-center'>Cantidad de personal: <?=$i;?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
