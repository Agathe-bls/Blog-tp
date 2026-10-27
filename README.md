# TP_noté_PHP - groupe_8

## Nom de projet
Blog

## Description
Blog réalisé pour le TP noté du cours de PHP.
Ce blog est composé de plusieurs fonctionnalités :

 - Une page de connexion (email, mot de passe) qui créera un utilisateur à la volée si son compte n’existe pas ; Chaque page suivant redirige vers celle-ci si l’utilisateur n’est pas connecté.

 - Une page qui liste les articles (page d’accueil) et qui permet de filtrer l’affichage par pseudo.

 - Une page qui affiche un article et ses commentaires (avec un formulaire d’ajout de commentaire).

 - Une page de création d’article avec une ou plusieurs catégories (et les autres attributs).

 - Un CRUD pour les catégories (avec un préfix « /admin ») et accessible uniquement pour l’admin (admin@localhost.fr ; mdp : « admin69IUT; » ).
 (CRUD veut dire : CREATE READ UPDATE DELETE -> ce sont des actions dites basiques que l'on fait habituellement sur un objet. Donc un formulaire pour créer une catégorie, un pour éditer (penser à garder l'ID quelque part), une page qui les liste et un bouton pour supprimer dans cette liste directement.)

 - La possibilité pour le propriétaire de l’article ou du commentaire de supprimer leur participation.

## Langages utilisés
 - PHP
 - HTML/CSS
 - SQL

## Auteurs
 - Agathe Balsan
 - Valentin Gonzalez
 - Idman Ibrahim Abdi
Groupe 8
G4S3

------------------------------

## Visuals
Depending on what you are making, it can be a good idea to include screenshots or even a video (you'll frequently see GIFs rather than actual videos). Tools like ttygif can help, but check out Asciinema for a more sophisticated method.

## Installation
Within a particular ecosystem, there may be a common way of installing things, such as using Yarn, NuGet, or Homebrew. However, consider the possibility that whoever is reading your README is a novice and would like more guidance. Listing specific steps helps remove ambiguity and gets people to using your project as quickly as possible. If it only runs in a specific context like a particular programming language version or operating system or has dependencies that have to be installed manually, also add a Requirements subsection.

## Usage
Use examples liberally, and show the expected output if you can. It's helpful to have inline the smallest example of usage that you can demonstrate, while providing links to more sophisticated examples if they are too long to reasonably include in the README.

---------------------------------------------

## Add your files

* [Create](https://docs.gitlab.com/user/project/repository/web_editor/#create-a-file) or [upload](https://docs.gitlab.com/user/project/repository/web_editor/#upload-a-file) files
* [Add files using the command line](https://docs.gitlab.com/topics/git/add_files/#add-files-to-a-git-repository) or push an existing Git repository with the following command:

```
cd existing_repo
git remote add origin https://forge.univ-lyon1.fr/p2502171/tp_note_php-groupe_8.git
git branch -M main
git push -uf origin main
```

## Collaborate with your team

* [Invite team members and collaborators](https://docs.gitlab.com/user/project/members/)
* [Create a new merge request](https://docs.gitlab.com/user/project/merge_requests/creating_merge_requests/)
* [Automatically close issues from merge requests](https://docs.gitlab.com/user/project/issues/managing_issues/#closing-issues-automatically)
* [Enable merge request approvals](https://docs.gitlab.com/user/project/merge_requests/approvals/)
* [Set auto-merge](https://docs.gitlab.com/user/project/merge_requests/auto_merge/)


