<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117135618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lamp ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lamp ADD CONSTRAINT FK_99F75266A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_99F75266A76ED395 ON lamp (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lamp DROP FOREIGN KEY FK_99F75266A76ED395');
        $this->addSql('DROP INDEX IDX_99F75266A76ED395 ON lamp');
        $this->addSql('ALTER TABLE lamp DROP user_id');
    }
}
