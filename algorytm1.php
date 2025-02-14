<?php

function start()
{
    $pracownicy = [];
    $zmiany = [];
    $zmiany_na_dzien = 2;

    $i = 1;

    for($i = 1; $i < $zmiany_na_dzien * 7 + 1; $i++)
    {
        array_push($zmiany, new zmiana($i, []));
    }

    dodaj_pracownika($pracownicy, $zmiany, $zmiany_na_dzien);
}

function dodaj_pracownika($pracownicy, $zmiany, $zmiany_na_dzien)
{
    array_push($pracownicy, new pracownik("janek", "dzbanek", 40, 8, 1));
    array_push($pracownicy, new pracownik("marta", "łyszka", 40, 8, 2));
    algorytm($pracownicy, $zmiany, $zmiany_na_dzien);
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