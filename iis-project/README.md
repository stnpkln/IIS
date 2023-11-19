# IIS projekt "Sociální síť"

# Users

-   id: number
-   username: string (max 50) not null
-   password: string (max 255) not null
-   email: string (max 255) not null
-   first_name: string (max 50) not null
-   last_name: string (max 50) not null
-   description: string (max 500)
-   visibility: enum (all, registered, hidden) not null
-   is_admin: bool not null

## viditelnost

### Viditelnost profilu

týká se detailu uživatele
uživatel si může nastavit viditelnost:

-   viditelný pro všechny
-   viditelný pro registrované
-   neviditelný

týká se toho, zda lze vidět že je uživatel členem skupiny
skupina může mít nastavené:

-   Všichni vidí členy skupiny
-   členy skupiny vidí jen registrovaní
-   členy skupiny vidí jen jiní členové skupiny
