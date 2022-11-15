<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115101531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE athlete_record (athlete_id INT NOT NULL, record_id INT NOT NULL, INDEX IDX_33554BDDFE6BCB8B (athlete_id), INDEX IDX_33554BDD4DFD750C (record_id), PRIMARY KEY(athlete_id, record_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE athlete_record ADD CONSTRAINT FK_33554BDDFE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE athlete_record ADD CONSTRAINT FK_33554BDD4DFD750C FOREIGN KEY (record_id) REFERENCES record (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sportif_event DROP FOREIGN KEY FK_9749F76971F7E88B');
        $this->addSql('ALTER TABLE sportif_event DROP FOREIGN KEY FK_9749F769FFB7083B');
        $this->addSql('ALTER TABLE sportif_epreuve DROP FOREIGN KEY FK_40D83CF9AB990336');
        $this->addSql('ALTER TABLE sportif_epreuve DROP FOREIGN KEY FK_40D83CF9FFB7083B');
        $this->addSql('DROP TABLE sportif_event');
        $this->addSql('DROP TABLE sportif_epreuve');
        $this->addSql('DROP TABLE sportif');
        $this->addSql('ALTER TABLE athlete ADD city VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE delegation DROP code_flag');
        $this->addSql('ALTER TABLE record DROP FOREIGN KEY FK_9B349F91FE6BCB8B');
        $this->addSql('DROP INDEX IDX_9B349F91FE6BCB8B ON record');
        $this->addSql('ALTER TABLE record DROP athlete_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sportif_event (sportif_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_9749F76971F7E88B (event_id), INDEX IDX_9749F769FFB7083B (sportif_id), PRIMARY KEY(sportif_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sportif_epreuve (sportif_id INT NOT NULL, epreuve_id INT NOT NULL, INDEX IDX_40D83CF9AB990336 (epreuve_id), INDEX IDX_40D83CF9FFB7083B (sportif_id), PRIMARY KEY(sportif_id, epreuve_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE sportif (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sportif_event ADD CONSTRAINT FK_9749F76971F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sportif_event ADD CONSTRAINT FK_9749F769FFB7083B FOREIGN KEY (sportif_id) REFERENCES sportif (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sportif_epreuve ADD CONSTRAINT FK_40D83CF9AB990336 FOREIGN KEY (epreuve_id) REFERENCES epreuve (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sportif_epreuve ADD CONSTRAINT FK_40D83CF9FFB7083B FOREIGN KEY (sportif_id) REFERENCES sportif (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE athlete_record DROP FOREIGN KEY FK_33554BDDFE6BCB8B');
        $this->addSql('ALTER TABLE athlete_record DROP FOREIGN KEY FK_33554BDD4DFD750C');
        $this->addSql('DROP TABLE athlete_record');
        $this->addSql('ALTER TABLE delegation ADD code_flag VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE record ADD athlete_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE record ADD CONSTRAINT FK_9B349F91FE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_9B349F91FE6BCB8B ON record (athlete_id)');
        $this->addSql('ALTER TABLE athlete DROP city');
    }
}
