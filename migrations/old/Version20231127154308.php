<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127154308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C3256915B');
        $this->addSql('DROP INDEX IDX_FDCA8C9CCF11D9C ON cours');
        $this->addSql('ALTER TABLE cours CHANGE instrument_id type_instruments_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C4807BAC3 FOREIGN KEY (type_instruments_id) REFERENCES type_instrument (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C4807BAC3 ON cours (type_instruments_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C4807BAC3');
        $this->addSql('DROP INDEX IDX_FDCA8C9C4807BAC3 ON cours');
        $this->addSql('ALTER TABLE cours CHANGE type_instruments_id instrument_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C3256915B FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CCF11D9C ON cours (instrument_id)');
    }
}
