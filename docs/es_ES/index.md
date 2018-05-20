Description
===
Ce plugin a pour but de permettre de gérer ses volets de manière proportionnel.

Paramétrage d'un volet proportionnel
===

![introduction01](../images/Configuration.jpg)

La page de configuration est assez simple.

Général
---

* Nom du volet : Le nom a déjà été paramétrée mais vous avez la possibilité de la changer
* Objet parent : Ce paramétré permet d'ajouter l'équipement dans un objet Jeedom
* Catégorie : Déclare l'équipement dans une catégorie
* Visible : Permet de rendre l'équipement visible dans le Dashboard
* Activer : Permet d'activer l'équipement

Objet de control du volet
---

* Objet de montée : Commande Jeedom permettant de contrôler la montée (Action -> Défaut)
* Objet de stop : Commande Jeedom permettant de contrôler le stop (Action -> Défaut)
* Objet de descente : Commande Jeedom permettant de contrôler la descente (Action -> Défaut)

Objet d'état du volet
---

* État du mouvement : Commande Jeedom représentant l'état du mouvement (info -> Binaire : 0 = descente, 1 = montée)
* État du stop :  Commande Jeedom représentant l'état du stop (info -> Binaire : 1 = stop)
* Fin de course :  Commande Jeedom représentant la fin de course (info -> Binaire :1 = Volet complètement fermé)

Délais
---

* Temps total : Temps total que met le volet pour une fermeture ou une ouverture complète.
* Temps de décollement : Temps avant lequel le volet se décolle du sol
