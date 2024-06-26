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
  
![Diagramme de Cas d'Utilisation](/public/UML/GVCasUtilisation.png)

# Diagramme de Séquence

**Explication** 
Le diagramme de séquence montre l'interaction entre les différents objets pour réaliser un cas d'utilisation spécifique : la validation du panier et la création d'une commande. Il décrit comment le client interagit avec le site web, qui à son tour interagit avec le système de gestion et la banque.

***Code PlantUML***
@startuml
actor Client
participant "Site Web E-Commerce" as ECommerce
participant "Système de Gestion" as Gestion
participant "Banque" as Banque

Client -> ECommerce: Valider le panier
ECommerce -> Gestion: Créer commande
Gestion -> Gestion: Vérifier stock
Gestion -> ECommerce: Confirmer commande
ECommerce -> Gestion: Confirmer paiement
Gestion -> Banque: Demande de paiement
Banque -> Gestion: Confirmer paiement
Gestion -> ECommerce: Créer facture
ECommerce -> Client: Afficher confirmation
Gestion -> Client: Envoyer facture
@enduml

![Diagramme de Séquence](/public/UML/GVSequence.png)

# Diagramme d'Activités

**Explication**
Le diagramme d'activités illustre le flux de travail impliqué dans le processus de commande pour un client particulier.   
Il montre les étapes allant de la consultation du catalogue à l'envoi de la confirmation et de la facture,   
en passant par la validation du panier et la création de la commande.
![Diagramme d'Activité](/public/UML/GVActivites.png)

# Diagramme de Classes (Entités)

![Diagramme de Classes](/public/UML/GVClasses.png)

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