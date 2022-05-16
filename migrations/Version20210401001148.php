<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210401001148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location_materiel (id INT AUTO_INCREMENT NOT NULL, total_location DOUBLE PRECISION NOT NULL, duree_location INT NOT NULL, date_debut_location DATE NOT NULL, date_fin_location DATE NOT NULL, adresse_locataire_location VARCHAR(255) NOT NULL, nom_locataire_location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, location_id INT DEFAULT NULL, nom_materiel VARCHAR(255) NOT NULL, description_materiel VARCHAR(255) NOT NULL, prix_materiel DOUBLE PRECISION NOT NULL, photo_materiel VARCHAR(255) NOT NULL, INDEX IDX_18D2B09164D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B09164D218E FOREIGN KEY (location_id) REFERENCES location_materiel (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materiel DROP FOREIGN KEY FK_18D2B09164D218E');
        $this->addSql('DROP TABLE location_materiel');
        $this->addSql('DROP TABLE materiel');
    }
}
