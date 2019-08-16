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

        $result = $db->query('SELECT name FROM stations');
        if ($result->fetchArray() == false) {
            $db->exec("INSERT INTO stations (name, url) VALUES ('Radiožurnál', 'http://icecast7.play.cz/cro1-128.mp3'), ('Beat', 'http://icecast2.play.cz/radiobeat128.mp3'), ('RockMax', 'http://212.111.2.151:8000/rockmax_128.mp3'), ('RockMax Hard', 'http://212.111.2.151:8000/rm_hard_128.mp3');");
            echo "<meta http-equiv='refresh' content='3;url=index.php'/>". PHP_EOL;
            echo "</head><body class='home'><header id='top'><h1>RPi radio - Nová databáze</h1></header><section class='content'><article class='main'>". PHP_EOL;
            echo "<p>Vytvářím nový soubor '". DB_NAME. "'.<br>Prosím čekejte</p>". PHP_EOL;
            echo "</article></section></body></html>". PHP_EOL;
            exit(0);
        }
    
        if (isset($_GET['save'])) {
            $id = $_GET['save'];
            settype($id, 'integer');
            $name = $_GET['name'];
            $url = $_GET['url'];
            echo "<meta http-equiv='refresh' content='3;url=index.php'/>". PHP_EOL;
            if ($id == 0) {
                $search = $db->prepare("INSERT INTO stations (name, url) VALUES (:name, :url)");
                $search->bindParam(":name", $name);
                $search->bindParam(":url", $url);
                $search->execute();
                echo "</head><body class='home'><header id='top'><h1>RPi radio - Nová stanice</h1></header><section class='content'><article class='main'>". PHP_EOL;
                echo "<p>Ukládám novou stanici '". $name. "'.<br>Prosím čekejte</p>". PHP_EOL;
            } else {
                $search = $db->prepare("UPDATE stations SET name=:name, url=:url WHERE id==:id");
                $search->bindParam(":name", $name);
                $search->bindParam(":url", $url);
                $search->bindParam(":id", $id);
                $search->execute();
                echo "</head><body class='home'><header id='top'><h1>RPi radio - Úprava stanice</h1></header><section class='content'><article class='main'>". PHP_EOL;
                echo "<p>Upravuji stanici '". $id. "'.<br>Prosím čekejte</p>". PHP_EOL;
            }
            echo "</article></section></body></html>". PHP_EOL;
            exit(0);
        }
    
        if (isset($_GET['delete'])) {
            $db->exec("DELETE FROM stations WHERE id==". $_GET['delete']);
            echo "<meta http-equiv='refresh' content='3;url=index.php'/>". PHP_EOL;
            echo "</head><body class='home'><header id='top'><h1>RPi radio - Mazání</h1></header><section class='content'><article class='main'>". PHP_EOL;
            echo "<p>Mažu stanici '". $_GET['delete']. "'.<br>Prosím čekejte</p>". PHP_EOL;
            echo "</article></section></body></html>". PHP_EOL;
            exit(0);
        }
    
        if (isset($_GET['edit']))
            $edit = $_GET['edit'];
        else
            $edit = -1;
    ?>
</head>

<body class="home">

    <header id="top">
        <h1>RPi radio
            <?php
                if ($edit == -1)
                    echo "";
                elseif ($edit == 0)
                    echo " - Přidat";
                else
                    echo " - Upravit (". $edit. ")";
            ?>
        </h1>
    </header>

    <section class="content">

        <article class="main">

            <?php
                if ($edit == -1) {
                    include('list.php');
                }
                else {
                    include('edit.php');
                }
            ?>
        </article>

    </section>

</body>
</html>