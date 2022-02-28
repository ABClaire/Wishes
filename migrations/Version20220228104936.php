<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228104936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish ADD categorie_id INT NOT NULL, DROP categorie');
        $this->addSql('ALTER TABLE wish ADD CONSTRAINT FK_D7D174C9BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_D7D174C9BCF5E72D ON wish (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie CHANGE libelle libelle VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE wish DROP FOREIGN KEY FK_D7D174C9BCF5E72D');
        $this->addSql('DROP INDEX IDX_D7D174C9BCF5E72D ON wish');
        $this->addSql('ALTER TABLE wish ADD categorie VARCHAR(255) DEFAULT \'Realistic\' NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP categorie_id, CHANGE title title VARCHAR(250) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE author author VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
