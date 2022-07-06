<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706072851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agents (id INT AUTO_INCREMENT NOT NULL, lastName VARCHAR(30) NOT NULL, firstName VARCHAR(30) NOT NULL, birthday_date DATE NOT NULL, code INT NOT NULL, nationality VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agents_missions (agents_id INT NOT NULL, missions_id INT NOT NULL, INDEX IDX_B804F404709770DC (agents_id), INDEX IDX_B804F40417C042CF (missions_id), PRIMARY KEY(agents_id, missions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agents_skills (agents_id INT NOT NULL, skills_id INT NOT NULL, INDEX IDX_5088E440709770DC (agents_id), INDEX IDX_5088E4407FF61858 (skills_id), PRIMARY KEY(agents_id, skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contacts (id INT AUTO_INCREMENT NOT NULL, lastName VARCHAR(30) NOT NULL, firstName VARCHAR(30) NOT NULL, birthday_date DATE NOT NULL, namecode VARCHAR(30) NOT NULL, nationality VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hideout (id INT AUTO_INCREMENT NOT NULL, code INT NOT NULL, adress VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, type VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions (id INT AUTO_INCREMENT NOT NULL, skills_id INT DEFAULT NULL, hideout_id INT DEFAULT NULL, title VARCHAR(30) NOT NULL, description LONGTEXT NOT NULL, namecode VARCHAR(30) NOT NULL, country VARCHAR(50) NOT NULL, type VARCHAR(30) NOT NULL, status VARCHAR(30) NOT NULL, created_at DATE NOT NULL, closed_at DATE NOT NULL, INDEX IDX_34F1D47E7FF61858 (skills_id), INDEX IDX_34F1D47EE9982FD7 (hideout_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions_contacts (missions_id INT NOT NULL, contacts_id INT NOT NULL, INDEX IDX_FA54446417C042CF (missions_id), INDEX IDX_FA544464719FB48E (contacts_id), PRIMARY KEY(missions_id, contacts_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE missions_targets (missions_id INT NOT NULL, targets_id INT NOT NULL, INDEX IDX_B7328F6017C042CF (missions_id), INDEX IDX_B7328F6043B5F743 (targets_id), PRIMARY KEY(missions_id, targets_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skills (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE targets (id INT AUTO_INCREMENT NOT NULL, lastName VARCHAR(30) NOT NULL, firstName VARCHAR(30) NOT NULL, birthday_date DATE NOT NULL, namecode VARCHAR(30) NOT NULL, nationality VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastName VARCHAR(30) NOT NULL, firstName VARCHAR(30) NOT NULL, created_at DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agents_missions ADD CONSTRAINT FK_B804F404709770DC FOREIGN KEY (agents_id) REFERENCES agents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_missions ADD CONSTRAINT FK_B804F40417C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_skills ADD CONSTRAINT FK_5088E440709770DC FOREIGN KEY (agents_id) REFERENCES agents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agents_skills ADD CONSTRAINT FK_5088E4407FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47E7FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id)');
        $this->addSql('ALTER TABLE missions ADD CONSTRAINT FK_34F1D47EE9982FD7 FOREIGN KEY (hideout_id) REFERENCES hideout (id)');
        $this->addSql('ALTER TABLE missions_contacts ADD CONSTRAINT FK_FA54446417C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_contacts ADD CONSTRAINT FK_FA544464719FB48E FOREIGN KEY (contacts_id) REFERENCES contacts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_targets ADD CONSTRAINT FK_B7328F6017C042CF FOREIGN KEY (missions_id) REFERENCES missions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE missions_targets ADD CONSTRAINT FK_B7328F6043B5F743 FOREIGN KEY (targets_id) REFERENCES targets (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agents_missions DROP FOREIGN KEY FK_B804F404709770DC');
        $this->addSql('ALTER TABLE agents_skills DROP FOREIGN KEY FK_5088E440709770DC');
        $this->addSql('ALTER TABLE missions_contacts DROP FOREIGN KEY FK_FA544464719FB48E');
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47EE9982FD7');
        $this->addSql('ALTER TABLE agents_missions DROP FOREIGN KEY FK_B804F40417C042CF');
        $this->addSql('ALTER TABLE missions_contacts DROP FOREIGN KEY FK_FA54446417C042CF');
        $this->addSql('ALTER TABLE missions_targets DROP FOREIGN KEY FK_B7328F6017C042CF');
        $this->addSql('ALTER TABLE agents_skills DROP FOREIGN KEY FK_5088E4407FF61858');
        $this->addSql('ALTER TABLE missions DROP FOREIGN KEY FK_34F1D47E7FF61858');
        $this->addSql('ALTER TABLE missions_targets DROP FOREIGN KEY FK_B7328F6043B5F743');
        $this->addSql('DROP TABLE agents');
        $this->addSql('DROP TABLE agents_missions');
        $this->addSql('DROP TABLE agents_skills');
        $this->addSql('DROP TABLE contacts');
        $this->addSql('DROP TABLE hideout');
        $this->addSql('DROP TABLE missions');
        $this->addSql('DROP TABLE missions_contacts');
        $this->addSql('DROP TABLE missions_targets');
        $this->addSql('DROP TABLE skills');
        $this->addSql('DROP TABLE targets');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
