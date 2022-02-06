<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220206183909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ALTER register_at DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER last_login DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER last_login_ip DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER confirmation_token DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" ALTER register_at SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER last_login SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER last_login_ip SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER confirmation_token SET NOT NULL');
    }
}
