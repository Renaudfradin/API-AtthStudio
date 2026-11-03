# API AtthStudio — Collection Bruno

Collection Git-native des endpoints publics de l'API (`/api/*`).

## Prérequis

- [Bruno](https://www.usebruno.com/) (application desktop) pour l'usage interactif
- API locale démarrée : `./vendor/bin/sail up` (port `8001` par défaut)

## Ouvrir la collection

1. Lancer Bruno
2. **Open Collection** → sélectionner le dossier `bruno/` à la racine du projet
3. Choisir l'environnement **Local** ou **Production** dans la barre d'environnements

## Environnements

| Environnement | baseUrl | Usage |
|---|---|---|
| Local | `http://localhost:8001` | Développement avec Sail |
| Production | `https://api-atthstudio.up.railway.app` | API déployée |
| CI | `http://127.0.0.1:8000` | Exécution CLI |

### Variables

Les requêtes de détail utilisent des variables :

- `articleSlug`, `archiveSlug`, `projectSlug`, `categoryId`

## Structure

```
bruno/
├── General/          # Home, Health
├── Articles/         # list, show, suggest
├── Archives/
├── Categories/       # list uniquement
└── Projects/
```

## CLI

```bash
npm install
npm run bruno:run        # environnement Local
npm run bruno:run:ci     # environnement CI (rapport JUnit)
```

## Notes

- Tous les endpoints sont **GET publics**, sans authentification (rate limit : 60 req/min)
- `/api/health` complète le healthcheck Laravel `GET /up`
- Ne pas committer de secrets dans les fichiers d'environnement Bruno
