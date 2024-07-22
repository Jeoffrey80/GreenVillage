<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class PerformanceController extends AbstractController
{
    #[Route('/chiffre-affaires', name: 'performance_dashboard')]
    public function chiffreAffaires(Connection $connection): Response
    {
        // Requête SQL pour récupérer le chiffre d'affaires par mois pour l'année 2024
        $chiffreAffairesSql = "
            SELECT 
                MONTH(c.date_debut_commande) AS Mois,
                SUM(c.montant_tot) AS Chiffre_d_affaires
            FROM 
                commande c
            WHERE 
                YEAR(c.date_debut_commande) = '2024'
            GROUP BY 
                MONTH(c.date_debut_commande)
        ";
        
        $chiffreAffairesResults = $connection->fetchAllAssociative($chiffreAffairesSql);

        // Requête SQL pour récupérer les produits les plus commandés pour l'année 2024
        $produitsCommandesSql = "
            SELECT 
                p.id AS Id_Produit,
                p.nom AS Nom_produit,
                SUM(cp.quantite) AS Quantité_commandée
            FROM 
                commande_produit cp
            INNER JOIN 
                commande c ON cp.commande_id = c.id
            INNER JOIN 
                produit p ON cp.produit_id = p.id
            WHERE 
                YEAR(c.date_debut_commande) = '2024'
            GROUP BY 
                p.id
            ORDER BY 
                Quantité_commandée DESC
            LIMIT 
                10
        ";
        
        $produitsCommandesResults = $connection->fetchAllAssociative($produitsCommandesSql);

        // Requête SQL pour récupérer les produits avec la meilleure marge pour l'année 2024
        $produitsMargeSql = "
            SELECT 
                p.id AS Id_Produit,
                p.nom AS Nom_produit,
                SUM(cp.quantite * (p.prix - p.prix)) AS Marge  -- Assurez-vous de remplacer 'p.prix - p.prix' par le calcul correct si nécessaire
            FROM 
                commande_produit cp
            INNER JOIN 
                commande c ON cp.commande_id = c.id
            INNER JOIN 
                produit p ON cp.produit_id = p.id
            WHERE 
                YEAR(c.date_debut_commande) = '2024'
            GROUP BY 
                p.id
            ORDER BY 
                Marge DESC
            LIMIT 
                10
        ";
        
        $produitsMargeResults = $connection->fetchAllAssociative($produitsMargeSql);

        // Requête SQL pour récupérer les clients avec le plus de commandes pour l'année 2024
        $clientsCommandesSql = "
            SELECT 
                cl.id AS Client_id,
                cl.nom AS Nom_client,
                cl.prenom AS Prenom_client,
                COUNT(*) AS Nombre_commandes,
                SUM(c.montant_tot) AS Chiffre_d_affaires
            FROM 
                client cl
            INNER JOIN 
                commande c ON cl.id = c.client_id
            WHERE 
                YEAR(c.date_debut_commande) = '2024'
            GROUP BY 
                cl.id, cl.nom, cl.prenom
            ORDER BY 
                Nombre_commandes DESC
            LIMIT 
                10
        ";
        
        $clientsCommandesResults = $connection->fetchAllAssociative($clientsCommandesSql);

        // Requête SQL pour récupérer le chiffre d'affaires par type de client pour l'année 2024
        $typeClientChiffreAffairesSql = "
            SELECT 
                cl.type_client,
                SUM(c.montant_tot) AS Chiffre_d_affaires
            FROM 
                client cl
            INNER JOIN 
                commande c ON cl.id = c.client_id
            WHERE 
                YEAR(c.date_debut_commande) = '2024'
            GROUP BY 
                cl.type_client
        ";
        
        $typeClientChiffreAffairesResults = $connection->fetchAllAssociative($typeClientChiffreAffairesSql);

        // Requête SQL pour récupérer le nombre de commandes en cours de livraison pour l'année 2024
            $commandesEnCoursSql = "
            SELECT 
                COUNT(*) AS Nombre_commandes_en_cours_de_livraison
            FROM 
                commande c
            LEFT JOIN 
                livraison l ON c.id = l.commande_id
            WHERE 
                l.date_reception IS NULL
                AND YEAR(c.date_debut_commande) = '2024'
        ";
        
        $commandesEnCoursResults = $connection->fetchAssociative($commandesEnCoursSql);

        return $this->render('Role/performance.html.twig', [
            'chiffreAffairesResults' => $chiffreAffairesResults,
            'produitsCommandesResults' => $produitsCommandesResults,
            'produitsMargeResults' => $produitsMargeResults,
            'clientsCommandesResults' => $clientsCommandesResults,
            'typeClientChiffreAffairesResults' => $typeClientChiffreAffairesResults,
            'commandesEnCoursResults' => $commandesEnCoursResults,
        ]);
    }
}
