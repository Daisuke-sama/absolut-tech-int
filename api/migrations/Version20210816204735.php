<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210816204735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD uuid BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE `user` DROP uuid, CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
    }
}
