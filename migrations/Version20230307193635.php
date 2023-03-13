<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307193635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE2BB71EFD');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F2BB71EFD');
        $this->addSql('DROP TABLE book_date');
        $this->addSql('DROP INDEX IDX_E00CEDDE2BB71EFD ON booking');
        $this->addSql('ALTER TABLE booking DROP book_date_id');
        $this->addSql('DROP INDEX IDX_EB95123F2BB71EFD ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP book_date_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_date (id INT AUTO_INCREMENT NOT NULL, lunch INT DEFAULT NULL, dinner INT DEFAULT NULL, date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE booking ADD book_date_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE2BB71EFD FOREIGN KEY (book_date_id) REFERENCES book_date (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE2BB71EFD ON booking (book_date_id)');
        $this->addSql('ALTER TABLE restaurant ADD book_date_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F2BB71EFD FOREIGN KEY (book_date_id) REFERENCES book_date (id)');
        $this->addSql('CREATE INDEX IDX_EB95123F2BB71EFD ON restaurant (book_date_id)');
    }
}
