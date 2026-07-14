# Vue 3 + TypeScript + Vite

This template should help get you started developing with Vue 3 and TypeScript in Vite. The template uses Vue 3 `<script setup>` SFCs, check out the [script setup docs](https://v3.vuejs.org/api/sfc-script-setup.html#sfc-script-setup) to learn more.

Learn more about the recommended Project Setup and IDE Support in the [Vue Docs TypeScript Guide](https://vuejs.org/guide/typescript/overview.html#project-setup).

# Klantenhulpportaal

Een webapplicatie waarmee klanten hulpvragen (tickets) kunnen aanmaken en beheren.
Administrators kunnen tickets bekijken, status aanpassen, prioriteiten wijzigen,
gebruikers beheren en interne notities plaatsen.

---

## Functionaliteiten

### Gebruikers

- Registreren
- Inloggen
- Tickets aanmaken
- Eigen tickets bekijken
- Reacties plaatsen
- Ticketstatus volgen


### Administrators

- Dashboard met statistieken
- Alle tickets bekijken
- Ticketstatus aanpassen
- Prioriteit wijzigen
- Tickets toewijzen aan admins
- Categorieën beheren
- Gebruikers beheren
- Interne notities plaatsen


---

## Gebruikte technieken

### Frontend

- Vue 3
- TypeScript
- Vite
- Pinia
- Vue Router
- Bootstrap 5
- Bootstrap Icons


### Backend

- Laravel
- Laravel Sanctum
- REST API
- MySQL


---

# Installatie


## Backend

Ga naar de backend map:

```bash
cd backend

Installeer dependencies:

composer install

Maak een .env bestand:

cp .env.example .env

Genereer Laravel key:

php artisan key:generate

Database migraties uitvoeren:

php artisan migrate

Start Laravel:

php artisan serve
Frontend

Ga naar de frontend map:

cd frontend

Installeer packages:

npm install

Start Vue:

npm run dev
Database

Het project gebruikt MySQL.

Voorbeeld .env:

DB_DATABASE=klantenhulpportaal
DB_USERNAME=root
DB_PASSWORD=
Inloggen
Administrator

Email:

admin@test.nl

Wachtwoord: nieuwwachtwoord123

password
Gebruiker

Email:

user@test.nl

Wachtwoord:12345678

password
Rollen

Het systeem kent twee rollen:

Rol	Mogelijkheden
User	Tickets maken en reacties plaatsen
Admin	Beheeromgeving en ticketbeheer
Projectstructuur
Klantenhulpportaal

├── frontend
│   ├── src
│   │   ├── views
│   │   ├── components
│   │   ├── stores
│   │   └── api
│
└── backend
    ├── app
    ├── routes
    ├── database
    └── controllers
Auteur

Jelmer van der Meer


---


