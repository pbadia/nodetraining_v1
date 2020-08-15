<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200814184558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE quiz_question_answer');
        $this->addSql('ALTER TABLE quiz_question ADD answer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00BAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
        $this->addSql('CREATE INDEX IDX_6033B00BAA334807 ON quiz_question (answer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_question_answer (quiz_question_id INT NOT NULL, answer_id INT NOT NULL, INDEX IDX_E684DF7C3101E51F (quiz_question_id), INDEX IDX_E684DF7CAA334807 (answer_id), PRIMARY KEY(quiz_question_id, answer_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quiz_question_answer ADD CONSTRAINT FK_E684DF7C3101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_question_answer ADD CONSTRAINT FK_E684DF7CAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_question DROP FOREIGN KEY FK_6033B00BAA334807');
        $this->addSql('DROP INDEX IDX_6033B00BAA334807 ON quiz_question');
        $this->addSql('ALTER TABLE quiz_question DROP answer_id');
    }
}
