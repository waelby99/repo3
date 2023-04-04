<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230404211403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur ADD vote_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C52E2DFC9C FOREIGN KEY (vote_id_id) REFERENCES vote (id)');
        $this->addSql('CREATE INDEX IDX_FD71A9C52E2DFC9C ON joueur (vote_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C52E2DFC9C');
        $this->addSql('DROP INDEX IDX_FD71A9C52E2DFC9C ON joueur');
        $this->addSql('ALTER TABLE joueur DROP vote_id_id');
    }
}
