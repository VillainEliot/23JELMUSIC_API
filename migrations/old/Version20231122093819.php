<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122093819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contratPret (id INT AUTO_INCREMENT NOT NULL, eleve_id INT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, attestation_assurance VARCHAR(255) DEFAULT NULL, etat_detaille_debut VARCHAR(255) DEFAULT NULL, etat_detaille_retour VARCHAR(255) DEFAULT NULL, INDEX IDX_1FB84C67A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve_responsable (eleve_id INT NOT NULL, responsable_id INT NOT NULL, INDEX IDX_D7350730A6CC7B2 (eleve_id), INDEX IDX_D735073053C59D72 (responsable_id), PRIMARY KEY(eleve_id, responsable_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, num_rue INT DEFAULT NULL, rue VARCHAR(255) DEFAULT NULL, tel INT DEFAULT NULL, mail VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contratPret ADD CONSTRAINT FK_1FB84C67A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE eleve_responsable ADD CONSTRAINT FK_D7350730A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve_responsable ADD CONSTRAINT FK_D735073053C59D72 FOREIGN KEY (responsable_id) REFERENCES responsable (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contratPret DROP FOREIGN KEY FK_1FB84C67A6CC7B2');
        $this->addSql('ALTER TABLE eleve_responsable DROP FOREIGN KEY FK_D7350730A6CC7B2');
        $this->addSql('ALTER TABLE eleve_responsable DROP FOREIGN KEY FK_D735073053C59D72');
        $this->addSql('DROP TABLE contratPret');
        $this->addSql('DROP TABLE eleve_responsable');
        $this->addSql('DROP TABLE responsable');
    }
}
