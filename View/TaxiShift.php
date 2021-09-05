<?php
/**
 * @var int $i
 * @var \Kelogub\Taxistation\Controller\ShiftsController $shift
 * @var \Kelogub\Taxistation\Car\TaxiCar[] $cars
 */
?>
<div class="TaxiShift">
    <div>Смена <?= $i ?>:</div>
    <hr/>
    <div class="drivers">
        <?php foreach ($shift->getDriverShifts() as $key => $driverShift) { ?>
            <div class="driver">
                <div class="driverName">Водитель <?= $driverShift->getDriverName() ?></div>
                <div class="drovenKm">Километраж: <?= $driverShift->getDrovenKm() ?></div>
                <div class="usedOil">Расход топлива: <?= $driverShift->getUsedOil() ?> л.</div>
                <div class="usedCars">
                    <?php foreach ($driverShift->getUsedCars() as $key1 => $usedCar) { ?>

                        <div class="car <?= array_key_last($driverShift->getUsedCars()) == $key1 && !$usedCar->isOnRepair() ? "" : "red" ?>">
                            <?= $usedCar . " " . (spl_object_id($usedCar) - 1) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?= ($key === array_key_last($shift->getDriverShifts()) ? "" : "<hr/>") ?>
        <?php } ?>
    </div>
</div>
