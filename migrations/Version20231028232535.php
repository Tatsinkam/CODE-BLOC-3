<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231028232535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plan_pricing DROP FOREIGN KEY FK_5B4EE43BE5099565');
        $this->addSql('ALTER TABLE plan_pricing_plan_pricing DROP FOREIGN KEY FK_6FFCA3DF63220EC8');
        $this->addSql('ALTER TABLE plan_pricing_plan_pricing DROP FOREIGN KEY FK_6FFCA3DF7AC75E47');
        $this->addSql('DROP TABLE plan_pricing');
        $this->addSql('DROP TABLE plan_pricing_plan_pricing');
        $this->addSql('DROP TABLE pricing_plan_benefit');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plan_pricing (id INT AUTO_INCREMENT NOT NULL, plan_pricing_id INT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, INDEX IDX_5B4EE43BE5099565 (plan_pricing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE plan_pricing_plan_pricing (plan_pricing_source INT NOT NULL, plan_pricing_target INT NOT NULL, INDEX IDX_6FFCA3DF7AC75E47 (plan_pricing_source), INDEX IDX_6FFCA3DF63220EC8 (plan_pricing_target), PRIMARY KEY(plan_pricing_source, plan_pricing_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pricing_plan_benefit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE plan_pricing ADD CONSTRAINT FK_5B4EE43BE5099565 FOREIGN KEY (plan_pricing_id) REFERENCES plan_pricing (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE plan_pricing_plan_pricing ADD CONSTRAINT FK_6FFCA3DF63220EC8 FOREIGN KEY (plan_pricing_target) REFERENCES plan_pricing (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plan_pricing_plan_pricing ADD CONSTRAINT FK_6FFCA3DF7AC75E47 FOREIGN KEY (plan_pricing_source) REFERENCES plan_pricing (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE user');
    }
}
