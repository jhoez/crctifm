<?php if($personalinterno != null):?>
<div class="text-right"><b>Fecha: </b><?=date("d/m/Y");?></div>
<br>
<h2 class="text-center">Control de almuerzo</h2>
<div class="">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Departamento</th>
                <th>Cantidad de Personal</th>
                <th>Firma</th>
            </tr>
        </thead>
            <tbody>
                <?php
                    $conteo=0;
                    foreach($personalinterno as $data):
                ?>
                    <tr>
                        <td><?=$data['nombdepart']?></td>
                        <td><?=$data['contador']?></td>
                        <td></td>
                    </tr>
                <?php
                    $conteo+=$data['contador'];
                    endforeach;
                ?>
                <tr><td colspan="3" class="text-center">Total de personal:<?=$conteo ?></td></tr>
            </tbody>
    </table>
    <?php if ($personalexterno !== []){?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Ente externo</th>
                    <th>Cantidad de Personal</th>
                    <th>Firma</th>
                </tr>
            </thead>
                <tbody>
                    <?php
                        $conteope=0;
                        foreach($personalexterno as $data):
                    ?>
                        <tr>
                            <td><?=$data['ente']?></td>
                            <td><?=$data['contador']?></td>
                            <td></td>
                        </tr>
                    <?php
                        $conteope+=$data['contador'];
                        endforeach;
                    ?>
                    <tr><td colspan="3" class="text-center">Total de personal:<?=$conteope ?></td></tr>
                </tbody>
        </table>
    <?php } ?>
</div>
<?php endif;?>