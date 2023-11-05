<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231104235214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX UNIQ_606D487CE7927C74 ON collaborator');
        $this->addSql('ALTER TABLE collaborator DROP first_name, DROP lastname, DROP email, DROP roles, DROP password, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE collaborator ADD CONSTRAINT FK_606D487CBF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_312B3E16E7927C74 ON partner');
        $this->addSql('ALTER TABLE partner DROP first_name, DROP lastname, DROP email, DROP roles, DROP password, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE partner ADD CONSTRAINT FK_312B3E16BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collaborator DROP FOREIGN KEY FK_606D487CBF396750');
        $this->addSql('ALTER TABLE partner DROP FOREIGN KEY FK_312B3E16BF396750');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE partner ADD first_name VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_312B3E16E7927C74 ON partner (email)');
        $this->addSql('ALTER TABLE collaborator ADD first_name VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_606D487CE7927C74 ON collaborator (email)');
    }
}
