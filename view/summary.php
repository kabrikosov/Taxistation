<?php
/**
 * @var TaxiDriver[] $drivers
 * @var array $summary
 * @var TaxiShift $shift
 * @var TaxiCar $brokenCar
 * @var int $minus
 * @var callable $getCarId
 */

use Kelogub\Taxistation\Car\TaxiCar;
use Kelogub\Taxistation\Driver\TaxiDriver;
use Kelogub\Taxistation\Shift\TaxiShift;

?>
</section>
<section>
    <div class="carsReport">
        <div class="reportName"><b>Битые за смену машины:</b></div>
        <hr style="background: #000; height: 4px; border: none">
        <?php $brokenCars = $shift->getBrokenCars();
        usort($brokenCars, function ($a, $b){
            return spl_object_id($a['car']) - spl_object_id($b['car']);
        });?>
        <?php foreach ($brokenCars as $brokenCarId => $brokenCar):?>
            <div class="carReport">
                <div class="carName">
                    <?= $brokenCar['car'] . " " . $getCarId($brokenCar['car'])  ?>
                </div>
                <div class="<?= $brokenCar['car']->isOnRepair() ? "redFont" : "greenFont" ?>">
                    <?= $brokenCar['car']->isOnRepair() ? "Отсалось ремонтироваться дней: {$brokenCar['car']->getRepairingDays()}" : "Готова к поездке" ?>
                </div>
                <div>Побита раз: <?= $brokenCar['crashes'] ?></div>
            </div>
            <?= ($brokenCarId === array_key_last($shift->getBrokenCars()) ? "" : "<hr/>") ?>
        <?php endforeach; ?>
    </div>
    <section class="summary">
        <div class="driversReport">
            <div class="reportName"><b>Отчет по водителям:</b></div>
            <hr style="background: #000; height: 4px; border: none">
            <?php foreach ($drivers as $driverKey => $driver) : ?>
                <div class="driver">
                    <div class="driverName"><?= $driver->getName() ?>:</div>
                    <div class="drovenKm">Километраж: <?= $driver->getDrovenKm() ?></div>
                    <div class="usedOil">Расход топлива: <?= $driver->getUsedOil() ?> л.</div>
                    <div class="usedCars">
                        <?php foreach ($driver->getAllUsedCars() as $usedCar) : ?>
                            <div class="car <?= !$usedCar->isOnRepair() ? "" : "red" ?>">
                                <?= $usedCar . " " . $getCarId($usedCar) ?>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
                <?= ($driverKey === array_key_last($drivers) ? "" : "<hr/>") ?>
            <?php endforeach; ?>
        </div>
        <div class="summaryReport">
            <div class="reportName"><b>Отчет по всем сменам:</b></div>
            <hr style="background: #000; height: 4px; border: none">
            <div class="drovenKm">Километраж: <?= $summary['km'] ?></div>
            <hr/>
            <div class="usedOil">Расход топлива: <?= $summary['oil'] ?> л.</div>
        </div>
    </section>
</section>