# Documentation UML pour l'Entreprise Village Green

## Introduction
L'entreprise Village Green distribue du matériel musical et souhaite évoluer son système de gestion des commandes et de facturation. Ce document contient les diagrammes UML décrivant le système en utilisant les cas d'utilisation, les séquences, les activités et les classes.

# Diagramme de Cas d'Utilisation

**Explication**
Le diagramme de cas d'utilisation décrit les interactions entre les différents types d'utilisateurs (acteurs) et le système. Les acteurs incluent les clients particuliers, les clients professionnels, les gestionnaires de produits, les commerciaux et les administrateurs. Les principaux cas d'utilisation couvrent la consultation du catalogue, la gestion des produits, la création de commandes, etc.

**Identifier les acteurs :**  
  
*Client :*  
        Le client qui interagit avec le système pour consulter le catalogue,  
        ajouter des produits au panier, passer des commandes, etc.  
          
*Administrateur :*  
        Gère les produits, catégories, sous-catégories et peut consulter les commandes et factures.  
  
*Système de paiement :*  
         Traite les paiements pour les commandes.  
  
**Identifier les cas d'utilisation :**  
  
*Client :*  
            Consulter le catalogue
            Ajouter produit au panier
            Valider le panier
            Créer commande
            Consulter commandes
            Modifier ses informations personnelles

*Administrateur :*  
            Gérer produits (ajouter, modifier, supprimer)
            Gérer catégories et sous-catégories
            Consulter toutes les commandes
            Consulter toutes les factures

*Système de paiement :*  
            Traiter paiement

 *Administrateur :*  
        Gère les produits, catégories, sous-catégories et peut consulter les commandes et factures.  
          
*Système de paiement :*  
        Traite les paiements pour les commandes.  
  
![Diagramme de Cas d'Utilisation](/asset/UML/GVCasUtilisation.png)

# Diagramme de Séquence

**Explication** 
Le diagramme de séquence montre les interactions entre un client, le site web e-commerce,  
le système de gestion et la banque lors de la validation du panier et du processus de commande.  
Voici les étapes détaillées :

    Client -> Site Web E-Commerce : Valider le panier  
        Le client valide son panier sur le site web e-commerce, indiquant qu'il est prêt à passer la commande.  
  
    Site Web E-Commerce -> Système de Gestion : Créer commande  
        Le site web e-commerce envoie une demande au système de gestion pour créer une nouvelle commande.  
  
    Système de Gestion -> Système de Gestion : Vérifier stock  
        Le système de gestion vérifie le stock des produits pour s'assurer que les articles commandés sont disponibles.  
  
    Système de Gestion -> Site Web E-Commerce : Confirmer commande  
        Une fois le stock vérifié, le système de gestion confirme la commande au site web e-commerce.  
  
    Site Web E-Commerce -> Système de Gestion : Confirmer paiement  
        Le site web e-commerce envoie une demande au système de gestion pour confirmer le paiement de la commande.  
  
    Système de Gestion -> Banque : Demande de paiement  
        Le système de gestion contacte la banque pour demander la confirmation du paiement de la commande.  
  
    Banque -> Système de Gestion : Confirmer paiement  
        La banque confirme le paiement au système de gestion.  
  
    Système de Gestion -> Site Web E-Commerce : Créer facture  
        Une fois le paiement confirmé, le système de gestion crée une facture pour la commande.  
  
    Site Web E-Commerce -> Client : Afficher confirmation  
        Le site web e-commerce affiche une confirmation de la commande au client.  
  
    Système de Gestion -> Client : Envoyer facture  
        Le système de gestion envoie la facture générée au client, généralement par email.  
  
**Points Clés**  

*Interactions des Acteurs :*  
    Les interactions principales se font entre le client, le site web e-commerce,  
    le système de gestion et la banque. Chaque acteur joue un rôle essentiel dans le processus de commande.  
      
*Vérifications :*  
Avant de confirmer la commande, des vérifications importantes sont effectuées,  
notamment la vérification du stock et la confirmation du paiement.  
  
*Génération de Facture :*  
Une fois le paiement confirmé, une facture est générée et envoyée au client,  
assurant ainsi que toutes les étapes nécessaires pour finaliser la commande sont complétées.  
  
Ce diagramme de séquence capture l'essentiel du processus de commande en ligne, montrant les étapes clés et les interactions entre les différents systèmes impliqués.  
![Diagramme de Séquence](/asset/UML/GVSequence.png)

# Diagramme d'Activités  
  
**Explication du Diagramme d'Activités**  
  
Le diagramme d'activités PlantUML ci-dessus décrit le processus de commande dans un site de commerce électronique,   
depuis la consultation du catalogue jusqu'à l'envoi de la confirmation et de la facture, ou la notification au client en cas de stock insuffisant.  
Voici une explication étape par étape :  
  
# Étapes du Processus  
  
*Consulter le catalogue*    
        Le client consulte le catalogue de produits disponible sur le site e-commerce.  
        Cette étape permet de visualiser les différents produits proposés.  
  
*Ajouter produit au panier*  
        Le client sélectionne les produits qu'il souhaite acheter et les ajoute à son panier.  
  
*Valider le panier*  
        Une fois les produits choisis, le client valide son panier pour passer à l'étape de commande.  
  
*Créer commande*  
        Le système crée une nouvelle commande en se basant sur les produits présents dans le panier validé par le client.  

*Confirmer stock*  
        Le système vérifie la disponibilité des produits en stock.  
  
## Décision sur la Disponibilité du Stock

*Stock suffisant?*  
        Le diagramme bifurque en fonction de la disponibilité du stock :  
            Oui : Si le stock est suffisant pour tous les produits de la commande.  
            Non : Si le stock est insuffisant pour un ou plusieurs produits.  
  
*Branche "Stock Suffisant"*  
  
*Confirmer paiement*  
        Si le stock est suffisant, le système procède à la confirmation du paiement.  
        Cela peut inclure une interaction avec un service de paiement pour autoriser la transaction.  
  
*Créer facture*  
        Une fois le paiement confirmé, le système génère une facture pour la commande.  

*Envoyer confirmation et facture*  
        Le système envoie une confirmation de commande et la facture au client, clôturant ainsi le processus de commande.  
  
*Branche "Stock Insuffisant"*  
  
*Notifier client*    
        Si le stock est insuffisant, le système notifie le client de l'indisponibilité des produits souhaités.  
        Le processus s'arrête à cette étape sans créer de commande ni de facture.  

## Points Clés

*Flux Principal :* La majorité des commandes suivront le flux principal où le stock est suffisant, le paiement est confirmé, et la commande est finalisée avec l'envoi d'une confirmation et d'une facture au client.
*Scénario Alternatif :* Si le stock est insuffisant, le client est immédiatement notifié, ce qui évite toute frustration liée à des commandes impossibles à honorer.
*Décision Critique :* La vérification du stock est une décision critique qui détermine le chemin que prendra le reste du processus de commande.
  
![Diagramme d'Activité](/asset/UML/GVActivites.png)

# Diagramme de Classes (Entités)  
  
## Classes et Attributs

*Client*  
        clientId : int : Identifiant unique du client.  
        nom : String : Nom du client.  
        prenom : String : Prénom du client.  
        adresse : String : Adresse du client.  
        password : String : Mot de passe encodé du client.  
        typeClient : bool : Indique si le client est un particulier ou une entreprise (vrai/faux).  
        coefficient : float : Coefficient de réduction appliqué aux commandes du client.  
  
*Produit*  
        produitId : int : Identifiant unique du produit.  
        libelle : String : Libellé ou nom du produit.  
        description : String : Description du produit.  
        prixAchat : float : Prix d'achat du produit.  
        photo : String : URL ou chemin vers la photo du produit.  
        rubrique : String : Rubrique principale du produit.  
        sousRubrique : String : Sous-rubrique du produit.  
  
*Commande*  
        commandeId : int : Identifiant unique de la commande.  
        dateCommande : Date : Date à laquelle la commande a été passée.  
        montantTotal : decimal : Montant total de la commande.  
        statut : String : Statut de la commande (ex. : en cours, expédiée, livrée).  
        clientId : int : Identifiant du client ayant passé la commande.  
  
*Facture*  
        factureId : int : Identifiant unique de la facture.  
        commandeId : int : Identifiant de la commande associée à la facture.  
        montant : decimal : Montant total de la facture.  
        dateEmission : Date : Date d'émission de la facture.  
  
*Categorie*  
        categorieId : int : Identifiant unique de la catégorie.  
        produits : List<Produit> : Liste des produits appartenant à cette catégorie.  
  
*SsCategorie*  
        sscategorieId : int : Identifiant unique de la sous-catégorie.  
        produits : List<Produit> : Liste des produits appartenant à cette sous-catégorie.  

## Relations Entre les Classes  
  
    Client "1" --> "0..*" Commande  
        Un client peut passer plusieurs commandes (relation un-à-plusieurs).  
  
    Commande "1" --> "1" Facture  
        Chaque commande est associée à une seule facture (relation un-à-un).  

    Catalogue "1" --> "0..*" Produit  
        Un catalogue peut contenir plusieurs produits (relation un-à-plusieurs).  
  
    SsCategorie "1" --> "0..*" Categorie  
        Une sous-catégorie peut contenir plusieurs catégories, mais cette relation semble inversée.  
        Logiquement, une catégorie devrait contenir plusieurs sous-catégories.  

### Points Clés  
  
    Client et Commande : Les clients passent des commandes. Chaque client peut avoir plusieurs commandes, mais chaque commande est associée à un seul client.  
    Commande et Facture : Chaque commande a une facture unique associée, reflétant le montant et les détails de la commande.  
    Catalogue et Produit : Les produits sont organisés dans un catalogue, facilitant la recherche et la gestion des produits.  
    Categorie et SsCategorie : Les produits sont classés dans des catégories et des sous-catégories, permettant une organisation hiérarchique des produits.  

Ce diagramme de classe donne une vue d'ensemble structurée des principales entités et de leurs relations dans un système de gestion de commerce électronique,  
facilitant ainsi la compréhension et le développement du système.  
  
![Diagramme de Classes](/asset/UML/GVClasses.png)
  
# Explication

Ce diagramme de classes représente un modèle de gestion de clients, produits, commandes et factures. 
Voici une explication des différentes classes et de leurs relations.  
  
**Classe Client :**  
        Attributs :  
            clientId : int : Identifiant unique du client.  
            nom : String : Nom du client.  
            adresse : String : Adresse du client.  
            typeClient : String : Type de client (ex : régulier, VIP).  
            coefficient : float : Coefficient associé au client, peut-être utilisé pour des remises ou des calculs spécifiques.  
  
**Classe Produit :**  
        Attributs :  
            produitId : int : Identifiant unique du produit.  
            libelle : String : Nom ou libellé du produit.  
            description : String : Description détaillée du produit.  
            prixAchat : float : Prix d'achat du produit.  
            photo : String : URL ou chemin vers la photo du produit.  
            rubrique : String : Rubrique principale à laquelle appartient le produit.  
            sousRubrique : String : Sous-rubrique spécifique du produit.  
  
**Classe Commande :**  
        Attributs :  
            commandeId : int : Identifiant unique de la commande.  
            dateCommande : Date : Date à laquelle la commande a été passée.  
            montantTotal : float : Montant total de la commande.  
            statut : String : Statut de la commande (ex : en cours, livrée, annulée).  
            clientId : int : Identifiant du client ayant passé la commande.  
  
**Classe Facture :**  
        Attributs :  
            factureId : int : Identifiant unique de la facture.  
            commandeId : int : Identifiant de la commande associée à la facture.  
            montant : float : Montant de la facture.  
            dateEmission : Date : Date d'émission de la facture.  
  
**Classe Catalogue :**  
        Attributs :  
            catalogueId : int : Identifiant unique du catalogue.  
            produits : List<Produit> : Liste de produits présents dans le catalogue.  
  
# Relations entre les Classes  

**Relation Client - Commande :**  
        Un client (Client) peut passer plusieurs commandes (Commande).  
        Relation de type "1 à 0..*" : Un client peut avoir zéro ou plusieurs commandes.  
  
**Relation Commande - Facture :**  
        Une commande (Commande) est associée à une unique facture (Facture).  
        Relation de type "1 à 1" : Une commande entraîne l'émission d'une seule facture.  
  
**Relation Catalogue - Produit :**  
        Un catalogue (Catalogue) contient plusieurs produits (Produit).  
        Relation de type "1 à 0..*" : Un catalogue peut contenir zéro ou plusieurs produits.  
  
**Conclusion**  
Ces diagrammes UML offrent une vue complète du système de gestion des commandes et de facturation pour l'entreprise Village Green.  
Ils peuvent être utilisés comme base pour le développement et l'amélioration du système existant.  