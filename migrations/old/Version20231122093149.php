<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231122093149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contratPret (id INT AUTO_INCREMENT NOT NULL, eleve_id INT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, attestation_assurance VARCHAR(255) DEFAULT NULL, etat_detaille_debut VARCHAR(255) DEFAULT NULL, etat_detaille_retour VARCHAR(255) DEFAULT NULL, INDEX IDX_1FB84C67A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contratPret ADD CONSTRAINT FK_1FB84C67A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contratPret DROP FOREIGN KEY FK_1FB84C67A6CC7B2');
        $this->addSql('DROP TABLE contratPret');
    }
}
