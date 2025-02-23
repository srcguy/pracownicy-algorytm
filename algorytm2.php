<html data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>algorytm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
  </head>
<body class="p-3">
    <h2>wprowadź dane pracownika</h2>
    <form action="algorytm2.php" method="GET">
        <input type="text" name="imie">
        <label class="form-label" for="imie">Imie</label><br>
        <input type="text" name="nazwisko">
        <label class="form-label" for="nazwisko">Nazwisko</label><br>
        <input type="number" name="godziny_tygodniowo">
        <label class="form-label" for="godziny_tygodniowo">Godziny tygodniowo</label><br>
        <input type="number" name="godziny_na_zmiane">
        <label class="form-label" for="godziny_na_zmiane">Godziny na zmianę</label><br>
        <input type="number" name="zmiana">
        <label class="form-label" for="zmiana">Na którą zmianę?</label><br>
        <input type="submit" class="btn btn-light">
    </form>
</body>
</html>
<?php

function start()
{
    $pracownicy = [];
    $zmiany = [];
    $zmiany_na_dzien = 2; //tutaj zmieniamy ile zmian na dzien

    $i = 1;

    for($i = 1; $i < $zmiany_na_dzien * 7 + 1; $i++)
    {
        array_push($zmiany, new zmiana($i, []));
    }

    dodaj_pracownika($pracownicy, $zmiany, $zmiany_na_dzien);
}

function dodaj_pracownika($pracownicy, $zmiany, $zmiany_na_dzien)
{
    $file = fopen("files/".date("Y-m-d hisa").".json", "w");
    if ($_GET != NULL)
    {
        fwrite($file, json_encode(new pracownik($_GET["imie"],$_GET["nazwisko"],$_GET["godziny_tygodniowo"], $_GET["godziny_na_zmiane"], $_GET["zmiana"])));
        fclose($file);
        foreach (glob("files/*.*") as $file)
        {   
            $objfile = fread(fopen($file, "r"), 1000);
            $obj = json_decode($objfile);
            array_push($pracownicy, new pracownik($obj->imie, $obj->nazwisko, $obj->godziny_tydzien, $obj->godziny_zmiana, $obj->zmiana));
        }
        algorytm($pracownicy, $zmiany, $zmiany_na_dzien);
    }
}

function algorytm($pracownicy, $zmiany, $zmiany_na_dzien)
{
    foreach ($pracownicy as $pracownik)
    {
        foreach ($zmiany as $zmiana)
        {
            if ($pracownik->godziny_tydzien > 0)
            {
                $n = 0;
                while (True)
                {
                    $dzielnik = $pracownik->zmiana + $zmiany_na_dzien * $n;
                    if ($zmiana->id == $dzielnik)
                    {
                        array_push($zmiana->pracownicy, [$pracownik->imie, $pracownik->nazwisko, $pracownik->godziny_zmiana]);
                        $pracownik->godziny_tydzien = $pracownik->godziny_tydzien - $pracownik->godziny_zmiana;
                    }
                    $n++;
                    if ($dzielnik > $zmiana->id)
                    {
                        break;
                    }
                }
            }
        }
    }
    echo '<pre>';
    print_r($zmiany);
    echo '</pre>';    
}

class zmiana
{
    public int $id;
    public array $pracownicy;

    public function __construct(int $id, array $pracownicy)
    {
        $this->id = $id;
        $this->pracownicy = $pracownicy;
    }
}

class pracownik
{
    public string $imie;
    public string $nazwisko;
    public int $godziny_tydzien;
    public int $godziny_zmiana;
    public int $zmiana;

    public function __construct(string $imie, string $nazwisko, int $godziny_tydzien, int $godziny_zmiana, int $zmiana)
    {
        $this->imie = $imie;
        $this->nazwisko = $nazwisko;
        $this->godziny_tydzien = $godziny_tydzien;
        $this->godziny_zmiana = $godziny_zmiana;
        $this->zmiana = $zmiana;
    }
}

start();
?>