using System;
using System.Xml.XPath;

namespace algorytm
{
    internal class Program
    {

        public class Pracownik
        {
            public string Imie { get; set; }
            public string Nazwisko { get; set; }
            public int Godziny_tydzien { get; set; }
            public int Godziny_zmiana { get; set; }
            public int Zmiana { get; set; }

        public Pracownik(string imie, string nazwisko, int godziny_tydzien, int godziny_zmiana, int zmiana )
        {
            Imie = imie;
            Nazwisko = nazwisko;
            Godziny_tydzien = godziny_tydzien;
            Godziny_zmiana = godziny_zmiana;
            Zmiana = zmiana;
        }
        }   

        public class Zmiana
        {
            public int Id { get; set; }
            public List<Pracownik> Pracownicy { get; set; }

        public Zmiana(int id, List<Pracownik> pracownicy )
        {
            Id = id;
            Pracownicy = pracownicy;
        }

        }  
        static void Main()
        {
            List<Pracownik> pracownicy = new List<Pracownik>();
            List<Zmiana> zmiany = new List<Zmiana>();
            Console.Write("ile zmian na dzien?:");
            int zmianya = Int32.Parse(Console.ReadLine());
            for (int i = 1; i < zmianya * 8; i++)
            {
                zmiany.Add(new Zmiana(i, new List<Pracownik>()));
            }
            Dodaj_pracownika(pracownicy, zmiany, zmianya);
        }

        static void Dodaj_pracownika(List<Pracownik> pracownicy, List<Zmiana> zmiany, int ilosc_zmian)
        {
            while (true)
            {
                Console.Write("imie:");
                string imie = Console.ReadLine();
                if (imie == "/q")
                {
                    break;
                }
                Console.Write("nazwisko:");
                string nazwisko = Console.ReadLine();
                Console.Write("godziny tygodniowo(pelen etat=40g):");
                int godziny_tydzien = Int32.Parse(Console.ReadLine());
                Console.Write("godziny na zmiane:");
                int godziny_zmiana = Int32.Parse(Console.ReadLine());
                Console.Write("na ktora zmiane:");
                int zmiana = Int32.Parse(Console.ReadLine());
                pracownicy.Add(new Pracownik(imie, nazwisko, godziny_tydzien, godziny_zmiana, zmiana));
            }
            Alg(pracownicy, zmiany, ilosc_zmian);
        }

        static void Alg(List<Pracownik> pracownicy, List<Zmiana> zmiany, int ilosc_zmian)
        {
            foreach (Pracownik pracownik in pracownicy)
            {
                foreach (Zmiana zmiana in zmiany)
                {
                    if (pracownik.Godziny_tydzien > 0)
                    {
                        int n = 0;
                        while (true)
                        {
                            int dzielnik = pracownik.Zmiana + ilosc_zmian * n;
                            if (zmiana.Id == dzielnik)
                            {
                                zmiana.Pracownicy.Add(new Pracownik(pracownik.Imie, pracownik.Nazwisko, pracownik.Godziny_tydzien, pracownik.Godziny_zmiana, pracownik.Zmiana));
                                pracownik.Godziny_tydzien -= pracownik.Godziny_zmiana;
                            }
                            n += 1;
                            if (dzielnik > zmiana.Id)
                            {
                                break;
                            }
                        }
                    }
                }
            }
            Result(zmiany);
        }

        static void Result(List<Zmiana> zmiany)
        {
            foreach (Zmiana zmiana in zmiany)
        {
            Console.WriteLine($"id: {zmiana.Id}");
            Console.WriteLine("pracownicy na zmianie:");

            foreach (Pracownik pracownik in zmiana.Pracownicy)
            {
                Console.WriteLine($"  - {pracownik.Imie} {pracownik.Nazwisko} {pracownik.Godziny_zmiana}");
            }

            Console.WriteLine(); 
        }
        }
    }
}