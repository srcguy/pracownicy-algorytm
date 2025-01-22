def start():
    pracownicy = [] #lista pracownikow
    zmiany = [] #lista zmiany
    zmianya = int(input("podaj ilosc zmian na dzien"))
    for i in range(1, zmianya * 8): #żeby symulacja było prostsza, bierzemy pod uwagę tydzień a nie miesiac
        zmiany.append(zmiana(i, [])) #wypelniam liste zmiany obiektami o klasie zmiana
    dodaj_pracownika(pracownicy, zmiany, zmianya)

class pracownik: #klasa pracownik a w niej imie, nazwisko, godziny tygodniowo i dziennie
    def __init__(self, imie, nazwisko, godziny_tydzien, godziny_zmiana, zmiana):
        self.imie = imie
        self.nazwisko = nazwisko
        self.godziny_tydzien = godziny_tydzien
        self.godziny_zmiana = godziny_zmiana
        self.zmiana = zmiana
    def __repr__(self): #tutaj definiuje co zwróci klasa kiedy ją się wywoła
        return f"{self.imie} {self.nazwisko} {self.godziny_tydzien} {self.godziny_zmiana} {self.zmiana}"

class zmiana: #klasa zmiana a w niej id i pracownicy ktorzy beda pracowac w tym dniu
    def __init__(self, id, pracownicy):
        self.id = id
        self.pracownicy = pracownicy
    def __repr__(self):
        return f"{self.id} {self.pracownicy}"
    
def alg(pracownicy, zmiany, ilosc_zmian):
    for pracownik in pracownicy:
        for x in zmiany:
            if pracownik.godziny_tydzien > 0:
                n = 0
                while True: 
                    dzielnik = pracownik.zmiana + ilosc_zmian * n
                    if x.id == dzielnik:
                        x.pracownicy.append([pracownik.imie, pracownik.godziny_zmiana]) #dodaje do listy pracownikow liste z imieniem pracownika i godzinami do przepracowania w dniu
                        #zmiany[x.id - 1] = zmiana(x.id, x.pracownicy) #do okreslonego przez numer iteracji elementu listy dodaje obiekt o klasie zmiana z tym samym id ale ze zmodyfikowaną listą
                        pracownik.godziny_tydzien -= pracownik.godziny_zmiana
                    n += 1
                    if dzielnik > x.id:
                        break

    result(zmiany)

def result(zmiany):
    print(zmiany) #printuje wynik

def dodaj_pracownika(pracownicy, zmiany, ilosc_zmian):
    while True:
        imie = input("imie:")
        if imie == "/q": #dla prostoty. mozna dodac zapytanie na koniec czy dodac nowego pracownika or smth
            break
        nazwisko = input("nazwisko:")
        godziny = int(input("godziny tygodniowo (pelen etat=40 g tyg):"))
        godziny_zmiana = int(input("godziny na zmiane:"))
        zmiana_ktora = int(input("na ktorą zmiane:"))
        pracownicy.append(pracownik(imie, nazwisko, godziny, godziny_zmiana, zmiana_ktora)) #do listy pracownicy dodaje obiekt o klasie pracownik o podanych parametrach
        #print(pracownicy)
        #pominąłem sprawdzanie czy pracownik juz istnieje ale mozna potem dodac
        #pominąłem mozliwosc wprowadzenia wielu zmian ale to mozna potem dodac
    alg(pracownicy, zmiany, ilosc_zmian)

start()
