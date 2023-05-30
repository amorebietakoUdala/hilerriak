<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529065425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movement ADD petitioner_id INT NOT NULL');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F74277D8B2 FOREIGN KEY (petitioner_id) REFERENCES petitioner (id)');
        $this->addSql('CREATE INDEX IDX_F4DD95F74277D8B2 ON movement (petitioner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F74277D8B2');
        $this->addSql('DROP INDEX IDX_F4DD95F74277D8B2 ON movement');
        $this->addSql('ALTER TABLE movement DROP petitioner_id');
    }
}
