# CESIZen — L'application de votre santé mentale

Application web développée avec Symfony 7.4, dans le cadre de l'évaluation
CDA — Bloc 3 « Déployer et sécuriser les applications informatiques ».

## Stack technique

- **Backend** : PHP 8.3 / Symfony 7.4
- **Base de données** : MySQL 8.0 (Doctrine ORM)
- **Templating** : Twig
- **Serveur web** : Nginx (environnement conteneurisé)
- **Conteneurisation** : Docker / Docker Compose
- **Intégration continue** : GitHub Actions

## Modules couverts

- Comptes utilisateurs (inscription, connexion, gestion de compte)
- Informations (pages de contenu santé mentale)
- Exercices de respiration / cohérence cardiaque

## Environnement de test (Docker)

### Prérequis

- Docker et Docker Compose installés

### Installation

```bash
# 1. Cloner le dépôt
git clone <url-du-depot>
cd cesizen

# 2. Copier le fichier d'environnement
cp .env .env.local
# Adapter APP_SECRET dans .env.local si besoin

# 3. Construire et démarrer les conteneurs
docker compose up -d --build

# 4. Installer les dépendances (si non faites lors du build)
docker compose exec php composer install

# 5. Créer la base de données et jouer les migrations
docker compose exec php php bin/console doctrine:database:create --if-not-exists
docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

### Accès

| Service        | URL                          |
|----------------|-------------------------------|
| Application    | http://localhost:8080         |
| Adminer (BDD)  | http://localhost:8081          |

### Arrêt de l'environnement

```bash
docker compose down
```

## Intégration continue

Chaque `push` sur `main` déclenche automatiquement (`.github/workflows/ci.yml`) :
1. Installation des dépendances
2. Vérification de la syntaxe PHP
3. Validation de la configuration Symfony (YAML, Twig, schéma Doctrine)
4. Exécution des tests unitaires
5. Build de l'image Docker (validation du Dockerfile)

## Gestion des versions

Le projet est versionné avec Git. Convention de branches :
- `main` : version stable
- `develop` : intégration des évolutions
- `feature/xxx` : développement d'une fonctionnalité
- `fix/xxx` : correction d'une anomalie

## Suivi des anomalies et évolutions

Le suivi est assuré via GitHub Issues et un tableau GitHub Projects
(colonnes : À faire / En cours / En test / Terminé).
