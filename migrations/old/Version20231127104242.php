<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127104242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat_pret (id INT AUTO_INCREMENT NOT NULL, eleve_id INT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, attestation_assurance VARCHAR(255) DEFAULT NULL, etat_detaille_debut VARCHAR(255) DEFAULT NULL, etat_detaille_retour VARCHAR(255) DEFAULT NULL, INDEX IDX_1FB84C67A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, type_cours_id INT DEFAULT NULL, jours_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, libelle VARCHAR(200) NOT NULL, age_mini VARCHAR(20) NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, nb_places INT NOT NULL, age_maxi VARCHAR(20) NOT NULL, INDEX IDX_FDCA8C9CB3305F4C (type_cours_id), INDEX IDX_FDCA8C9C6180639B (jours_id), INDEX IDX_FDCA8C9CBAB22EE9 (professeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, num_rue VARCHAR(20) NOT NULL, rue VARCHAR(50) NOT NULL, copos VARCHAR(10) NOT NULL, ville VARCHAR(30) NOT NULL, tel VARCHAR(20) NOT NULL, mail VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve_responsable (eleve_id INT NOT NULL, responsable_id INT NOT NULL, INDEX IDX_D7350730A6CC7B2 (eleve_id), INDEX IDX_D735073053C59D72 (responsable_id), PRIMARY KEY(eleve_id, responsable_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, cours_id INT DEFAULT NULL, eleve_id INT DEFAULT NULL, date_inscription DATE NOT NULL, INDEX IDX_5E90F6D67ECF78B0 (cours_id), INDEX IDX_5E90F6D6A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jours (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, num_rue VARCHAR(10) NOT NULL, rue VARCHAR(50) NOT NULL, copos VARCHAR(20) NOT NULL, ville VARCHAR(30) NOT NULL, tel VARCHAR(20) NOT NULL, mail VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, num_rue INT DEFAULT NULL, rue VARCHAR(255) DEFAULT NULL, tel INT DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_cours (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat_pret ADD CONSTRAINT FK_1FB84C67A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CB3305F4C FOREIGN KEY (type_cours_id) REFERENCES type_cours (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C6180639B FOREIGN KEY (jours_id) REFERENCES jours (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE eleve_responsable ADD CONSTRAINT FK_D7350730A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve_responsable ADD CONSTRAINT FK_D735073053C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D67ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat_pret DROP FOREIGN KEY FK_1FB84C67A6CC7B2');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CB3305F4C');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C6180639B');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CBAB22EE9');
        $this->addSql('ALTER TABLE eleve_responsable DROP FOREIGN KEY FK_D7350730A6CC7B2');
        $this->addSql('ALTER TABLE eleve_responsable DROP FOREIGN KEY FK_D735073053C59D72');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D67ECF78B0');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6A6CC7B2');
        $this->addSql('DROP TABLE contrat_pret');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE eleve_responsable');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE jours');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE type_cours');
    }
}
