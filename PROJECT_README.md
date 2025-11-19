# Sistem Informasi Manajemen Magang (SIMMA)

A minimal viable product for managing internship workflows: posting company internship openings, student applications, logbook submissions, mentor/mitra validation, grading, and printable certificates.

## Key Features

- Authentication (register/login/email verification)
- Role Management (admin, mitra, mahasiswa, dosen)
- Lowongan Moderation (admin approves/rejects company job postings)
- Aplikasi Flow (students apply to jobs with CV upload)
- Logbook (students submit daily activity logs; mitra/dosen validate)
- Penilaian (mentors/mitra provide final grades)
- Sertifikat (printable certificate for completed internships)

## Installation Guide

1. Install PHP dependencies:

```bash
composer install
```

2. Install JS dependencies and compile assets:

```bash
npm install && npm run dev
```

3. Copy environment example and set values (DB connection etc):

```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations and seed demo data (this will reset the database):

```bash
php artisan migrate:fresh --seed
```

> The `--seed` step populates the application with demo data (admin, several mitra, and 20 mahasiswa) so the UI is ready for exploration.

## Demo Credentials

Use these credentials to quickly log in to the seeded demo environment:

- Admin: `admin@test.com`
- Mitra (example): `mitra2@test.com`  
- Mahasiswa (example): `mahasiswa7@test.com`
- Password (all seeded users): `password`

You can list all seeded accounts with the included helper script:

```bash
php scripts/dump_users.php
```

## Quick Notes

- Tests: the project includes a comprehensive Feature test suite. Run with `php artisan test`.
- Storage: uploaded CVs and photos are stored by default in the configured filesystem. For local testing use `Storage::fake()` in tests or set a local disk in `.env`.
- To change demo accounts, edit `database/seeders/DatabaseSeeder.php` and re-run `php artisan migrate:fresh --seed`.

---

Thank you — the MVP is ready for demo and exploration. If you want, I can add a short walkthrough page or seed additional realistic photos for students next.