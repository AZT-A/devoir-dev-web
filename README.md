# Cahier des charges — TaskFlow
## Application de gestion de tâches personnelles

**Réalisé par :** Farid
**Date :** Mai 2026

---

## 1. Présentation du projet

Pour mon projet de fin de formation, j'ai décidé de créer une application de gestion de tâches que j'ai appelée TaskFlow. L'idée m'est venue parce que je cherchais quelque chose de simple pour organiser mon travail au quotidien, et les outils comme Todoist ou Trello me semblaient trop chargés pour un usage basique.

L'application permet d'ajouter des tâches, de les classer par priorité, de les cocher quand elles sont faites, et de les supprimer. Les tâches sont sauvegardées dans une base de données MySQL, donc elles restent même si on ferme la page.

Ce projet m'a permis de mettre en pratique ce qu'on a vu en cours : HTML, CSS, JavaScript, React, PHP et MySQL, avec un petit serveur Node.js en plus.

---

## 2. Pourquoi ce projet

J'ai choisi une application de tâches parce que c'est un projet concret, que tout le monde comprend, et qui me permettait de toucher à toutes les technologies vues en formation sans partir sur quelque chose de trop compliqué. Je voulais quelque chose que je pouvais vraiment finir et expliquer de bout en bout.

---

## 3. À qui s'adresse l'application

L'application s'adresse à n'importe quelle personne qui veut garder une liste de tâches simple dans son navigateur. Pas besoin de créer un compte, pas besoin de télécharger quoi que ce soit. On ouvre la page, on ajoute ses tâches, et c'est tout.

---

## 4. Ce que fait l'application

### Ce qu'on peut faire :

- **Ajouter une tâche** : on tape un titre, on choisit une priorité (haute, moyenne ou basse), et on clique sur "Ajouter". La tâche apparaît dans la liste et est sauvegardée en base de données.

- **Cocher une tâche** : quand une tâche est terminée, on clique dessus pour la cocher. Elle s'affiche barrée et légèrement grisée.

- **Supprimer une tâche** : un bouton poubelle permet de supprimer définitivement une tâche.

- **Filtrer la liste** : trois boutons permettent d'afficher toutes les tâches, seulement celles en cours, ou seulement celles terminées.

- **Voir le compteur** : en haut de la page, on voit combien de tâches restent à faire.

### Ce que l'application ne fait pas (volontairement) :

- Pas de système de compte ou de connexion : ce n'était pas l'objectif du projet
- Pas de date limite sur les tâches : j'aurais pu l'ajouter mais ça aurait compliqué le code sans vraiment apporter quelque chose de nécessaire

---

## 5. Technologies utilisées

J'ai utilisé les technologies suivantes, qui sont toutes celles vues pendant la formation :

**HTML** — Pour écrire la structure de la page. C'est la base : les titres, les formulaires, les listes.

**CSS** — Pour le design. J'ai choisi un thème sombre parce que c'est plus agréable à regarder longtemps. J'ai utilisé des variables CSS pour garder les mêmes couleurs partout facilement.

**JavaScript** — Pour les interactions côté navigateur. C'est JavaScript qui fait les appels vers PHP pour envoyer ou récupérer les tâches.

**React** — Chargé directement via un lien CDN dans le HTML, donc sans outil de compilation. J'ai découpé la page en plusieurs petites parties réutilisables : une pour le titre, une pour le formulaire, une pour chaque tâche dans la liste. React se charge de mettre à jour l'affichage quand les données changent.

**PHP** — Un seul fichier PHP qui reçoit les demandes de la page (afficher les tâches, en ajouter une, en cocher une, en supprimer une) et qui fait les opérations correspondantes dans la base de données.

**MySQL** — La base de données. J'ai créé une table "tasks" avec cinq colonnes : un identifiant, le titre de la tâche, sa priorité, si elle est terminée ou non, et la date de création.

**Node.js** — Un petit serveur écrit en JavaScript qui sert les fichiers du projet. Il utilise uniquement des modules natifs de Node.js, sans librairie externe.

---

## 6. Comment les fichiers sont organisés

```
taskflow/
├── index.html    → la page principale avec React intégré
├── style.css     → tout le design
├── api.php       → le fichier PHP qui gère la base de données
├── server.js     → le serveur Node.js
└── schema.sql    → le script pour créer la table MySQL
```

Cinq fichiers au total. J'ai voulu garder quelque chose de simple à lire et à expliquer.

---

## 7. La base de données

J'ai créé une seule table appelée `tasks` dans une base de données MySQL nommée `taskflow_db`.

Voici les colonnes de cette table :

| Colonne | Type | Rôle |
|---|---|---|
| id | INT AUTO_INCREMENT | Identifiant unique de chaque tâche |
| title | VARCHAR(100) | Le texte de la tâche |
| priority | ENUM | La priorité : 'high', 'medium' ou 'low' |
| completed | TINYINT | 0 = pas terminée, 1 = terminée |
| created_at | TIMESTAMP | Date et heure d'ajout automatique |

---

## 8. Comment ça fonctionne ensemble

Quand on ouvre la page :
1. Le navigateur charge `index.html` et `style.css`
2. React s'initialise et demande à PHP la liste des tâches
3. PHP va chercher les tâches dans MySQL et les renvoie
4. React affiche les tâches dans la page

Quand on ajoute une tâche :
1. On remplit le formulaire et on clique sur "Ajouter"
2. React envoie le titre et la priorité au fichier PHP
3. PHP insère la nouvelle tâche dans la base de données
4. React met à jour la liste affichée

Cocher ou supprimer fonctionne de la même façon : React envoie une demande à PHP, PHP modifie la base, React met à jour l'affichage.

---

## 9. Design

L'interface est sobre et sombre. J'ai opté pour un fond très foncé (#0f0f13) avec des cartes légèrement plus claires (#1a1a24) pour les tâches. La couleur principale est un violet (#7c71ff) pour les boutons et les éléments actifs.

Les priorités ont chacune leur couleur :
- Rouge pour les tâches importantes
- Orange pour les tâches moyennes
- Vert pour les tâches peu urgentes

L'application est responsive : elle s'adapte aux petits écrans grâce à quelques règles CSS.

---

## 10. Ce que j'ai appris

Ce projet m'a appris à faire fonctionner plusieurs technologies ensemble. La partie qui m'a demandé le plus de travail c'est la communication entre React et PHP : comprendre comment envoyer des données depuis le navigateur vers un fichier PHP, et comment PHP renvoie les données en JSON pour que React puisse les lire.

J'ai aussi appris à structurer une base de données même simple, et à écrire des requêtes SQL correctement.
