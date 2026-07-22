<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260504114805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE breathing_exercise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, inhale_duration VARCHAR(255) NOT NULL, hold_duration VARCHAR(255) NOT NULL, exhale_duration VARCHAR(255) NOT NULL, is_active TINYINT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE breathing_session (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, duration INT NOT NULL, user_id INT NOT NULL, exercise_id INT NOT NULL, INDEX IDX_1F13A20EA76ED395 (user_id), INDEX IDX_1F13A20EE934951A (exercise_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE information (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, is_active TINYINT NOT NULL, created_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_29791883A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE breathing_session ADD CONSTRAINT FK_1F13A20EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE breathing_session ADD CONSTRAINT FK_1F13A20EE934951A FOREIGN KEY (exercise_id) REFERENCES breathing_exercise (id)');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_29791883A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE breathing_session DROP FOREIGN KEY FK_1F13A20EA76ED395');
        $this->addSql('ALTER TABLE breathing_session DROP FOREIGN KEY FK_1F13A20EE934951A');
        $this->addSql('ALTER TABLE information DROP FOREIGN KEY FK_29791883A76ED395');
        $this->addSql('DROP TABLE breathing_exercise');
        $this->addSql('DROP TABLE breathing_session');
        $this->addSql('DROP TABLE information');
    }
}
