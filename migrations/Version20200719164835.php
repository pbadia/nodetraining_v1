<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200719164835 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question_theme (question_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_A79EF60C1E27F6BF (question_id), INDEX IDX_A79EF60C59027487 (theme_id), PRIMARY KEY(question_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE question_theme ADD CONSTRAINT FK_A79EF60C1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question_theme ADD CONSTRAINT FK_A79EF60C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E59027487');
        $this->addSql('DROP INDEX IDX_B6F7494E59027487 ON question');
        $this->addSql('ALTER TABLE question DROP theme_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE question_theme');
        $this->addSql('ALTER TABLE question ADD theme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6F7494E59027487 ON question (theme_id)');
    }
}
