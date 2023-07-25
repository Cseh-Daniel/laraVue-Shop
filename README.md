# Terméklista és kosár feladat
Alapértelmezett felhasználó:
- default@user.com
- password

képek a termékekhez:
public/uploads/prod/

Funkciók:

    felhasználók:
        -regisztráció
        -bejelentkezés
    
    Termékek:
        -Paginált listázás
        -Létrehozás (bejelentkezett felhasználó)
        -Módosítás (bejelentkezett felhasználó)
        -Törlés (bejelentkezett felhasználó)
            Törlésnél modal kérdés (biztosan törli?)
            Termék törlésekor az a kosarakból is törlődik
        -Kosárhoz adás mennyiséggel
        -Keresés és szűrés:
            Szűrhetünk névre és árközre, külön-külön vagy egyszerre és sorba is rendezhetjük név/ár alapján
            Sorba rendezés szűrés nélkül is lehetséges

    Kosár:
        -Bejelentkezett és vendég felhasználóknak is van kosár
        -A kosárba felvett termékek mennyisége módosítható
        -Kosárból termék eltávolítható
        -Ha vendég felhasználóként teszünk terméket a kosárba,
         majd bejelentkezünk, a kosár tartalma átíródik a bejelentkezett felhasználóhoz
        -Ha van már a felhasználó kosarában termék és van kosara vendégként is megkérdezi melyik maradjon




