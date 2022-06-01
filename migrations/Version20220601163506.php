<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601163506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP INDEX UNIQ_5A8A6C8DA76ED395, ADD INDEX IDX_5A8A6C8DA76ED395 (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494B89032C');
        $this->addSql('DROP INDEX UNIQ_8D93D6494B89032C ON user');
        $this->addSql('ALTER TABLE user DROP post_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP INDEX IDX_5A8A6C8DA76ED395, ADD UNIQUE INDEX UNIQ_5A8A6C8DA76ED395 (user_id)');
        $this->addSql('ALTER TABLE user ADD post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6494B89032C ON user (post_id)');
    }
}
