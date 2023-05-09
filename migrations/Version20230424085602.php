<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424085602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adjudication ADD grave_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE adjudication ADD CONSTRAINT FK_DF5769BCE439654A FOREIGN KEY (grave_id) REFERENCES grave (id)');
        $this->addSql('CREATE INDEX IDX_DF5769BCE439654A ON adjudication (grave_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE adjudication DROP FOREIGN KEY FK_DF5769BCE439654A');
        $this->addSql('DROP INDEX IDX_DF5769BCE439654A ON adjudication');
        $this->addSql('ALTER TABLE adjudication DROP grave_id, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
