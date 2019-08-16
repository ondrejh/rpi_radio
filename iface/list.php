<table>
<?php
    $result = $db->query('SELECT id, name, url FROM stations');
    while (true) {
        $row = $result->fetchArray(SQLITE3_NUM);
        if ($row == false)
            break;
        echo "<tr><td><form><input type='hidden' name='play' value=".$row[0]."><input type='submit' value='Play'></form></td>";
        echo "<td>".$row[1]."</td><td>".$row[2]."</td>";
        echo "<td><form><input type='hidden' name='edit' value=".$row[0]."><input type='submit' value='Edit'></form><td>";
        echo "<td><form><input type='hidden' name='delete' value=".$row[0]."><input type='submit' value='Delete'></form><td></tr>". PHP_EOL;
    }
?>
</table>

<!-- play 0 .. stop -->
<form><input type='hidden' name='play' value=0><input type='submit' value='Stop'></form>

<!-- edit 0 .. nova stanice -->
<form><input type='hidden' name='edit' value=0><input type='submit' value='Přidat stanici'></form>
