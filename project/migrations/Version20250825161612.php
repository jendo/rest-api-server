<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250825161612 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
CREATE TABLE `customer_log`
(
    id          CHAR(36)    NOT NULL COMMENT '(DC2Type:uuid)',
    customer_id CHAR(36)    NOT NULL COMMENT '(DC2Type:uuid)',
    action      VARCHAR(50) NOT NULL,
    created_at  DATETIME    NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    INDEX IDX_C0CC36339395C3F3 (customer_id),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_ci`
  ENGINE = InnoDB;
SQL
        );

        $this->addSql(
            'ALTER TABLE `customer_log` ADD CONSTRAINT FK_C0CC36339395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE'
        );

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `customer_log` DROP FOREIGN KEY FK_C0CC36339395C3F3');
        $this->addSql('DROP TABLE `customer_log`');
    }
}
