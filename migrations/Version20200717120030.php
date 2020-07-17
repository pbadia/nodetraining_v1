<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200717120030 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer CHANGE is_correct is_correct TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD is_running TINYINT(1) DEFAULT \'1\' NOT NULL, DROP state');
        $this->addSql('ALTER TABLE user CHANGE role role INT DEFAULT 1 NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer CHANGE is_correct is_correct TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD state VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP is_running');
        $this->addSql('ALTER TABLE user CHANGE role role INT NOT NULL');
    }
}
