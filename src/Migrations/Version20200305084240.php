<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200305084240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE picture_user DROP INDEX UNIQ_327353DCDD28C16D, ADD INDEX IDX_327353DCDD28C16D (user_image_id)');
        $this->addSql('ALTER TABLE picture_user CHANGE user_image_id user_image_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE picture_user DROP INDEX IDX_327353DCDD28C16D, ADD UNIQUE INDEX UNIQ_327353DCDD28C16D (user_image_id)');
        $this->addSql('ALTER TABLE picture_user CHANGE user_image_id user_image_id INT DEFAULT NULL');
    }
}
