<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200602075953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce ADD phone VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD link_in VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, ADD email_ok TINYINT(1) NOT NULL, ADD type_scool_one VARCHAR(255) DEFAULT NULL, ADD special_one VARCHAR(255) DEFAULT NULL, ADD years_one DATE DEFAULT NULL, ADD type_scool_two VARCHAR(255) DEFAULT NULL, ADD special_two VARCHAR(255) DEFAULT NULL, ADD years_two DATE DEFAULT NULL, ADD type_scool_three VARCHAR(255) DEFAULT NULL, ADD special_three VARCHAR(255) DEFAULT NULL, ADD years_three DATE DEFAULT NULL, ADD prof_activity TINYINT(1) DEFAULT NULL, ADD your_activity VARCHAR(255) DEFAULT NULL, DROP title, DROP slug, DROP introduction, DROP content');
        $this->addSql('ALTER TABLE user ADD stud_or_teach VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce ADD title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD introduction LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP phone, DROP address, DROP city, DROP link_in, DROP country, DROP email_ok, DROP type_scool_one, DROP special_one, DROP years_one, DROP type_scool_two, DROP special_two, DROP years_two, DROP type_scool_three, DROP special_three, DROP years_three, DROP prof_activity, DROP your_activity');
        $this->addSql('ALTER TABLE user DROP stud_or_teach');
    }
}
