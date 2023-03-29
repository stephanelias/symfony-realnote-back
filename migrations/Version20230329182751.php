<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329182751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal_project ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personal_project ADD CONSTRAINT FK_AC94D9C5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AC94D9C5A76ED395 ON personal_project (user_id)');
        $this->addSql('ALTER TABLE user ADD spotify_token VARCHAR(255) DEFAULT NULL, ADD spotify_client_id VARCHAR(255) DEFAULT NULL, ADD spotify_client_secret VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personal_project DROP FOREIGN KEY FK_AC94D9C5A76ED395');
        $this->addSql('DROP INDEX IDX_AC94D9C5A76ED395 ON personal_project');
        $this->addSql('ALTER TABLE personal_project DROP user_id');
        $this->addSql('ALTER TABLE user DROP spotify_token, DROP spotify_client_id, DROP spotify_client_secret');
    }
}
