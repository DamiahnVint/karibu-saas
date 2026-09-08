# KARIBU-SOFTWARE — Memoire du Projet

## Date de creation : 2026-09-08
## Agent : Lumen (opencode)
## Projet : Karibu Technologies — Suite SaaS

---

## Resume du projet

Karibu Technologies est un groupe technologique fonde par BRYCE, base a Abidjan, Cote d'Ivoire. La societe developpe une suite logicielle SaaS destinee aux entreprises ouest-africaines.

### Produits
1. **Karibu Paie** — Logiciel de paie conforme aux normes ivoiriennes (CNPS, ITS, CMU)
2. **Karibu Scolaire** — Gestion scolaire complete (a venir)
3. **Karibu VTC** — Mise en relation clients/chauffeurs (en developpement par une autre equipe)

### Stack technique
- **Backend** : Laravel 13 (PHP 8.3)
- **Frontend** : Blade + Tailwind CSS CDN + Alpine.js
- **Base de donnees** : MySQL 8.0
- **Cache** : Redis
- **Conteneurs** : Docker Compose
- **CI/CD** : GitHub Actions
- **VPS** : Contabo Cloud VPS Plus 6 (6 CPU, 12GB RAM, 300GB)

### Architecture
- **Multi-tenancy** : Shared Database + tenant_id (row-level tenancy)
- **Roles** : super_admin, tenant_owner, tenant_admin, tenant_manager, tenant_user
- **Plans** : free (14j), essentiel (25K), professionnel (45K), enterprise (sur mesure)

---

## Session 1 — 2026-09-08

### Objectifs
- Creer le repo GitHub KARIBU-SOFTWARE (private)
- Initialiser Laravel 13
- Configurer Docker Compose
- Architecture multi-tenancy
- Landing page PWA

### Fichiers crees
- `docker-compose.yml` — App + Nginx + MySQL + Redis + Queue + Scheduler
- `Dockerfile` — PHP 8.3 FPM Alpine
- `docker/nginx/default.conf` — Config Nginx
- `docker/php/local.ini` — Config PHP
- `app/Enums/Role.php` — 5 roles SaaS
- `app/Enums/TenantPlan.php` — 4 plans (free, essentiel, pro, enterprise)
- `app/Models/Tenant.php` — Modele tenant
- `app/Models/User.php` — Modele user avec roles
- `app/Traits/BelongsToTenant.php` — Scope automatique tenant
- `app/Http/Middleware/TenantMiddleware.php` — Middleware tenant
- `app/Http/Middleware/EnsureUserHasRole.php` — Middleware roles
- `app/Http/Controllers/LandingController.php`
- `app/Http/Controllers/Tenant/DashboardController.php`
- `database/migrations/0001_01_01_000000_create_tenants_table.php`
- `database/migrations/0001_01_01_000001_create_users_table.php`
- `database/baremes/cnps_2026.json` — Taux CNPS configurables
- `database/baremes/its_2026.json` — Barème ITS configurable
- `resources/views/landing.blade.php` — Landing page PWA
- `resources/views/tenant/dashboard.blade.php` — Dashboard tenant
- `public/manifest.json` — PWA manifest
- `PROJECT_MEMORY.md` — Ce fichier

### Etat d'avancement
- ✅ Laravel 13 installe (v13.31.0)
- ✅ Docker Compose configure
- ✅ Multi-tenancy: Tenant model + migration + trait + middleware
- ✅ Enums: Role + TenantPlan
- ✅ Landing page PWA avec animations
- ✅ Routes web
- ⏳ Tests Phase 0 (a faire)
- ⏳ Repo GitHub (besoin token auth)
- ⏳ VPS Contabo config (a faire)

### Notes techniques
- Docker tourne sur port 8080 (nginx)
- MySQL sur port 3307 (evite conflit avec XAMPP)
- Redis sur port 6380
- PHP 8.3 requis pour Laravel 13
- Timezone: Africa/Abidjan
- Locale: fr

### Securite
- Pas de secrets dans le code
- .env.docker pour les configs
- BelongsToTenant scope sur tous les modeles
- Roles avec hierarchie (super_admin > tenant_owner > tenant_admin > tenant_manager > tenant_user)

### Prochaines etapes
1. Authentifier gh CLI + creer repo GitHub
2. Docker up + valider le fonctionnement
3. Tests Phase 0
4. Config VPS Contabo
5. Phase 1: Moteur de paie (CNPS + ITS)

---

## Decisions importantes

| Decision | Raison |
|----------|--------|
| Architecture Shared DB + tenant_id | Simple, pas cher, suffisant pour 200 clients |
| Redis des le jour 1 | Cache + queue + sessions, $0 de surcout |
| Laravel 13 | Derniere version, support jusqu'en 2028 |
| PHP 8.3 | Requis par Laravel 13 |
| Barèmes CNPS/ITS en JSON | Configurables sans modifier le code |
| Roles SaaS internationaux | 5 niveaux hierarchiques standards |

---
