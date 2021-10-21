# M151
## Aufsetzen der DB
1. Datenbank "projektarbeit" erstellen
2. Tabellen aus dem [Projektarbeit.sql](DB/projektarbeit.sql) importieren
3. Benutzer mit folgenden Brechtigungen erstellen: 
   * Select
   * Insert
   * Update 
   * Delete

## Aufsetzen Apache
### Möglichkeit 1 
1. Inhalt des Code Ordners nach htdocs kopieren 
2. Apache starten

### Möglichkeit 2
1. Apache Config (httpd.conf) anpassen
   1. DocumentRoot finden 
   2. Den Pfad für den Code Ordener angeben (z.B. "C:/Users/m-obe/IdeaProjects/M151/Code")
2. Apache starten
