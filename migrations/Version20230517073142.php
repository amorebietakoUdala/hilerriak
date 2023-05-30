<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517073142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historic_movements ADD cementerio_id INT DEFAULT NULL, DROP cementerio');
        $this->addSql('ALTER TABLE historic_movements ADD CONSTRAINT FK_15452A1CED8A1B9E FOREIGN KEY (cementerio_id) REFERENCES cemetery (id)');
        $this->addSql('CREATE INDEX IDX_15452A1CED8A1B9E ON historic_movements (cementerio_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historic_movements DROP FOREIGN KEY FK_15452A1CED8A1B9E');
        $this->addSql('DROP INDEX IDX_15452A1CED8A1B9E ON historic_movements');
        $this->addSql('ALTER TABLE historic_movements ADD cementerio INT NOT NULL, DROP cementerio_id');
    }
}
