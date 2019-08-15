<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="rating" content="general">
    <meta name="author" content="radio man">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Web radio RPi - db Creator</title>
    <meta name="description" content="Ovládací rozhraní webového rádia - generátor databáze." />
    <meta name="keywords" content="radio, internet, kravál" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/4.0.0/normalize.min.css" media="screen, print" />
    <link rel="stylesheet" type="text/css" href="style.css" media="screen, print" />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,400italic|Oswald&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="favicon.ico" />
    <?php
        define("DB_NAME", "radio.db");
    
        class mydb extends SQLite3 {
            function __construct() {
                $this->open(DB_NAME);
            }
        }

        $db = new mydb();

        $db->exec('CREATE TABLE IF NOT EXISTS stations (id INTEGER PRIMARY KEY AUTOINCREMENT, name varchar(16), url varchar(64))');
        $db->exec('CREATE TABLE IF NOT EXISTS playing (now integer)');

        $newfile = false;
        $result = $db->query('SELECT name FROM stations');
        if ($result->fetchArray() == false) {
            $newfile = true;
            $db->exec("INSERT INTO stations (name, url) VALUES ('Radiožurnál', 'http://icecast7.play.cz/cro1-128.mp3'), ('Beat', 'http://icecast2.play.cz/radiobeat128.mp3'), ('RockMax', 'http://212.111.2.151:8000/rockmax_128.mp3'), ('RockMax Hard', 'http://212.111.2.151:8000/rm_hard_128.mp3');");
            echo "<meta http-equiv='refresh' content='3;url='/>". PHP_EOL;
        }
    ?>
</head>

<body class="home">

    <header id="top">
        <h1>Web radio RPi</h1>
    </header>

    <section class="content">

        <article class="main">
        
        <table>
        <?php
            if ($newfile) {
                echo "<p>Vytvářím nový soubor '".DB_NAME."'.<br>Prosím čekejte</p>";
            }
            else {
                $result = $db->query('SELECT name, url FROM stations');
                $cnt = 1;
                while (true) {
                    $row = $result->fetchArray();
                    if ($row == false)
                        break;
                    echo "<tr><td><form><input type='hidden' name='play' value=".$cnt."><input type='submit' value='".$row[0]."'></form></td><td>".$row[1]."</td>";
                    echo "<td><form><input type='hidden' name='edit' value=".$cnt."><input type='submit' value='Edit'></form><td>";
                    echo "<td><form><input type='hidden' name='delete' value=".$cnt."><input type='submit' value='Delete'></form><td></tr>". PHP_EOL;
                    $cnt ++;
                }
            }
        ?>
        </table>
        <table>
            <tr>
                <!-- play 0 .. stop -->
                <td><form><input type='hidden' name='play' value=0><input type='submit' value='Stop'></form></td>
                <!-- edit 0 .. nova stanice -->
                <td><form><input type='hidden' name='edit' value=0><input type='submit' value='New'></form></td>
            </tr>
        </table>
            
        </article>

    </section>

</body>
</html>