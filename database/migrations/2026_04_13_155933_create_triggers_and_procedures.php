<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Trigger before_insert_produit
        DB::unprepared("
            CREATE TRIGGER before_insert_produit 
            BEFORE INSERT ON produits
            FOR EACH ROW 
            BEGIN
                IF NEW.stock < 0 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock invalide';
                END IF;
            END
        ");

        // 2. Trigger before_insert_ligne_commande
        DB::unprepared("
            CREATE TRIGGER before_insert_ligne_commande 
            BEFORE INSERT ON ligne_commandes
            FOR EACH ROW 
            BEGIN
                DECLARE current_stock INT;
                SELECT stock INTO current_stock FROM produits WHERE id = NEW.produit_id;
                IF current_stock < NEW.quantite THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock insuffisant pour ce produit';
                ELSE
                    UPDATE produits SET stock = stock - NEW.quantite WHERE id = NEW.produit_id;
                END IF;
            END
        ");

        // 3. Trigger after_insert_ligne_commande
        DB::unprepared("
            CREATE TRIGGER after_insert_ligne_commande 
            AFTER INSERT ON ligne_commandes
            FOR EACH ROW 
            BEGIN
                DECLARE v_prix DECIMAL(10,2);
                SELECT prix INTO v_prix FROM produits WHERE id = NEW.produit_id;
                UPDATE ligne_commandes SET sous_total = NEW.quantite * v_prix WHERE id = NEW.id;
                UPDATE commandes SET total = (SELECT COALESCE(SUM(sous_total), 0) FROM ligne_commandes WHERE commande_id = NEW.commande_id) WHERE id = NEW.commande_id;
            END
        ");

        // 4. Trigger after_delete_ligne_commande
        DB::unprepared("
            CREATE TRIGGER after_delete_ligne_commande 
            AFTER DELETE ON ligne_commandes
            FOR EACH ROW 
            BEGIN
                UPDATE produits SET stock = stock + OLD.quantite WHERE id = OLD.produit_id;
                UPDATE commandes SET total = (SELECT COALESCE(SUM(sous_total), 0) FROM ligne_commandes WHERE commande_id = OLD.commande_id) WHERE id = OLD.commande_id;
            END
        ");

        // 5. Trigger after_update_ligne_commande
        DB::unprepared("
            CREATE TRIGGER after_update_ligne_commande 
            AFTER UPDATE ON ligne_commandes
            FOR EACH ROW 
            BEGIN
                DECLARE stock_diff INT;
                DECLARE v_prix DECIMAL(10,2);
                SET stock_diff = NEW.quantite - OLD.quantite;
                UPDATE produits SET stock = stock - stock_diff WHERE id = NEW.produit_id;
                SELECT prix INTO v_prix FROM produits WHERE id = NEW.produit_id;
                UPDATE ligne_commandes SET sous_total = NEW.quantite * v_prix WHERE id = NEW.id;
                UPDATE commandes SET total = (SELECT COALESCE(SUM(sous_total), 0) FROM ligne_commandes WHERE commande_id = NEW.commande_id) WHERE id = NEW.commande_id;
            END
        ");

        // 1. Stored Procedure creer_commande
        DB::unprepared("
            CREATE PROCEDURE creer_commande(IN p_user_id INT)
            BEGIN
                INSERT INTO commandes (user_id, date_commande, statut, total, created_at, updated_at) 
                VALUES (p_user_id, CURDATE(), 'en_attente', 0, NOW(), NOW());
                SELECT LAST_INSERT_ID() as commande_id;
            END
        ");

        // 2. Stored Procedure ajouter_produit_commande
        DB::unprepared("
            CREATE PROCEDURE ajouter_produit_commande(IN p_commande_id INT, IN p_produit_id INT, IN p_quantite INT)
            BEGIN
                INSERT INTO ligne_commandes (commande_id, produit_id, quantite, created_at, updated_at) 
                VALUES (p_commande_id, p_produit_id, p_quantite, NOW(), NOW());
            END
        ");

        // 3. Stored Procedure get_rapport_ventes
        DB::unprepared("
            CREATE PROCEDURE get_rapport_ventes()
            BEGIN
                SELECT p.nom_produit, SUM(lc.quantite) as total_vendu, SUM(lc.sous_total) as chiffre_affaires
                FROM ligne_commandes lc
                JOIN produits p ON lc.produit_id = p.id
                GROUP BY lc.produit_id, p.nom_produit
                ORDER BY total_vendu DESC;
            END
        ");

        // 4. Stored Procedure get_stock_faible
        DB::unprepared("
            CREATE PROCEDURE get_stock_faible(IN p_seuil INT)
            BEGIN
                SELECT * FROM produits WHERE stock <= p_seuil ORDER BY stock ASC;
            END
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS before_insert_produit");
        DB::unprepared("DROP TRIGGER IF EXISTS before_insert_ligne_commande");
        DB::unprepared("DROP TRIGGER IF EXISTS after_insert_ligne_commande");
        DB::unprepared("DROP TRIGGER IF EXISTS after_delete_ligne_commande");
        DB::unprepared("DROP TRIGGER IF EXISTS after_update_ligne_commande");
        DB::unprepared("DROP PROCEDURE IF EXISTS creer_commande");
        DB::unprepared("DROP PROCEDURE IF EXISTS ajouter_produit_commande");
        DB::unprepared("DROP PROCEDURE IF EXISTS get_rapport_ventes");
        DB::unprepared("DROP PROCEDURE IF EXISTS get_stock_faible");
    }
};
