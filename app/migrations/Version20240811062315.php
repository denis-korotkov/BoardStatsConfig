<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240811062315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE field (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, payload JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE field_game (field_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_30E75836443707B0 (field_id), INDEX IDX_30E75836E48FD905 (game_id), PRIMARY KEY(field_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE result (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, value JSON NOT NULL, INDEX IDX_136AC113E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE field_game ADD CONSTRAINT FK_30E75836443707B0 FOREIGN KEY (field_id) REFERENCES field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE field_game ADD CONSTRAINT FK_30E75836E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE result ADD CONSTRAINT FK_136AC113E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE field_game DROP FOREIGN KEY FK_30E75836443707B0');
        $this->addSql('ALTER TABLE field_game DROP FOREIGN KEY FK_30E75836E48FD905');
        $this->addSql('ALTER TABLE result DROP FOREIGN KEY FK_136AC113E48FD905');
        $this->addSql('DROP TABLE field');
        $this->addSql('DROP TABLE field_game');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE result');
    }
}
