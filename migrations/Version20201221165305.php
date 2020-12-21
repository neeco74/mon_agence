<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201221165305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE biens_option (biens_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_2B4CA7797773350C (biens_id), INDEX IDX_2B4CA779A7C41D6F (option_id), PRIMARY KEY(biens_id, option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE biens_option ADD CONSTRAINT FK_2B4CA7797773350C FOREIGN KEY (biens_id) REFERENCES biens (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE biens_option ADD CONSTRAINT FK_2B4CA779A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biens_option DROP FOREIGN KEY FK_2B4CA779A7C41D6F');
        $this->addSql('DROP TABLE biens_option');
        $this->addSql('DROP TABLE `option`');
    }
}
