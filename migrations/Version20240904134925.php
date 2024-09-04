<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904134925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(255) NOT NULL, street_name VARCHAR(255) NOT NULL, adresse_number SMALLINT NOT NULL, country VARCHAR(255) NOT NULL, postal_code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE advertise (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, owner_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, equipement INT DEFAULT NULL, service INT DEFAULT NULL, price INT NOT NULL, presentation_picture VARCHAR(255) NOT NULL, gallery LONGTEXT DEFAULT NULL, total_place_number SMALLINT NOT NULL, actual_number_place SMALLINT NOT NULL, INDEX IDX_37B29FD94DE7DC5C (adresse_id), INDEX IDX_37B29FD97E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE advertise_image (id INT AUTO_INCREMENT NOT NULL, avertise_id INT NOT NULL, image_slug VARCHAR(255) NOT NULL, INDEX IDX_BF3D60E1E55D746B (avertise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE disponibilitie_date (id INT AUTO_INCREMENT NOT NULL, advertise_id INT DEFAULT NULL, started_at DATETIME NOT NULL, ended_at DATETIME NOT NULL, INDEX IDX_FC85156137AF8FCD (advertise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, reciver_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307F93173582 (reciver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reaction (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, advertise_id INT NOT NULL, note SMALLINT DEFAULT NULL, is_favorite TINYINT(1) DEFAULT NULL, INDEX IDX_A4D707F7A76ED395 (user_id), INDEX IDX_A4D707F737AF8FCD (advertise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, advertise_id INT NOT NULL, started_at DATETIME NOT NULL, end_at DATETIME NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C8495537AF8FCD (advertise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firsname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, INDEX IDX_8D93D6494DE7DC5C (adresse_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_advertise (user_id INT NOT NULL, advertise_id INT NOT NULL, INDEX IDX_3752123DA76ED395 (user_id), INDEX IDX_3752123D37AF8FCD (advertise_id), PRIMARY KEY(user_id, advertise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advertise ADD CONSTRAINT FK_37B29FD94DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE advertise ADD CONSTRAINT FK_37B29FD97E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE advertise_image ADD CONSTRAINT FK_BF3D60E1E55D746B FOREIGN KEY (avertise_id) REFERENCES advertise (id)');
        $this->addSql('ALTER TABLE disponibilitie_date ADD CONSTRAINT FK_FC85156137AF8FCD FOREIGN KEY (advertise_id) REFERENCES advertise (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F93173582 FOREIGN KEY (reciver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F737AF8FCD FOREIGN KEY (advertise_id) REFERENCES advertise (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495537AF8FCD FOREIGN KEY (advertise_id) REFERENCES advertise (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE user_advertise ADD CONSTRAINT FK_3752123DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_advertise ADD CONSTRAINT FK_3752123D37AF8FCD FOREIGN KEY (advertise_id) REFERENCES advertise (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advertise DROP FOREIGN KEY FK_37B29FD94DE7DC5C');
        $this->addSql('ALTER TABLE advertise DROP FOREIGN KEY FK_37B29FD97E3C61F9');
        $this->addSql('ALTER TABLE advertise_image DROP FOREIGN KEY FK_BF3D60E1E55D746B');
        $this->addSql('ALTER TABLE disponibilitie_date DROP FOREIGN KEY FK_FC85156137AF8FCD');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F93173582');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F7A76ED395');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F737AF8FCD');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495537AF8FCD');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494DE7DC5C');
        $this->addSql('ALTER TABLE user_advertise DROP FOREIGN KEY FK_3752123DA76ED395');
        $this->addSql('ALTER TABLE user_advertise DROP FOREIGN KEY FK_3752123D37AF8FCD');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE advertise');
        $this->addSql('DROP TABLE advertise_image');
        $this->addSql('DROP TABLE disponibilitie_date');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_advertise');
    }
}
