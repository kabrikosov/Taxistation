<?php
/**
 * @var int $i
 * @var int $minus
 * @var \Kelogub\Taxistation\Shift\TaxiShift $shift
 * @var \Kelogub\Taxistation\Car\TaxiCar[] $cars
 * @var callable $getCarId
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
        <?php foreach ($shift->getDriverShifts() as $driverShiftKey => $driverShift) :?>
            <div class="driver <?= $driverShift->getDrovenKm()==0 ? "zeroKm" : ""?>">
                <div class="driverName">Водитель <?= $driverShift->getDriverName() ?></div>
                <div class="drovenKm">Километраж: <?= $driverShift->getDrovenKm() ?></div>
                <div class="usedOil">Расход топлива: <?= $driverShift->getUsedOil() ?> л.</div>
                <div class="usedCars">
                    <?php foreach ($driverShift->getUsedCars() as $usedKarKey => $usedCar) { ?>

                        <div class="car <?= array_key_last($driverShift->getUsedCars()) == $usedKarKey && !$usedCar->isOnRepair() ? "" : "red" ?>">
                            <?= $usedCar . " " . $getCarId($usedCar) ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?= ($driverShiftKey === array_key_last($shift->getDriverShifts()) ? "" : "<hr/>") ?>
        <?php endforeach;?>
    </div>
</div>
