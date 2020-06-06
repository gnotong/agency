<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200606112949 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD updated_at DATETIME NULL, ADD created_at DATETIME NULL');
        $this->addSql('ALTER TABLE attachment CHANGE updated_at updated_at DATETIME NULL, CHANGE created_at created_at DATETIME NULL, CHANGE image_name image_name VARCHAR(255) NULL, CHANGE description description VARCHAR(255) NULL, CHANGE position position VARCHAR(6) NULL');
        $this->addSql('ALTER TABLE house CHANGE updated_at updated_at DATETIME NULL');
        $this->addSql('ALTER TABLE `option` ADD updated_at DATETIME NULL, ADD created_at DATETIME NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attachment CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE position position VARCHAR(6) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image_name image_name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE house CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE `option` DROP updated_at, DROP created_at');
        $this->addSql('ALTER TABLE user DROP updated_at, DROP created_at');
    }
}
