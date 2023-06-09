<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609053252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adjudication (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, grave_id INT DEFAULT NULL, adjudication_year SMALLINT DEFAULT NULL, expiry_year SMALLINT DEFAULT NULL, note VARCHAR(1024) DEFAULT NULL, registration_number INT DEFAULT NULL, created_at DATETIME, updated_at DATETIME, INDEX IDX_DF5769BC7E3C61F9 (owner_id), INDEX IDX_DF5769BCE439654A (grave_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cemetery (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE destination_type (id INT AUTO_INCREMENT NOT NULL, description_es VARCHAR(255) NOT NULL, description_eu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grave (id INT AUTO_INCREMENT NOT NULL, cemetery_id INT DEFAULT NULL, type_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, years INT DEFAULT NULL, free TINYINT(1) DEFAULT NULL, side VARCHAR(2) DEFAULT NULL, zone_or_row INT DEFAULT NULL, number VARCHAR(5) DEFAULT NULL, capacity SMALLINT DEFAULT NULL, occupation SMALLINT DEFAULT NULL, INDEX IDX_21AEDEE7EC636C87 (cemetery_id), INDEX IDX_21AEDEE7C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grave_type (id INT AUTO_INCREMENT NOT NULL, description_es VARCHAR(255) NOT NULL, description_eu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, source_id INT DEFAULT NULL, destination_type_id INT DEFAULT NULL, destination_id INT DEFAULT NULL, petitioner_id INT DEFAULT NULL, registration_number INT DEFAULT NULL, year INT DEFAULT NULL, defunct_name VARCHAR(255) DEFAULT NULL, defunct_surname1 VARCHAR(255) DEFAULT NULL, defunct_surname2 VARCHAR(255) DEFAULT NULL, defunct_fullname VARCHAR(255) DEFAULT NULL, note VARCHAR(1024) DEFAULT NULL, finalized TINYINT(1) DEFAULT NULL, decease_date DATE DEFAULT NULL, movement_end_date DATE DEFAULT NULL, wants_to_be_present TINYINT(1) DEFAULT NULL, relationship VARCHAR(255) DEFAULT NULL, created_at DATETIME, updated_at DATETIME, INDEX IDX_F4DD95F7C54C8C93 (type_id), INDEX IDX_F4DD95F7953C1C61 (source_id), INDEX IDX_F4DD95F7AB75B3EB (destination_type_id), INDEX IDX_F4DD95F7816C6140 (destination_id), INDEX IDX_F4DD95F74277D8B2 (petitioner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movement_type (id INT AUTO_INCREMENT NOT NULL, description_es VARCHAR(255) NOT NULL, description_eu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner (id INT AUTO_INCREMENT NOT NULL, dni VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, surname1 VARCHAR(255) DEFAULT NULL, surname2 VARCHAR(255) DEFAULT NULL, fullname VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE petitioner (id INT AUTO_INCREMENT NOT NULL, dni VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, surname1 VARCHAR(255) DEFAULT NULL, surname2 VARCHAR(255) DEFAULT NULL, fullname VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, activated TINYINT(1) DEFAULT \'1\', last_login DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adjudication ADD CONSTRAINT FK_DF5769BC7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id)');
        $this->addSql('ALTER TABLE adjudication ADD CONSTRAINT FK_DF5769BCE439654A FOREIGN KEY (grave_id) REFERENCES grave (id)');
        $this->addSql('ALTER TABLE grave ADD CONSTRAINT FK_21AEDEE7EC636C87 FOREIGN KEY (cemetery_id) REFERENCES cemetery (id)');
        $this->addSql('ALTER TABLE grave ADD CONSTRAINT FK_21AEDEE7C54C8C93 FOREIGN KEY (type_id) REFERENCES grave_type (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7C54C8C93 FOREIGN KEY (type_id) REFERENCES movement_type (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7953C1C61 FOREIGN KEY (source_id) REFERENCES grave (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7AB75B3EB FOREIGN KEY (destination_type_id) REFERENCES destination_type (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F7816C6140 FOREIGN KEY (destination_id) REFERENCES grave (id)');
        $this->addSql('ALTER TABLE movement ADD CONSTRAINT FK_F4DD95F74277D8B2 FOREIGN KEY (petitioner_id) REFERENCES petitioner (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grave DROP FOREIGN KEY FK_21AEDEE7EC636C87');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7AB75B3EB');
        $this->addSql('ALTER TABLE adjudication DROP FOREIGN KEY FK_DF5769BCE439654A');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7953C1C61');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7816C6140');
        $this->addSql('ALTER TABLE grave DROP FOREIGN KEY FK_21AEDEE7C54C8C93');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F7C54C8C93');
        $this->addSql('ALTER TABLE adjudication DROP FOREIGN KEY FK_DF5769BC7E3C61F9');
        $this->addSql('ALTER TABLE movement DROP FOREIGN KEY FK_F4DD95F74277D8B2');
        $this->addSql('DROP TABLE adjudication');
        $this->addSql('DROP TABLE cemetery');
        $this->addSql('DROP TABLE destination_type');
        $this->addSql('DROP TABLE grave');
        $this->addSql('DROP TABLE grave_type');
        $this->addSql('DROP TABLE movement');
        $this->addSql('DROP TABLE movement_type');
        $this->addSql('DROP TABLE owner');
        $this->addSql('DROP TABLE petitioner');
        $this->addSql('DROP TABLE user');
    }
}
