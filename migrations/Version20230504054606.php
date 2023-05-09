<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230504054606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movement ADD destination_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7AB75B3EB FOREIGN KEY (destination_type_id) REFERENCES destination_type (id)');
        $this->addSql('CREATE INDEX IDX_F4DD95F7AB75B3EB ON movement (destination_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7AB75B3EB');
        $this->addSql('DROP INDEX IDX_F4DD95F7AB75B3EB ON movement');
        $this->addSql('ALTER TABLE movement DROP destination_type_id');
    }
}
