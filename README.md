# 📝 Custom CMS - Sistem za Upravljanje Blogom i Objavama

Ovo je namenski razvijen CMS (Content Management System) koji omogućava lako dodavanje, ažuriranje i filtriranje blog postova. Sistem je dizajniran da bude brz, bezbedan i jednostavan za korišćenje.

## 🚀 Funkcionalnosti (Features)

*   **Sistem Autentifikacije:** Sigurna prijava administratora uz zaštitu stranica pomoću PHP sesija.
*   **CRUD Operacije:** Kreiranje, čitanje i ažuriranje objava direktno iz kontrolnog panela.
*   **Napredno Filtriranje:** Dinamičko filtriranje objava po kategorijama ("Pill" navigacija) bez osvežavanja cele strukture.
*   **Sistem Tagova:** Dodeljivanje i prikazivanje višestrukih tagova za svaku objavu (npr. `#Webflow`, `#PHP`, `#Dizajn`).
*   **Bezbednost:** Zaštita od SQL Injection napada (korišćenjem PDO i *Prepared Statements*) i XSS napada (sanitizacija unosa).
*   **Moderni UI/UX:** Responzivni administrativni panel sa bočnim menijem (Sidebar) i čistim, preglednim formama i karticama.

## 🛠️ Korišćene Tehnologije

*   **Backend:** PHP 8+ (MVC arhitektura)
*   **Baza Podataka:** MySQL (PDO konekcija)
*   **Frontend:** HTML5, CSS3 (Custom Dashboard dizajn)

## 📁 Arhitektura Aplikacije

Sistem se oslanja na prilagođeni logički šablon:
*   `decisionMaker.php`: Glavni "skretničar" (Router) koji hvata sve `GET` i `POST` zahteve i prosleđuje ih Kontrolerima.
*   **Kontroleri (`PostsController.php`):** Obrađuju logiku, komuniciraju sa Modelima i upravljaju tokom podataka.
*   **Modeli (`Posts.php`):** Služe isključivo za komunikaciju sa bazom podataka (izvršavanje SQL upita).

