<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230419101607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE grave (id INT AUTO_INCREMENT NOT NULL, cementery_id INT DEFAULT NULL, type_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, years INT DEFAULT NULL, expedient_creation_year INT DEFAULT NULL, registration_number INT DEFAULT NULL, free TINYINT(1) DEFAULT NULL, INDEX IDX_21AEDEE7BE2D9105 (cementery_id), INDEX IDX_21AEDEE7C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grave ADD CONSTRAINT FK_21AEDEE7BE2D9105 FOREIGN KEY (cementery_id) REFERENCES cemetery (id)');
        $this->addSql('ALTER TABLE grave ADD CONSTRAINT FK_21AEDEE7C54C8C93 FOREIGN KEY (type_id) REFERENCES grave_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE grave');
    }
}
