def start():
    pracownicy = [] #lista pracownikow
    dni = [] #lista dni
    for i in range(1, 8): #żeby symulacja było prostsza, bierzemy pod uwagę tydzień a nie miesiac
        dni.append(dzien(i, [])) #wypelniam liste dni obiektami o klasie dzien
    dodaj_pracownika(pracownicy, dni)

class pracownik: #klasa pracownik a w niej imie, nazwisko, godziny tygodniowo i dziennie
    def __init__(self, imie, nazwisko, godziny_tydzien, godziny_dzien):
        self.imie = imie
        self.nazwisko = nazwisko
        self.godziny_tydzien = godziny_tydzien
        self.godziny_dzien = godziny_dzien
    def __repr__(self): #tutaj definiuje co zwróci klasa kiedy ją się wywoła
        return f"{self.imie} {self.nazwisko} {self.godziny_tydzien} {self.godziny_dzien}"

class dzien: #klasa dzien a w niej id i pracownicy ktorzy beda pracowac w tym dniu
    def __init__(self, id, pracownicy):
        self.id = id
        self.pracownicy = pracownicy
    def __repr__(self):
        return f"{self.id} {self.pracownicy}"
    
def alg(pracownicy, dni):
    for pracownik in pracownicy:
        for x in dni:
            if pracownik.godziny_tydzien > 0:
                x.pracownicy.append([pracownik.imie, pracownik.godziny_dzien]) #dodaje do listy pracownikow liste z imieniem pracownika i godzinami do przepracowania w dniu
                dni[x.id - 1] = dzien(x.id, x.pracownicy) #do okreslonego przez numer iteracji elementu listy dodaje obiekt o klasie dzien z tym samym id ale ze zmodyfikowaną listą
                pracownik.godziny_tydzien -= pracownik.godziny_dzien
    result(dni)

def result(dni):
    print(dni) #printuje wynik

def dodaj_pracownika(pracownicy, dni):
    while True:
        imie = input("imie:")
        if imie == "/q": #dla prostoty. mozna dodac zapytanie na koniec czy dodac nowego pracownika or smth
            break
        nazwisko = input("nazwisko:")
        godziny = int(input("godziny tygodniowo (pelen etat=40 g tyg):"))
        godziny_dzien = int(input("godziny dziennie (pelen etat=8 g dziennie):"))
        pracownicy.append(pracownik(imie, nazwisko, godziny, godziny_dzien)) #do listy pracownicy dodaje obiekt o klasie pracownik o podanych parametrach
        #print(pracownicy)
        #pominąłem sprawdzanie czy pracownik juz istnieje ale mozna potem dodac
        #pominąłem sprawdzenie czy godziny tygodniowo są podzielne przez godziny dziennie ale mozna potem dodac
    alg(pracownicy, dni)

start()