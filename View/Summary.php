<?php

?>
<section class="summary">
    <div class="driversReport">
        <div>Отчет по водителям:</div>
        <?php foreach ($this->drivers as $driver){?>
            <div class="driverName"><?=$driver->getName()?>: </div>
            <div class="drovenKm">Километраж: <?= $driver->getDrovenKm() ?></div>
            <div class="usedOil">Расход топлива: <?= $driver->getUsedOil() ?> л.</div>
        <?php }?>
    </div>
</section>
