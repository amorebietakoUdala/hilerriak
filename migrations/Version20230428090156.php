<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428090156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE movement (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, source_id INT DEFAULT NULL, destination_id INT DEFAULT NULL, expedient_number VARCHAR(255) DEFAULT NULL, registration_number INT DEFAULT NULL, year INT NOT NULL, defunct VARCHAR(255) DEFAULT NULL, note VARCHAR(1024) DEFAULT NULL, finalized TINYINT(1) DEFAULT NULL, decease_date DATE DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F4DD95F7C54C8C93 (type_id), INDEX IDX_F4DD95F7953C1C61 (source_id), INDEX IDX_F4DD95F7816C6140 (destination_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7C54C8C93 FOREIGN KEY (type_id) REFERENCES movement_type (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7953C1C61 FOREIGN KEY (source_id) REFERENCES grave (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7816C6140 FOREIGN KEY (destination_id) REFERENCES grave (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE movement');
    }
}
