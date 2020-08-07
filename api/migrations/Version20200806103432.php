<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200806103432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE file_downloads_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE file_files_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE file_downloads (id INT NOT NULL, file_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, ip VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C57C1BC393CB796C ON file_downloads (file_id)');
        $this->addSql('CREATE INDEX IDX_C57C1BC3AA9E377A ON file_downloads (date)');
        $this->addSql('COMMENT ON COLUMN file_downloads.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE file_files (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, info_path VARCHAR(255) NOT NULL, info_name VARCHAR(255) NOT NULL, info_size INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ACB6F06EAA9E377A ON file_files (date)');
        $this->addSql('COMMENT ON COLUMN file_files.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE file_downloads ADD CONSTRAINT FK_C57C1BC393CB796C FOREIGN KEY (file_id) REFERENCES file_files (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE file_downloads DROP CONSTRAINT FK_C57C1BC393CB796C');
        $this->addSql('DROP SEQUENCE file_downloads_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE file_files_id_seq CASCADE');
        $this->addSql('DROP TABLE file_downloads');
        $this->addSql('DROP TABLE file_files');
    }
}
