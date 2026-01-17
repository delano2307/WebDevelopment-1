# Fitness Tracker – Web Development 1

## URL
Wanneer je naar 'localhost' gaat in je browser, zal je automatisch op de inlogpagina komen.

---

## Logingegevens

### Admin
- E-mail: admin@admin.nl  
- Wachtwoord: admintest 

### Gebruiker
- E-mail: gymbro@gmail.com
- Wachtwoord: gymbro1234 

- Gebruikers kunnen zelf een account registreren via de applicatie.

---

## ▶Applicatie starten

### Benodigd
- Visual studio code (of een andere code editor)
- Docker

### Installatie
1. Download of unzip het project
2. Open het project in code editor
3. Open docker
4. Voer de command 'docker compose up' uit in je terminal (ervanuit gaande dat je vscode gebruikt)
5. Ga naar 'localhost' in je browser


---

## Functionaliteit (overzicht)
- Registreren, inloggen en uitloggen
- Workouts en sets loggen (reps en gewicht)
- Progressie per oefening bekijken
- Admin kan oefeningen beheren

---

## Architectuur
- Gebouwd in PHP volgens het MVC-design pattern
- Gebruik van meerdere gerelateerde database-tabellen
- Authenticatie en autorisatie via sessions
- CRUD-functionaliteit voor kern-entiteiten

---

## API & JavaScript
- JSON API endpoint voor progressiedata
- JavaScript (`fetch`) wordt gebruikt om data dynamisch te laden zonder pagina refresh

---

## Security
- PDO prepared statements tegen SQL-injectie
- Output escaping tegen XSS
- Wachtwoorden worden gehasht opgeslagen
- Routes zijn beschermd met authenticatie en rollen

---

## Legal & Accessibility
- Basis WCAG-richtlijnen toegepast (labels, contrast)
- Persoonsgegevens worden alleen gebruikt voor de functionaliteit van de applicatie

