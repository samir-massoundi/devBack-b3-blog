<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210416155258 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE article_content article_content VARCHAR(25500) DEFAULT NULL');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D7294869C');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7DA76ED395');
        $this->addSql('DROP INDEX IDX_49CA4E7D7294869C ON likes');
        $this->addSql('DROP INDEX IDX_49CA4E7DA76ED395 ON likes');
        $this->addSql('ALTER TABLE likes DROP user_id, DROP article_id');
        $this->addSql('ALTER TABLE shares DROP FOREIGN KEY FK_905F717C1EBAF6CC');
        $this->addSql('ALTER TABLE shares DROP FOREIGN KEY FK_905F717CA76ED395');
        $this->addSql('DROP INDEX IDX_905F717CA76ED395 ON shares');
        $this->addSql('DROP INDEX IDX_905F717C1EBAF6CC ON shares');
        $this->addSql('ALTER TABLE shares DROP articles_id, DROP user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article CHANGE article_content article_content MEDIUMTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE likes ADD user_id INT NOT NULL, ADD article_id INT NOT NULL');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7D7294869C ON likes (article_id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7DA76ED395 ON likes (user_id)');
        $this->addSql('ALTER TABLE shares ADD articles_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE shares ADD CONSTRAINT FK_905F717C1EBAF6CC FOREIGN KEY (articles_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE shares ADD CONSTRAINT FK_905F717CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_905F717CA76ED395 ON shares (user_id)');
        $this->addSql('CREATE INDEX IDX_905F717C1EBAF6CC ON shares (articles_id)');
    }
}
