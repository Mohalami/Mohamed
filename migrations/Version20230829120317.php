<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829120317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE peinture CHANGE largeur largeur NUMERIC(6, 2) DEFAULT NULL, CHANGE hauteur hauteur NUMERIC(6, 2) DEFAULT NULL, CHANGE prix prix NUMERIC(10, 2) DEFAULT NULL, CHANGE date_realisation date_realisation DATETIME DEFAULT NULL, CHANGE portfolio porte_folio TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE instagram instagram VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE peinture CHANGE largeur largeur NUMERIC(6, 2) DEFAULT \'NULL\', CHANGE hauteur hauteur NUMERIC(6, 2) DEFAULT \'NULL\', CHANGE prix prix NUMERIC(10, 2) DEFAULT \'NULL\', CHANGE date_realisation date_realisation DATETIME DEFAULT \'NULL\', CHANGE porte_folio portfolio TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE instagram instagram VARCHAR(255) DEFAULT \'NULL\'');
    }
}
