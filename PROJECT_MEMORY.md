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
- **Mobile** : Flutter/Dart (API Sanctum) — Phase 2
- **CI/CD** : GitHub Actions (deploy.yml) — Push to main → SSH VPS auto-deploy

### Architecture
- **Clean Architecture / Hexagonal** : `src/Features/{Auth,Tenancy,Cms,Common}/`
- **Multi-tenancy** : Shared Database + tenant_id (row-level tenancy)
- **Roles SaaS** : super_admin, tenant_owner, tenant_admin, tenant_manager, tenant_user
- **Plans** : trial (15j, 5 emp), essentiel (20K/mo, 15 emp), professionnel (35K/mo, 50 emp), enterprise (sur mesure)
- **Namespace** : `Src\` → `src/` (PSR-4 autoload)

---

## Architecture Clean / Hexagonal

### Regles 13 (valides par BRYCE)
1. Organisation feature-first (Auth, Tenancy, Common, Cms)
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
│   ├── ValueObjects/     # Valeurs atomiques
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
- **Auth** : Login, Register, Logout, ForgotPassword, ResetPassword (27 fichiers)
- **Common** : Email (VO), Money (VO), IsActiveUser (Rule), UserRepositoryInterface (Contract)
- **Cms** : 6 tables, 6 modeles, 4 contrats, 2 VO, 4 repositories, 4 actions

---

## VPS Contabo — Etat

| Element | Detail |
|---------|--------|
| IP | 169.58.220.27 |
| OS | Ubuntu 24.04.4 LTS |
| RAM | 12GB |
| Disk | 300GB (276GB dispo) |
| PHP | 8.4.x (Docker) |
| Docker | v29.x + Compose v5.5.0 |
| Nginx | Proxy + SSL + VTC (karibu.co.ci) |
| Cockpit | Port 9091 (admin VPS) |
| SSH | Port 22, Key: `C:\Users\WEBDEV\.ssh\id_ed25519_karibu` |
| Login SSH | root |
| Deploy Key | `/root/.ssh/deploy_key` (GitHub Actions) |

### Services VPS actifs
- Docker: karibu-app, karibu-nginx, karibu-mysql, karibu-redis
- Nginx (80, 443) + SSL Let's Encrypt
- Redis (6379), MySQL (3308→3306)

### SSL (Let's Encrypt)
- `karibu.co.ci` + `www.karibu.co.ci` — expire 2026-11-21
- `klnk.karibu.co.ci` — expire 2026-12-06
- **tech.karibu.co.ci** — SSL actif, deploye

---

## Routes actuelles

### Publiques
| Method | Path | Name |
|--------|------|------|
| GET | / | landing (CMS home) |
| GET | /tarifs | pricing |
| GET | /checkout | checkout.index |
| POST | /checkout | checkout.store |
| GET | /demo | demo.index |
| POST | /demo | demo.store |
| GET | /demo/merci | demo.success |
| POST | /form/{type} | cms.form.store |
| GET | /subscription/expired | subscription.expired |
| GET | /subscription/blocked | subscription.blocked |
| GET | /{slug} | cms.page (catch-all, APRÈS toutes les routes) |

### Auth (guest) — /orion/*
| Method | Path | Name |
|--------|------|------|
| GET | /orion/login | login |
| POST | /orion/login | — |
| GET | /orion/register | register |
| POST | /orion/register | — |
| GET | /orion/forgot-password | password.request |
| POST | /orion/forgot-password | password.email |
| GET | /orion/reset-password/{token} | password.reset |
| POST | /orion/reset-password | password.update |
| POST | /orion/logout | logout |

### Auth (authenticated)
| Method | Path | Name |
|--------|------|------|
| GET | /dashboard | dashboard |
| GET | /{slug}/dashboard | tenant.dashboard |

### Admin (super_admin) — /orion/admin/*
| Method | Path | Name |
|--------|------|------|
| GET | /orion/admin/plans | plans.index |
| GET | /orion/admin/plans/{plan}/edit | plans.edit |
| PUT | /orion/admin/plans/{plan} | plans.update |
| POST | /orion/admin/plans/{plan}/toggle | plans.toggle |
| GET | /orion/admin/tenants | tenants.index |
| GET | /orion/admin/tenants/{tenant} | tenants.show |
| PATCH | /orion/admin/tenants/{tenant}/status | tenants.status |
| POST | /orion/admin/tenants/{tenant}/payment | tenants.payment |
| GET | /orion/admin/cms | cms.dashboard |
| GET | /orion/admin/cms/pages | cms.pages.index |
| POST | /orion/admin/cms/pages | cms.pages.store |
| GET | /orion/admin/cms/pages/{page} | cms.pages.show |
| PUT | /orion/admin/cms/pages/{page} | cms.pages.update |
| DELETE | /orion/admin/cms/pages/{page} | cms.pages.destroy |
| POST | /orion/admin/cms/pages/{page}/sections | cms.pages.sections.store |
| PUT | /orion/admin/cms/pages/{page}/sections/{section} | cms.pages.sections.update |
| DELETE | /orion/admin/cms/pages/{page}/sections/{section} | cms.pages.sections.destroy |
| GET | /orion/admin/cms/settings | cms.settings.index |
| PUT | /orion/admin/cms/settings | cms.settings.update |
| GET | /orion/admin/cms/navigation | cms.navigation.index |
| PUT | /orion/admin/cms/navigation | cms.navigation.update |
| GET | /orion/admin/cms/media | cms.media.index |
| POST | /orion/admin/cms/media | cms.media.store |
| DELETE | /orion/admin/cms/media/{media} | cms.media.destroy |
| GET | /orion/admin/cms/forms | cms.forms.index |
| GET | /orion/admin/cms/forms/{submission} | cms.forms.show |
| PATCH | /orion/admin/cms/forms/{submission}/read | cms.forms.read |
| DELETE | /orion/admin/cms/forms/{submission} | cms.forms.destroy |

---

## Conventions

- **Tables** prefixees : `crm_` / `compta_` / `rh_` (Karibu Paie: `karibu_`, CMS: `cms_`)
- **Monetaire** : XOF (FCFA), integer jamais float
- **Langue** : Francais uniquement
- **Timezone** : Africa/Abidjan
- **Soft deletes** : sur tous les modeles
- **Login URL** : /orion/login
- **Session timeout** : 7200s (2h)
- **Cache Redis** : pages CMS (5min), settings (30min), navigation (1h)

---

## Securite

- Pas de secrets dans le code
- .env.production.example (gitignore le vrai .env)
- BelongsToTenant scope sur tous les modeles
- Roles avec hierarchie
- Routes auth dans /orion/ (paths non devinables)
- PreventBrowserCache middleware (no-store sur pages auth)
- Service Worker ne cache PAS les pages /orion/* et /dashboard
- Meta Cache-Control no-cache dans le head admin
- Anti-inspection login (right-click, F12, DevTools desactives)
- Deploy key SSH pour GitHub Actions

---

## Prochaines etapes

| # | Tache | Statut | Session |
|---|-------|--------|---------|
| 1 | Deploy landing tech.karibu.co.ci | FAIT | S1-S2 |
| 2 | Routes Auth → /orion/ | FAIT | S2 |
| 3 | Config Nginx + SSL sur VPS | FAIT | S2 |
| 4 | Tests Phase 1 (36 tests / 60 assertions) | FAIT | S2 |
| 5 | Systeme abonnements (plans, checkout, admin) | FAIT | S3 |
| 6 | Page /tarifs + /checkout + /demo | FAIT | S3 |
| 7 | Middleware VerifySubscription | FAIT | S3 |
| 8 | Command cron subscriptions:check | FAIT | S3 |
| 9 | Module CMS complet (tables, controllers, vues, seeder) | FAIT | S4 |
| 10 | CI/CD GitHub Actions (deploy.yml) | FAIT | S5 |
| 11 | Fix SSH port 22 (pas 5022) | FAIT | S5 |
| 12 | Deploy key GitHub Actions | FAIT | S5 |
| 13 | Design system + favicon + couleurs royal-600 | FAIT | S5 |
| 14 | Dashboard sidebar + stats + accès rapides | FAIT | S5 |
| 15 | Fix sidebar lg:static double-offset | FAIT | S6 |
| 16 | Fix browser cache (SW + middleware + meta) | FAIT | S7 |
| 17 | Redesign UI/UX backend (sidebar dark, cards, animations) | FAIT | S7 |
| 18 | Fix JSON editor modal (Alpine.js) | FAIT | S7 |
| 19 | Fix page creation modal (Alpine.js) | FAIT | S7 |
| 20 | **Module Paie (CNPS + ITS)** | A FAIRE | S8 |
| 21 | **API Flutter (Sanctum)** | A FAIRE | — |
| 22 | **Mobile Money / Stripe** | A FAIRE | — |
| 23 | **Tests RH + Régie Pub** | A FAIRE | — |
| 24 | **Docker Compose + installateur client** | A FAIRE | — |
| 25 | **WebSocket Reverb (temps réel)** | A FAIRE | — |
| 26 | **Licence JWT (Self-Hosted SaaS)** | A FAIRE | — |

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

### Session 5 — 2026-09-10 (CI/CD + UI)
- **GitHub repo** cree: `https://github.com/DamiahnVint/karibu-saas` (public)
- **CI/CD GitHub Actions** : `.github/workflows/deploy.yml` — push to main → SSH VPS → git pull + artisan cache
- **Deploy key** SSH generee sur VPS (`/root/.ssh/deploy_key`)
- **Guide de deploiement** : `C:\Users\WEBDEV\Documents\DEPLOYMENT_GUIDE.md`
- **SSH Port**: 22 (PAS 5022 comme indiqué dans CONTEXT.md)
- **APP_KEY** generee sur VPS
- **Premier commit + push** : 161 fichiers → GitHub
- **Design system** mis a jour : couleurs royal-600 partout (remplacement indigo)
- **Favicon** : SVG + PNGs (32, 180, 192, 512px) deployes dans tous les layouts
- **Dashboard** : sidebar navigation complete avec role-based links, stats reelles, accès rapides, guide demarrage
- **Fix role enum** : `Role::tryFrom()` au lieu de `->label()` sur string

### Session 6 — 2026-09-11 (Bug fix layout)
- **Bug sidebar double-offset** : le `lg:static` sur le sidebar + `lg:pl-72` sur le contenu creait un double decalage
- **Fix** : Suppression `lg:static lg:z-auto` du sidebar — reste `fixed` sur tous les ecrans
- **Deploy** : commit `27d5d14`, VPS mis a jour

### Session 7 — 2026-09-11 (Cache fix + Redesign UI/UX + CMS bugs)
- **Bug cache navigateur** : Le browser servait une ancienne version du dashboard (PJ1 vs PJ2 apres Ctrl+Shift+R)
- **Cause** : Service Worker cachait les pages `/orion/*` et `/dashboard`
- **Fix SW** : `public/sw.js` — les routes auth ne sont plus mises en cache (fallback "reconnectez-vous")
- **Fix middleware** : `PreventBrowserCache` — headers `Cache-Control: no-store` sur pages auth
- **Fix meta** : `no-cache, no-store, must-revalidate` dans le `<head>` admin
- **Redesign UI/UX backend** complet :
  - Sidebar dark gradient (gray-950 → royal-950) avec glow actif
  - Dashboard hero header gradient, stats avec icones colorees + hover lift
  - Toutes les vues admin redesignees (CMS, Plans, Tenants, Forms, Media, Settings)
  - Composants UI mis a jour (bouton gradient, card hover, badge ring, alert icons)
  - Animations: fadeInUp, hover scale, transitions 200ms
  - Layout: topbar desktop avec breadcrumbs, user footer dark
  - 23 fichiers modifies, 866 insertions, 601 suppressions
- **Fix JSON editor** : Le bouton "Editer le JSON" ne faisait rien (no-op JS)
  - Remplacement par modal Alpine.js complet : textarea sur fond sombre, validation temps reel, formater, tab, Escape
- **Fix page creation modal** : `classList.remove('hidden')` vanilla JS conflict avec Alpine.js
  - Remplacement par `showModal` Alpine.js avec `x-show` + `x-transition`
- **Commits** : `af3d1a9` (cache fix), `0385073` (redesign + cache fix), `2256483` (JSON/modal fix)

---

## Bugs connus / a surveiller
- Le dashboard (PJ1) montrait un ancien layout avant Ctrl+Shift+R — RESOLU (cache fix)
- `@apply` dans `<style>` inline n'est pas fiable avec Tailwind CDN — RESOLU (CSS brut)
- `lg:static` sur sidebar creait un double-offset — RESOLU
- `view()` ne supporte pas les objets Eloquent → utiliser `->toArray()` ou arrays
- `auth()->user()->role` est un string, PAS un enum → utiliser `Role::tryFrom()`

---

## Donnees de test
- **Admin super**: `admin@karibu.tech` / `Admin@2026!`
- **Plans par defaut** (via PlanSeeder): Essentiel 20K, Pro 35K, Enterprise, Trial
- **CMS pages** (via CmsSeeder): landing, pricing, demo, contact
- **Local dev**: `http://127.0.0.1:8081` (Nginx Docker)
- **Production**: `https://tech.karibu.co.ci`
