<?php
    if ($edit > 0) {
        $result = $db->query('SELECT id, name, url FROM stations WHERE id=='.$edit);
        $row = $result->fetchArray(SQLITE3_NUM);
    }
?>
<form>
    <input type='hidden' name='save' value=<?php echo $edit; ?> >
    Jméno: <input name='name' type='text' <?php if ($edit>0) echo "value='". $row[1]. "'";?> placeholder='název stanice'>
    Url: <input name='url' type='text' <?php if ($edit>0) echo "value='". $row[2]. "'";?> placeholder='url adresa stanice'>
    <input type='submit' value=<?php if ($edit>0) echo "'Upravit'"; else echo "'Přidat'"; ?> >
    <a href='index.php'>Zrušit</a>
</form>
