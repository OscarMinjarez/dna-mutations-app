![Ask DeepWiki](https://deepwiki.com/badge.svg)


# DNA Mutations App

A full-stack web application for DNA mutation analysis, featuring a Laravel (PHP) backend and an Angular frontend.

---

## Project Overview

**DNA Mutations App** is designed to analyze, store, and visualize DNA sequence mutations. The application provides a robust backend API for processing and managing DNA data, and a modern frontend for user interaction and visualization.

### Key Features

- **DNA Sequence Analysis:** Submit DNA sequences and receive mutation analysis results.
- **Data Storage:** Utilizes MongoDB for flexible and scalable storage of genetic data.
- **RESTful API:** Backend exposes endpoints for sequence submission, mutation queries, and user management.
- **Modern UI:** Angular frontend for interactive data input, result visualization, and user experience.
- **Testing:** Comprehensive unit and integration tests for both backend and frontend.

### Architecture

- **Backend:** Laravel 12.x, PHP 8.2+, MongoDB, REST API, Sanctum authentication, Pest/PHPUnit for testing.
- **Frontend:** Angular 20.x, TypeScript, Tailwind CSS, Jasmine/Karma for testing.

This architecture allows for independent development and deployment of backend and frontend, supporting scalability and maintainability.

---

## Table of Contents

- [Project Structure](#project-structure)
- [Backend (Laravel)](#backend-laravel)
- [Frontend (Angular)](#frontend-angular)
- [Development](#development)
- [Testing](#testing)
- [License](#license)

---

## Project Structure

```text
dna-mutations-backend/   # Laravel API backend
dna-mutations-frontend/  # Angular frontend
```

---

## Backend (Laravel)

- **Framework:** Laravel 12.x
- **Language:** PHP 8.2+
- **Database:** MongoDB (via `mongodb/laravel-mongodb`)
- **API:** RESTful endpoints for DNA mutation analysis
- **Authentication:** Laravel Sanctum

### Setup

1. Install dependencies:
   ```bash
   cd dna-mutations-backend
   composer install
   npm install
   ```
2. Copy `.env.example` to `.env` and configure your environment variables.
3. Run migrations:
   ```bash
   php artisan migrate
   ```
4. Start the server:
   ```bash
   php artisan serve
   ```

### Scripts

- `composer test` — Run backend tests
- `npm run dev` — Start Vite for asset building

---

## Frontend (Angular)

- **Framework:** Angular 20.x
- **Language:** TypeScript
- **UI:** Tailwind CSS

### Setup

1. Install dependencies:
   ```bash
   cd dna-mutations-frontend
   ```
2. Start the development server:
   ```bash
   ng serve
   ```
   Visit [http://localhost:4200](http://localhost:4200).

### Scripts

- `npm start` — Start dev server
- `npm run build` — Build for production
---

## Development

- Backend and frontend can be developed and run independently.
- For full-stack development, run both servers concurrently.

---

## Testing

- **Backend:** Uses Pest and PHPUnit.
  ```bash
  cd dna-mutations-backend
  composer test
  ```

---

## License

- Backend: MIT (Laravel)
- Frontend: MIT