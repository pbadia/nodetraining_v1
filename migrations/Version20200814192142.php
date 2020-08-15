<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200814192142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ADD accuracy INT DEFAULT 0 NOT NULL, DROP is_correct');
        $this->addSql('ALTER TABLE quiz_question DROP result');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ADD is_correct TINYINT(1) DEFAULT \'0\' NOT NULL, DROP accuracy');
        $this->addSql('ALTER TABLE quiz_question ADD result INT DEFAULT 0 NOT NULL');
    }
}
