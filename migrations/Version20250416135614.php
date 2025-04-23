<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416135614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE symfony_demo_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL, post_id INTEGER NOT NULL, author_id INTEGER NOT NULL, CONSTRAINT FK_53AD8F834B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_53AD8F83F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE symfony_demo_post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content CLOB NOT NULL, published_at DATETIME NOT NULL, author_id INTEGER NOT NULL, CONSTRAINT FK_58A92E65F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE symfony_demo_post_tag (post_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(post_id, tag_id), CONSTRAINT FK_6ABC1CC44B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6ABC1CC4BAD26311 FOREIGN KEY (tag_id) REFERENCES symfony_demo_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE symfony_demo_tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_4D5855405E237E06 ON symfony_demo_tag (name)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE symfony_demo_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE symfony_demo_comment
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE symfony_demo_post
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE symfony_demo_post_tag
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE symfony_demo_tag
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE symfony_demo_user
        SQL);
    }
}
