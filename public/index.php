<?php
include "../view/header.php"
?>
</section>
<section style="display: flex; flex-direction: column; justify-content: center; align-items: center">
<form action="ind.php" method="post" style="display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%; height: 30em">
    <label style="height: 100%">
        <textarea name="json" placeholder="Write JSON data here:" style="width: 30em; height: 25em"></textarea>
    </label>   <label>Количество дней моделирования
        <input type="number" min="1" max="100" name="days" value="15">
    </label>
    <input type="submit" name="submit">
</form>
</section>