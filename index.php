<!--     Formulario simple para introducir Numero de escalones-->

<h2>WoowUp - Challenge</h2>

<form action="index.php" method="post">
    <p>Numero de Escalones: <input type="number" name="escalones" /></p>
    <p><input type="submit" /></p>
</form>

<?php
require 'vendor/autoload.php';
include_once("./src/EscaleraService.php");
include_once("./src/RecompraService.php");

$escaleraService=new EscaleraService();
$escalones=$_POST['escalones']??null;
if(isset($escalones)) {
    $movimientos = $escaleraService->execute($escalones);
    echo $movimientos . " posibles movimientos para ".$escalones." escalones";
    echo "<br >";
    echo "<br >";
}

$file=file_get_contents('purchases-v2.json');
$purchases=json_decode($file,true);
$recompraService=new RecompraService();

$results=$recompraService->execute($purchases['customer']['purchases']);

echo "<h4>Productos</h4> <br>";
?>
<table style="width:50%; text-align: left">
    <tr>
        <th>Sku</th>
        <th>Nombre</th>
        <th>Proxima compra</th>
    </tr>
    <?php foreach($results as $result) { ?>
    <tr>
        <td><?= $result['sku'] ?></td>
        <td><?= $result['name'] ?></td>
        <td><?= $result['next_purchase_date'] ?></td>
    </tr>
    <?php }?>
</table>



