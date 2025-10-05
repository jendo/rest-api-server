<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251005110948 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
CREATE TABLE customer_settings
(
    id                      CHAR(36)   NOT NULL COMMENT '(DC2Type:uuid)',
    customer_id             CHAR(36)   NOT NULL COMMENT '(DC2Type:uuid)',
    preferred_language_code VARCHAR(2) NOT NULL,
    marketing_allowed       TINYINT(1) NOT NULL,
    UNIQUE INDEX UNIQ_C980E3EA9395C3F3 (customer_id),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_ci`
  ENGINE = InnoDB;
SQL
        );

        $this->addSql(
            'ALTER TABLE customer_settings ADD CONSTRAINT FK_C980E3EA9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id);'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE customer_settings DROP FOREIGN KEY FK_C980E3EA9395C3F3');
        $this->addSql('DROP TABLE customer_settings');
    }
}
