<?php
/**
 * @var int $i
 * @var int $minus
 * @var \Kelogub\Taxistation\Shift\TaxiShift $shift
 * @var \Kelogub\Taxistation\Car\TaxiCar[] $cars
 */
?>
<div class="TaxiShift">
    <div><b>Смена <?= $i ?>:</b></div>
    <div class="summary">
        <div class="drovenKm"><b>Километраж: <?= $shift->getDrovenKm() ?></b></div>
        <div class="usedOil"><b>Расход топлива: <?= $shift->getUsedOil() ?> л.</b></div>
    </div>
    <hr style="background: #000; height: 4px; border: none">
    <div class="drivers">
        <?php foreach ($shift->getDriverShifts() as $key => $driverShift) { ?>
            <div class="driver">
                <div class="driverName">Водитель <?= $driverShift->getDriverName() ?></div>
                <div class="drovenKm">Километраж: <?= $driverShift->getDrovenKm() ?></div>
                <div class="usedOil">Расход топлива: <?= $driverShift->getUsedOil() ?> л.</div>
                <div class="usedCars">
                    <?php foreach ($driverShift->getUsedCars() as $key1 => $usedCar) { ?>

                        <div class="car <?= array_key_last($driverShift->getUsedCars()) == $key1 && !$usedCar->isOnRepair() ? "" : "red" ?>">
                            <?= $usedCar . " " . (spl_object_id($usedCar) - $minus) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?= ($key === array_key_last($shift->getDriverShifts()) ? "" : "<hr/>") ?>
        <?php } ?>
    </div>
</div>
