<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416163749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant ADD opening_time LONGTEXT DEFAULT NULL, DROP monday, DROP tuesday, DROP wednesday, DROP thursday, DROP friday, DROP saturday, DROP sunday');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE restaurant ADD monday VARCHAR(255) DEFAULT NULL, ADD tuesday VARCHAR(255) DEFAULT NULL, ADD wednesday VARCHAR(255) DEFAULT NULL, ADD thursday VARCHAR(255) DEFAULT NULL, ADD friday VARCHAR(255) DEFAULT NULL, ADD saturday VARCHAR(255) DEFAULT NULL, ADD sunday VARCHAR(255) DEFAULT NULL, DROP opening_time');
    }
}
