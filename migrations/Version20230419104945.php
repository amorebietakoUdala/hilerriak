<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230419104945 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grave DROP FOREIGN KEY FK_21AEDEE7BE2D9105');
        $this->addSql('DROP INDEX IDX_21AEDEE7BE2D9105 ON grave');
        $this->addSql('ALTER TABLE grave CHANGE cementery_id cemetery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grave ADD CONSTRAINT FK_21AEDEE7EC636C87 FOREIGN KEY (cemetery_id) REFERENCES cemetery (id)');
        $this->addSql('CREATE INDEX IDX_21AEDEE7EC636C87 ON grave (cemetery_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE grave DROP FOREIGN KEY FK_21AEDEE7EC636C87');
        $this->addSql('DROP INDEX IDX_21AEDEE7EC636C87 ON grave');
        $this->addSql('ALTER TABLE grave CHANGE cemetery_id cementery_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE grave ADD CONSTRAINT FK_21AEDEE7BE2D9105 FOREIGN KEY (cementery_id) REFERENCES cemetery (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_21AEDEE7BE2D9105 ON grave (cementery_id)');
    }
}
