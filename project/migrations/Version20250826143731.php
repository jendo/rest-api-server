<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250826143731 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
CREATE TABLE `order`
(
    id                  CHAR(36)    NOT NULL COMMENT '(DC2Type:uuid)',
    customer_id         CHAR(36)    NOT NULL COMMENT '(DC2Type:uuid)',
    shipping_address_id CHAR(36)    NOT NULL COMMENT '(DC2Type:uuid)',
    created_at          DATETIME    NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    status              VARCHAR(50) NOT NULL,
    items               LONGTEXT    NOT NULL COMMENT '(DC2Type:json)',
    INDEX IDX_F52993989395C3F3 (customer_id),
    UNIQUE INDEX UNIQ_F52993984D4CFF2B (shipping_address_id),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_ci`
  ENGINE = InnoDB;
SQL
        );

        $this->addSql(
            <<<SQL
CREATE TABLE order_address
(
    id          CHAR(36)     NOT NULL COMMENT '(DC2Type:uuid)',
    street      VARCHAR(255) NOT NULL,
    city        VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20)  NOT NULL,
    country     VARCHAR(100) NOT NULL,
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4
  COLLATE `utf8mb4_unicode_ci`
  ENGINE = InnoDB;
SQL
        );

        $this->addSql(
            'ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)'
        );
        $this->addSql(
            'ALTER TABLE `order` ADD CONSTRAINT FK_F52993984D4CFF2B FOREIGN KEY (shipping_address_id) REFERENCES order_address (id)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984D4CFF2B');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_address');
    }
}
