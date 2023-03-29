<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321140459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, photo_link VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personal_project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL, artists LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', note VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, cover_link VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, release_date DATE NOT NULL, INDEX IDX_2FB3D0EE12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_artist (project_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_16FD7DCD166D1F9C (project_id), INDEX IDX_16FD7DCDB7970CF8 (artist_id), PRIMARY KEY(project_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ranked_title (id INT AUTO_INCREMENT NOT NULL, personal_project_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lyrics_rank VARCHAR(255) NOT NULL, beat_rank VARCHAR(255) NOT NULL, flow_rank VARCHAR(255) NOT NULL, feats_rank VARCHAR(255) NOT NULL, feats LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_C4D8483B56BDB83C (personal_project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE title (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, lyrics LONGTEXT DEFAULT NULL, interpreters LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_2B36786B166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE title_artist (title_id INT NOT NULL, artist_id INT NOT NULL, INDEX IDX_CFF883AEA9F87BD (title_id), INDEX IDX_CFF883AEB7970CF8 (artist_id), PRIMARY KEY(title_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE project_artist ADD CONSTRAINT FK_16FD7DCD166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_artist ADD CONSTRAINT FK_16FD7DCDB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ranked_title ADD CONSTRAINT FK_C4D8483B56BDB83C FOREIGN KEY (personal_project_id) REFERENCES personal_project (id)');
        $this->addSql('ALTER TABLE title ADD CONSTRAINT FK_2B36786B166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE title_artist ADD CONSTRAINT FK_CFF883AEA9F87BD FOREIGN KEY (title_id) REFERENCES title (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE title_artist ADD CONSTRAINT FK_CFF883AEB7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE12469DE2');
        $this->addSql('ALTER TABLE project_artist DROP FOREIGN KEY FK_16FD7DCD166D1F9C');
        $this->addSql('ALTER TABLE project_artist DROP FOREIGN KEY FK_16FD7DCDB7970CF8');
        $this->addSql('ALTER TABLE ranked_title DROP FOREIGN KEY FK_C4D8483B56BDB83C');
        $this->addSql('ALTER TABLE title DROP FOREIGN KEY FK_2B36786B166D1F9C');
        $this->addSql('ALTER TABLE title_artist DROP FOREIGN KEY FK_CFF883AEA9F87BD');
        $this->addSql('ALTER TABLE title_artist DROP FOREIGN KEY FK_CFF883AEB7970CF8');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE personal_project');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_artist');
        $this->addSql('DROP TABLE ranked_title');
        $this->addSql('DROP TABLE title');
        $this->addSql('DROP TABLE title_artist');
    }
}
