# Guide de Déploiement CI/CD — Tous Projets

## Prérequis

### Compteurs nécessaires
- **GitHub** : compte `DamiahnVint`
- **Token GitHub** (PAT) : scope `repo` + `workflow` (optionnel mais recommandé)
- **VPS Contabo** : IP publique, accès root via SSH

### Outils locaux (machine de dev)
- Git (`git --version`)
- PHP (`php -v`)
- Composer (`composer --version`)
- Docker Desktop (optionnel, pour dev local)

---

## ÉTAPE 1 — Initialiser un projet

### 1.1 Créer le repo GitHub

```bash
# Via API (quand gh CLI n'est pas disponible)
curl -X POST -H "Authorization: token <TOKEN>" -H "Content-Type: application/json" \
  -d '{"name":"<NOM_PROJET>","description":"<DESCRIPTION>","private":false,"auto_init":false}' \
  https://api.github.com/user/repos
```

Ou manuellement sur `https://github.com/new`

### 1.2 Initialiser Git local

```bash
cd /chemin/vers/projet
git init
git config user.name "Karibu Technologies"
git config user.email "tech@karibu.co.ci"
git remote add origin https://github.com/DamiahnVint/<NOM_PROJET>.git
```

### 1.3 Configurer le `.gitignore`

Toujours inclure ces entrées :

```gitignore
# Environnement — JAMAIS commité
.env
.env.backup
.env.production
.env.docker
.env.deploy
.deploy.env

# Dépendances
/vendor
/node_modules

# Logs
*.log
/storage/logs/*

# Cache Laravel
/storage/framework/views/*
/storage/framework/cache/*
/storage/framework/sessions/*

# IDE
/.cursor/
/.idea
/.vscode
/.zed

# OS
.DS_Store
Thumbs.db

# Laravel specifique
/public/build
/public/hot
/public/storage
/storage/*.key
/auth.json
```

### 1.4 Premier commit + push

```bash
git add .
git commit -m "feat: <DESCRIPTION_PROJET>"
git push -u origin master:main
```

---

## ÉTAPE 2 — Configurer le VPS

### 2.1 Initialiser Git sur le VPS

```bash
ssh root@<IP_VPS>
cd /opt/<DOSSIER_PROJET>
git init
git config --global --add safe.directory /opt/<DOSSIER_PROJET>
git remote add origin https://github.com/DamiahnVint/<NOM_PROJET>.git
git fetch origin main
git reset --hard origin/main
```

### 2.2 Copier le `.env` (jamais dans le repo)

```bash
cp /opt/<DOSSIER_PROJET_VIEUX>/.env /opt/<DOSSIER_PROJET>/.env
# OU créer manuellement
nano /opt/<DOSSIER_PROJET>/.env
```

### 2.3 Installer les dépendances

```bash
cd /opt/<DOSSIER_PROJET>
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
php artisan key:generate  # si première fois
php artisan migrate --force
php artisan db:seed --force  # si seeders nécessaires
```

### 2.4 Configurer les permissions

```bash
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

## ÉTAPE 3 — GitHub Actions CI/CD

### 3.1 Générer une deploy key sur le VPS

```bash
ssh root@<IP_VPS>
ssh-keygen -t ed25519 -f /root/.ssh/deploy_key_<PROJET> -N '' -C 'github-actions-<PROJET>'
cat /root/.ssh/deploy_key_<PROJET>.pub >> /root/.ssh/authorized_keys
cat /root/.ssh/deploy_key_<PROJET>  # ← copier cette clé privée
```

### 3.2 Ajouter le secret SSH sur GitHub

```bash
# 1. Récupérer la public key du repo
curl -H "Authorization: token <TOKEN>" \
  https://api.github.com/repos/DamiahnVint/<NOM_PROJET>/actions/secrets/public-key

# 2. Chiffrer la clé privée avec sodium (PHP sur le VPS)
php -r '
$pubkey = sodium_base642bin("<PUBLIC_KEY>", SODIUM_BASE64_VARIANT_ORIGINAL);
$secret = file_get_contents("/root/.ssh/deploy_key_<PROJET>");
$enc = sodium_crypto_box_seal($secret, $pubkey);
echo sodium_bin2base64($enc, SODIUM_BASE64_VARIANT_ORIGINAL);
'

# 3. Envoyer le secret chiffré
curl -X PUT -H "Authorization: token <TOKEN>" -H "Content-Type: application/json" \
  -d '{"key_id":"<KEY_ID>","encrypted_value":"<VALEUR_CHIFFREE>"}' \
  https://api.github.com/repos/DamiahnVint/<NOM_PROJET>/actions/secrets/VPS_SSH_KEY
```

### 3.3 Créer le workflow GitHub Actions

Créer le fichier `.github/workflows/deploy.yml` :

```yaml
name: Deploy to Production

on:
  push:
    branches: [main]
  workflow_dispatch:

jobs:
  deploy:
    name: Deploy to VPS
    runs-on: ubuntu-latest
    timeout-minutes: 10

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Deploy via SSH
        uses: appleboy/ssh-action@v1
        with:
          host: <IP_VPS>
          port: 22
          username: root
          key: ${{ secrets.VPS_SSH_KEY }}
          script: |
            cd /opt/<DOSSIER_PROJET>
            git fetch origin main
            git reset --hard origin/main
            composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
            php artisan config:cache
            php artisan route:cache
            php artisan view:cache
            php artisan migrate --force
            chown -R www-data:www-data storage bootstrap/cache
            echo "Deploy completed at $(date)"
```

### 3.4 Commit + push le workflow

```bash
git add .github/workflows/deploy.yml
git commit -m "ci: add GitHub Actions deploy workflow"
git push origin master:main
```

---

## ÉTAPE 4 — Processus quotidien

### Le workflow normal

```
1. Coder en local
2. git add .
3. git commit -m "<type>: <description>"
4. git push origin master:main
5. → GitHub Actions déploie automatiquement sur le VPS
6. → Vérifier le site en prod
```

### Types de commit (convention)

| Type | Usage |
|---|---|
| `feat` | Nouvelle fonctionnalité |
| `fix` | Correction de bug |
| `ci` | Modification du pipeline CI/CD |
| `refactor` | Refactorisation sans changement de comportement |
| `docs` | Documentation |
| `style` | Formatage, pas de changement logique |
| `test` | Ajout/modification de tests |
| `chore` | Maintenance, dépendances, config |

### Exemples

```bash
git commit -m "feat: ajout du module paie"
git commit -m "fix: correction du login 500 error"
git commit -m "ci: corriger port SSH dans deploy.yml"
git commit -m "refactor: découper ComptaController en services"
```

---

## ÉTAPE 5 — Déploiement manuel (si besoin)

Si GitHub Actions ne fonctionne pas ou pour un hotfix :

```bash
# Depuis la machine locale
ssh -i <CLE_SSH> root@<IP_VPS>
cd /opt/<DOSSIER_PROJET>
git pull origin main
composer install --no-dev
php artisan config:cache && php artisan route:cache && php artisan view:cache
php artisan migrate --force
chown -R www-data:www-data storage bootstrap/cache
```

---

## Règles ABSOLUES

1. **JAMAIS de `.env` dans Git** — contient secrets, mots de passe, clés API
2. **JAMAIS de `vendor/` dans Git** — `composer install` le reconstruit
3. **JAMAIS de `node_modules/` dans Git** — `npm install` le reconstruit
4. **JAMAIS de `storage/framework/views/` dans Git** — le cache est reconstruit
5. **Toujours `php artisan migrate --force`** en prod (jamais interactif)
6. **Toujours `chown -R www-data:www-data`** après déploiement
7. **Un commit = un objectif** — pas de mélange bugfix + feature
8. **Push sur `main` = déploiement prod** — pas de push sans être sûr

---

## Variables à adapter par projet

| Variable | Exemple |
|---|---|
| `<NOM_PROJET>` | `karibu-saas` |
| `<IP_VPS>` | `169.58.220.27` |
| `<DOSSIER_PROJET>` | `karibu-tech` |
| `<TOKEN>` | `ghp_XXX...` |
| `<CLE_SSH>` | `~/.ssh/id_ed25519_<PROJET>` |

---

## Vérification post-déploiement

Toujours vérifier après un push :

```bash
# Vérifier le site
curl -s -o /dev/null -w '%{http_code}' https://<DOMAINE>/

# Vérifier les logs
ssh root@<IP_VPS> "tail -5 /opt/<DOSSIER_PROJET>/storage/logs/laravel.log"

# Vérifier le dernier commit sur le VPS
ssh root@<IP_VPS> "cd /opt/<DOSSIER_PROJET> && git log --oneline -1"
```

---

*Dernière mise à jour : 11 Septembre 2026 — Projet Karibu SaaS*
*Créé par Lumen (agent) pour BRYCE (responsable produit)*
