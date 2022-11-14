<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221114165237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE athlete (id INT AUTO_INCREMENT NOT NULL, code_delegation_id INT DEFAULT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, age INT NOT NULL, image VARCHAR(255) DEFAULT NULL, gender TINYINT(1) NOT NULL, nationality VARCHAR(255) NOT NULL, INDEX IDX_C03B83216BD801D0 (code_delegation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE athlete_user (athlete_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_303F640CFE6BCB8B (athlete_id), INDEX IDX_303F640CA76ED395 (user_id), PRIMARY KEY(athlete_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE athlete_event (athlete_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_3DA5130AFE6BCB8B (athlete_id), INDEX IDX_3DA5130A71F7E88B (event_id), PRIMARY KEY(athlete_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE athlete_epreuve (athlete_id INT NOT NULL, epreuve_id INT NOT NULL, INDEX IDX_A96F8810FE6BCB8B (athlete_id), INDEX IDX_A96F8810AB990336 (epreuve_id), PRIMARY KEY(athlete_id, epreuve_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delegation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code_flag VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE epreuve (id INT AUTO_INCREMENT NOT NULL, code_sport_id INT NOT NULL, name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_D6ADE47F55F9C4D3 (code_sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE record (id INT AUTO_INCREMENT NOT NULL, athlete_id INT DEFAULT NULL, date DATETIME NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_9B349F91FE6BCB8B (athlete_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, subcategory VARCHAR(255) NOT NULL, gender TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sportif (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sportif_event (sportif_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_9749F769FFB7083B (sportif_id), INDEX IDX_9749F76971F7E88B (event_id), PRIMARY KEY(sportif_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sportif_epreuve (sportif_id INT NOT NULL, epreuve_id INT NOT NULL, INDEX IDX_40D83CF9FFB7083B (sportif_id), INDEX IDX_40D83CF9AB990336 (epreuve_id), PRIMARY KEY(sportif_id, epreuve_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE athlete ADD CONSTRAINT FK_C03B83216BD801D0 FOREIGN KEY (code_delegation_id) REFERENCES delegation (id)');
        $this->addSql('ALTER TABLE athlete_user ADD CONSTRAINT FK_303F640CFE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE athlete_user ADD CONSTRAINT FK_303F640CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE athlete_event ADD CONSTRAINT FK_3DA5130AFE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE athlete_event ADD CONSTRAINT FK_3DA5130A71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE athlete_epreuve ADD CONSTRAINT FK_A96F8810FE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE athlete_epreuve ADD CONSTRAINT FK_A96F8810AB990336 FOREIGN KEY (epreuve_id) REFERENCES epreuve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE epreuve ADD CONSTRAINT FK_D6ADE47F55F9C4D3 FOREIGN KEY (code_sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F91FE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id)');
        $this->addSql('ALTER TABLE sportif_event ADD CONSTRAINT FK_9749F769FFB7083B FOREIGN KEY (sportif_id) REFERENCES sportif (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sportif_event ADD CONSTRAINT FK_9749F76971F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sportif_epreuve ADD CONSTRAINT FK_40D83CF9FFB7083B FOREIGN KEY (sportif_id) REFERENCES sportif (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sportif_epreuve ADD CONSTRAINT FK_40D83CF9AB990336 FOREIGN KEY (epreuve_id) REFERENCES epreuve (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE athlete DROP FOREIGN KEY FK_C03B83216BD801D0');
        $this->addSql('ALTER TABLE athlete_user DROP FOREIGN KEY FK_303F640CFE6BCB8B');
        $this->addSql('ALTER TABLE athlete_user DROP FOREIGN KEY FK_303F640CA76ED395');
        $this->addSql('ALTER TABLE athlete_event DROP FOREIGN KEY FK_3DA5130AFE6BCB8B');
        $this->addSql('ALTER TABLE athlete_event DROP FOREIGN KEY FK_3DA5130A71F7E88B');
        $this->addSql('ALTER TABLE athlete_epreuve DROP FOREIGN KEY FK_A96F8810FE6BCB8B');
        $this->addSql('ALTER TABLE athlete_epreuve DROP FOREIGN KEY FK_A96F8810AB990336');
        $this->addSql('ALTER TABLE epreuve DROP FOREIGN KEY FK_D6ADE47F55F9C4D3');
        $this->addSql('ALTER TABLE record DROP FOREIGN KEY FK_9B349F91FE6BCB8B');
        $this->addSql('ALTER TABLE sportif_event DROP FOREIGN KEY FK_9749F769FFB7083B');
        $this->addSql('ALTER TABLE sportif_event DROP FOREIGN KEY FK_9749F76971F7E88B');
        $this->addSql('ALTER TABLE sportif_epreuve DROP FOREIGN KEY FK_40D83CF9FFB7083B');
        $this->addSql('ALTER TABLE sportif_epreuve DROP FOREIGN KEY FK_40D83CF9AB990336');
        $this->addSql('DROP TABLE athlete');
        $this->addSql('DROP TABLE athlete_user');
        $this->addSql('DROP TABLE athlete_event');
        $this->addSql('DROP TABLE athlete_epreuve');
        $this->addSql('DROP TABLE delegation');
        $this->addSql('DROP TABLE epreuve');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE record');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE sportif');
        $this->addSql('DROP TABLE sportif_event');
        $this->addSql('DROP TABLE sportif_epreuve');
        $this->addSql('DROP TABLE user');
    }
}
