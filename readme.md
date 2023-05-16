# Gestion du personnel
Projet : gestion du personnel
Auteur : Haritina Jiovanny
Matricule : 2418/20
Version: 1.0.0

## Struture des dossier
### app 
- Emplacement des traits de CRUD universelle ( applicable à tout type de table)
- Configues de la database et de sa définition de class
- Déclaration de la Class fpdf et son enfant PDF
- Les modèles et l'interface model. 
- La class de sécurisation
- La class de validation globale ( adaptable pour tout type de Model )

### assets
- Emplacement des lib css et du css personnel
- Emplacement du js

### config
- Fichier des constantes de configuration du projet

### controllers
- emplacement des controlleurs de chaque model et le traitement des vues

### pages
- emplacement des vues des modèles
- un dossier represente un lien
- emplacement des composants et des containers
- emplacement des pages d'error HTTP
- emplacement des états des model

### vendor
- ensemble des dépendances du projet
- emplacement de l'autoloader du projet

## Fonctionnalités
- Information des employés + données imprimables
- CRUD employés, service, metier
- Gestion de l'affectation d'un employe en particulier ( Ajout / Suppression )
- Etat des Employés par Service
- Pagination par CRUD
- Validation personnalisée pour les Create

## Etats 
- Information des employés ( age, anciennete, age arrivée ... )
- Employés d'un service concerné

# Améliorations possibles
- Implémentation d'un routeur pour véritablement harmoniser la structure MVC
- Création d'une Class Render pour optimiser les vues dynamiques et leur passé des variables facilement
- Optimisation de la Class Validation pour qu'il soit plus spécifique aux models
- Amélioration des models : utilisation de l'héritage mais pas du polymorphisme pour avoir les class modèles
- Optimisation de la class Securisation pour le futur routeur. Implémenter la protection contre les failles xss


