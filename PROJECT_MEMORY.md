# KARIBU-SOFTWARE — Memoire du Projet

## Date de creation : 2026-09-08
## Agent : Lumen (opencode)
## Projet : Karibu Technologies — Suite SaaS

---

## Resume du projet

Karibu Technologies est un groupe technologique fonde par BRYCE, base a Abidjan, Cote d'Ivoire. La societe developpe une suite logicielle SaaS destinee aux entreprises ouest-africaines.

### Produits
1. **Karibu Paie** — Logiciel de paie conforme aux normes ivoiriennes (CNPS, ITS, CMU) — Phase 1
2. **Karibu Scolaire** — Gestion scolaire complete — Phase 2
3. **Karibu VTC** — Mise en relation clients/chauffeurs — En dev par equipe separee (D:\KARIBU)

### Stack technique
- **Backend** : Laravel 13 (PHP 8.4 FPM Alpine)
- **Frontend** : Blade + Tailwind CSS CDN + Alpine.js
- **Base de donnees** : MySQL 8.0
- **Cache** : Redis
- **Conteneurs** : Docker Compose (6 services)
- **VPS** : Contabo Cloud VPS Plus 6 (6 CPU, 12GB RAM, 300GB, IP 169.58.220.27)

### Architecture
- **Clean Architecture / Hexagonal** : `src/Features/{Auth,Tenancy,Common}/`
- **Multi-tenancy** : Shared Database + tenant_id (row-level tenancy)
- **Roles SaaS** : super_admin, tenant_owner, tenant_admin, tenant_manager, tenant_user
- **Plans** : trial (14j, 5 emp), essentiel (20K/mo, 15 emp), professionnel (35K/mo, 50 emp), enterprise (sur mesure)
- **Namespace** : `Src\` → `src/` (PSR-4 autoload)

---

## Architecture Clean / Hexagonal

### Regles 13 (valides par BRYCE)
1. Organisation feature-first (Auth, Tenancy, Common)
2. Domain = PHP pur (pas de Laravel)
3. Controllers = thin (validation + DTO + Use Case)
4. Pas de Eloquent dans les vues
5. ViewModels/DTOs exposent les donnees
6. Interfaces/Ports pour deps externes
7. Design system reutilisable (tokens/components)
8. API stable versionnee (/api/v1/)
9. Chaque feature commence par : arbre, responsabilites, contrats, plan de tests
10. Expliquer les compromis framework avant modification
11. Securite prioritaire
12. Pas de regression
13. Modularite complete (aucun fix ne casse un module)

### Structure par feature
```
src/Features/{FeatureName}/
├── Domain/
│   ├── Contracts/        # Interfaces (ports)
│   ├── Entities/         # Entites metier
│   ├── ValueObjects/     # Valeurs原子iques
│   ├── Rules/            # Regles metier pures
│   └── Events/           # Evenements domaine
├── Application/
│   ├── DTOs/             # Data Transfer Objects
│   └── Actions/          # Use Cases
├── Infrastructure/
│   └── Persistence/      # Implementations Eloquent
└── Presentation/
    ├── Http/             # Controllers (thin)
    ├── Requests/         # FormRequests (validation)
    └── ViewModels/       # ViewModels (donnees vues)
```

### Features existantes
- **Auth** : Login, Register, Logout, ForgotPassword, ResetPassword
- **Common** : Email (VO), Money (VO), IsActiveUser (Rule), UserRepositoryInterface (Contract)

---

## Etat d'avancement — Session 2 (2026-09-09)

### Fichiers crees/modifies (Session 1 + 2)
- `docker-compose.yml` — 6 services: app, nginx, mysql, redis, queue, scheduler
- `Dockerfile` — PHP 8.4 FPM Alpine
- `docker/nginx/default.conf` — Config Nginx dev
- `app/Enums/Role.php` — 5 roles SaaS
- `app/Enums/TenantPlan.php` — 4 plans
- `app/Models/Tenant.php` — Modele tenant
- `app/Models/User.php` — Modele user (sans HasApiTokens — Sanctum pas installe)
- `app/Traits/BelongsToTenant.php` — Scope tenant
- `app/Http/Middleware/TenantMiddleware.php` — Abort 401 (pas global)
- `app/Http/Middleware/EnsureUserHasRole.php` — Middleware roles
- `app/Providers/AppServiceProvider.php` — DI: UserRepositoryInterface → EloquentUserRepository
- `app/Http/Controllers/LandingController.php`
- `app/Http/Controllers/Tenant/DashboardController.php`
- `src/Features/Auth/` — Feature complete (27 fichiers)
- `src/Features/Common/` — Value Objects + Rule (3 fichiers)
- `resources/views/auth/` — 4 vues (login, register, forgot-password, reset-password)
- `resources/views/components/ui/` — 5 composants (button, input, card, alert, badge)
- `resources/views/components/layouts/` — 2 layouts (guest, app)
- `resources/views/landing.blade.php` — Landing page PWA (536 lignes)
- `resources/views/tenant/dashboard.blade.php`
- `database/migrations/` — 4 migrations (tenants, users, cache, jobs)
- `database/seeders/SuperAdminSeeder.php` — admin@karibu.tech / Admin@2026!
- `database/baremes/cnps_2026.json` — Taux CNPS
- `database/baremes/its_2026.json` — Barème ITS
- `routes/web.php` — Landing + Auth + Dashboard
- `tests/` — 9 fichiers (3 Feature Auth + 3 Unit + 2 Example + TestCase)

### Tests
- **36 tests, 60 assertions — TOUS PASSENT**
- Unit: EmailTest (7), MoneyTest (10), IsActiveUserTest (4), ExampleTest (1)
- Feature: LoginTest (4), RegisterTest (4), LogoutTest (1), ExampleTest (1)

### Bugs corriges (Session 2)
1. `HasApiTokens` (Sanctum) non installe → trait retire temporairement
2. `view()` recevait un objet ViewModel au lieu d'un array → ViewModels implementent `Arrayable`
3. `:disabled="loading"` → constante PHP, pas variable Alpine → supprimé
4. `UserDTO.tenant_id` inexistant → fallback Eloquent supprimé dans redirectAfterLogin

### Etat Docker local
| Service | Container | Port |
|---------|-----------|------|
| app | karibu-app | — |
| nginx | karibu-nginx | 8081→80 |
| mysql | karibu-mysql | 3307→3306 |
| redis | karibu-redis | 6380→6379 |
| queue | karibu-queue | — |
| scheduler | karibu-scheduler | — |

---

## VPS Contabo — Etat

| Element | Detail |
|---------|--------|
| IP | 169.58.220.27 |
| OS | Ubuntu 24.04.4 LTS |
| RAM | 12GB |
| Disk | 300GB (276GB dispo) |
| PHP | 8.3.6 (host) |
| Docker | v29.x + Compose v5.5.0 |
| Nginx | Serveur proxy + VTC (karibu.co.ci) |
| Cockpit | Port 9091 (admin VPS) |
| SSH | Key: `C:\Users\WEBDEV\.ssh\id_ed25519_karibu` |
| Login SSH | root / Genetycs@%0703! |
| Login Cockpit | karibuadmin / NouveauMdp2026! |

### Services VPS actifs
- Nginx (80, 443, 83, 84, 483, 8000, 8001, 8080, 8443, 8888)
- PostgreSQL (5432)
- Redis (6379)
- Docker: karibu-backend, karibu-nginx, karibu-postgres, karibu-redis, karibu-reverb, karibu-minio, karibu-mailpit (VTC)
- Monitoring: Grafana (3000), Prometheus (9090), Uptime Kuma (3001), Loki (3100)
- Mail: Postfix + Dovecot + LDAP (slapd)
- Cockpit (9091)

### SSL (Let's Encrypt)
- `karibu.co.ci` + `www.karibu.co.ci` — expire 2026-11-21
- `klnk.karibu.co.ci` — expire 2026-12-06
- **tech.karibu.co.ci** — DNS OK (A record → 169.58.220.27), cert a creer

### Nginx VPS
- `/etc/nginx/sites-available/karibu` → karibu.co.ci (VTC)
- `/etc/nginx/sites-available/default` — default server

---

## Routes actuelles

| Method | Path | Name | Middleware |
|--------|------|------|------------|
| GET | / | landing | — |
| GET | /login | login | guest |
| POST | /login | — | guest |
| GET | /register | register | guest |
| POST | /register | — | guest |
| GET | /forgot-password | password.request | guest |
| POST | /forgot-password | password.email | guest |
| GET | /reset-password/{token} | password.reset | guest |
| POST | /reset-password | password.update | guest |
| POST | /logout | logout | auth |
| GET | /dashboard | dashboard | auth+tenant |
| GET | /{slug}/dashboard | tenant.dashboard | auth+tenant |

### Routes a deplacer (Etape 2)
Auth → /orion/* (paths caches, names identiques)

---

## Conventions

- **Tables** prefixees : `crm_` / `compta_` / `rh_` (Karibu Paie: `karibu_`)
- **Monetaire** : XOF (FCFA), integer jamais float
- **Langue** : Francais uniquement
- **Timezone** : Africa/Abidjan
- **Soft deletes** : sur tous les modeles
- **Variable interdite** : $sage (conflit Sage/Saari)
- **Login URL** : /orion/login (apres Etape 2)
- **Session timeout** : 7200s (2h)

---

## Decisions importantes

| Decision | Raison |
|----------|--------|
| Architecture Shared DB + tenant_id | Simple, pas cher, suffisant pour 200 clients |
| Redis des le jour 1 | Cache + queue + sessions, $0 de surcout |
| Laravel 13 | Derniere version, support jusqu'en 2028 |
| PHP 8.4 | Requis par composer.json ^8.4 |
| Clean Architecture / Hexagonal | Domain PHP pur, testable, maintenable |
| Routes auth dans /orion/ | Seguridad — paths non devinables |
| ViewModels implementent Arrayable | Compatibilite avec view() Laravel |
| TenantMiddleware → abort 401 | Pas de redirect, compatible API |
| Pas de Sanctum pour l'instant | API Flutter phase ulterieure |

---

## Securite

- Pas de secrets dans le code
- .env.production.example (gitignore le vrai .env)
- BelongsToTenant scope sur tous les modeles
- Roles avec hierarchie
- Routes auth dans /orion/ (pas /login)
- root bloque dans Cockpit disallowed-users

---

## Prochaines etapes

| # | Tache | Statut |
|---|-------|--------|
| 1 | Deploy landing tech.karibu.co.ci | FAIT |
| 2 | Routes Auth → /orion/ | FAIT |
| 3 | Config Nginx + SSL sur VPS | FAIT |
| 4 | Tests Phase 1 (36 tests / 60 assertions) | FAIT |
| 5 | Systeme abonnements (plans, checkout, admin) | FAIT |
| 6 | Page /tarifs + /checkout + /demo | FAIT |
| 7 | Middleware VerifySubscription | FAIT |
| 8 | Command cron subscriptions:check | FAIT |
| 9 | Module Paie (CNPS + ITS) | A FAIRE |
| 10 | API Flutter (Sanctum) | A FAIRE |
| 11 | Mobile Money / Stripe | A FAIRE |
| 12 | CI/CD GitHub Actions | A FAIRE |

---

## Memoires de sessions

### Session 1 — 2026-09-08
- Laravel 13 initialise
- Docker Compose configure
- Multi-tenancy: Tenant + User + Enums
- Landing page PWA

### Session 2 — 2026-09-09
- Architecture Clean / Hexagonal implementee
- Feature Auth complete (27 fichiers)
- Feature Common: Email VO, Money VO, IsActiveUser Rule
- Design system (5 composants Blade)
- 36 tests / 60 assertions — tous passent
- Bugs fixes (HasApiTokens, ViewModel Arrayable, redirectAfterLogin)
- VPS Contabo configure (Cockpit, Docker, Nginx)
- DNS tech.karibu.co.ci resolu → 169.58.220.27
- Landing page live + login redesign (glassmorphism, anti-inspection)
- PWA complet (manifest.json, Service Worker, icons, SW registration)

### Session 3 — 2026-09-10
- Systeme d'abonnements complet :
  - Tables: plans, subscriptions, payments, subscription_fields on tenants
  - Modeles: Plan, Subscription, Payment (Eloquent)
  - Controllers: PricingController, CheckoutController, AdminPlanController, AdminTenantController, DemoController
  - Vues: /tarifs, /checkout, /demo, /demo/merci, /subscription/expired, /subscription/blocked, admin/plans/*, admin/tenants/*
  - Routes: 14 nouvelles routes web
  - Middleware: VerifySubscription (protege dashboard)
  - Command: subscriptions:check (cron quotidien 2h)
  - PlanSeeder: 4 plans par defaut (Essentiel 20K, Pro 35K, Enterprise, Trial 15j/5 emp)
- Bug fix: SoftDeletes manquant sur subscriptions (nouvelle migration)
- Deploy complet VPS + verification (toutes les pages 200 OK)
- 36 tests / 60 assertions — tous passent
- Cron job: `0 2 * * *` pour subscriptions:check
- Menu tarifs → liens vers /tarifs + /demo
- Fix accent "prioritaire" sur landing page

### Session 4 — 2026-09-10 (CMS)
- **Module CMS complet** — tout le site web est maintenant gérable depuis le backend :
  - Tables: `cms_pages`, `cms_sections`, `cms_settings`, `cms_navigations`, `cms_media`, `cms_form_submissions`
  - 6 modèles Eloquent: CmsPage, CmsSection, CmsSetting, CmsNavigation, CmsMedia, CmsFormSubmission
  - Architecture Clean/Hexagonal: Domain (4 contrats, 2 VO), Infrastructure (4 repositories), Application (4 actions)
  - 6 controllers admin (Dashboard, Pages, Settings, Navigation, Media, Forms)
  - 2 controllers publics (CmsPageController, CmsFormController)
  - 10 types de sections: hero, features, pricing, testimonials, cta, text, contact, faq, gallery, html
  - 20 routes admin CMS (/orion/admin/cms/*)
  - CmsSeeder: pages par défaut avec sections pré-remplies (landing, pricing, demo, contact)
  - Settings: site_name, site_slogan, contact_email, social links, colors
  - Navigation: menus header/footer/mobile éditables
  - Formulaires: contact + démo → soumissions stockées en DB
  - Cache Redis: pages (5min), settings (30min), navigation (1h)
  - Fallback: si tables CMS absentes → ancienne vue Blade statique
- Fix: route catch-all `/{slug}` déplacée APRÈS les routes spécifiques
- Fix: stale Redis cache (CmsPage incomplet)
- 36 tests / 60 assertions — tous passent
- Deploy complet VPS
