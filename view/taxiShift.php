<?php
/**
 * @var int $i
 * @var int $minus
 * @var \Kelogub\Taxistation\Shift\TaxiShift $shift
 * @var TaxiCar[] $cars
 * @var callable $getCarId
 */

use Kelogub\Taxistation\Car\TaxiCar;

?>
<div class="TaxiShift">
    <div><b>Смена <?= $i ?>:</b></div>
    <div class="summary">
        <div class="drovenKm"><b>Километраж: <?= $shift->getDrovenKm() ?></b></div>
        <div class="usedOil"><b>Расход топлива: <?= $shift->getUsedOil() ?> л.</b></div>
    </div>
    <hr style="background: #000; height: 4px; border: none">
    <div class="drivers">
        <?php foreach ($shift->getDriverShifts() as $driverShiftKey => $driverShift) : ?>
            <div class="driver <?= $driverShift->getDrovenKm() == 0 ? "zeroKm" : "" ?>">
                <div class="driverName">Водитель <?= $driverShift->getDriverName() ?></div>
                <div class="drovenKm">Километраж: <?= $driverShift->getDrovenKm() ?></div>
                <div class="usedOil">Расход топлива: <?= $driverShift->getUsedOil() ?> л.</div>
                <div class="drivesAmount">Количество поездок: <?= $driverShift->getDrovenKm() / 7 ?></div>
                <div class="usedCars">
                    <?php foreach ($driverShift->getUsedCars() as $usedKarKey => $usedCar) :
                        /**
                         * @var TaxiCar $usedCar
                         **/ ?>

                        <div class="car <?= array_key_last($driverShift->getUsedCars()) == $usedKarKey && !$usedCar->isOnRepair() ? "" : "red" ?>">
                            <?= $usedCar . " " . $getCarId($usedCar) ?>
                            <div class="drivesAmount">Поездок: <?= $usedCar->getRides()?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?= ($driverShiftKey === array_key_last($shift->getDriverShifts()) ? "" : "<hr/>") ?>
        <?php endforeach; ?>
    </div>
</div>
