<?php
include "view/header.php"
?>
</section>
<section style="display: flex; flex-direction: column; justify-content: center; align-items: center">
<form action="ind.php" method="post" style="display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%">
    <label style="display: flex; flex-direction: column; justify-content: start; align-items: center; width: 100%; height: 35em">
        <textarea name="json" placeholder="Write JSON data here:" style="width: 50%; height: 80%"></textarea>
    </label>
    <input type="submit" name="submit">
</form>
</section>