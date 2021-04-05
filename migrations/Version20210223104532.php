<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223104532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD headline VARCHAR(255) NOT NULL, ADD subheadline VARCHAR(255) NOT NULL, ADD article_content VARCHAR(25500) DEFAULT NULL, DROP title, DROP resume_article, DROP contenu_article, CHANGE date_creation created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE nom_categorie name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE commentaire CHANGE contenu content VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE contact ADD lastname VARCHAR(255) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, DROP nom_contact, DROP prenom_contact');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD resume_article VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD contenu_article MEDIUMTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP headline, DROP subheadline, DROP article_content, CHANGE created_at date_creation DATETIME NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE name nom_categorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE commentaire CHANGE content contenu VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE contact ADD nom_contact VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD prenom_contact VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP lastname, DROP firstname');
    }
}
