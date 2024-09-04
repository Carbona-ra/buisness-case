<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904140147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_advertise DROP FOREIGN KEY FK_3752123D37AF8FCD');
        $this->addSql('ALTER TABLE user_advertise DROP FOREIGN KEY FK_3752123DA76ED395');
        $this->addSql('DROP TABLE user_advertise');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_advertise (user_id INT NOT NULL, advertise_id INT NOT NULL, INDEX IDX_3752123DA76ED395 (user_id), INDEX IDX_3752123D37AF8FCD (advertise_id), PRIMARY KEY(user_id, advertise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_advertise ADD CONSTRAINT FK_3752123D37AF8FCD FOREIGN KEY (advertise_id) REFERENCES advertise (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_advertise ADD CONSTRAINT FK_3752123DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
