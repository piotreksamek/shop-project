<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250210192138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_base_information (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, city VARCHAR(100) DEFAULT NULL, street VARCHAR(100) DEFAULT NULL, apartment_number VARCHAR(10) DEFAULT NULL, number VARCHAR(10) DEFAULT NULL, province VARCHAR(100) DEFAULT NULL, postal_code VARCHAR(6) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users ADD base_information_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99CC5811C FOREIGN KEY (base_information_id) REFERENCES user_base_information (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E99CC5811C ON users (base_information_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E99CC5811C');
        $this->addSql('DROP TABLE user_base_information');
        $this->addSql('DROP INDEX UNIQ_1483A5E99CC5811C ON users');
        $this->addSql('ALTER TABLE users DROP base_information_id');
    }
}
