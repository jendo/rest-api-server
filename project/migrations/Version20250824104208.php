<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250824104208 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
CREATE TABLE address
(
    id          BINARY(16)   NOT NULL COMMENT '(DC2Type:uuid)',
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
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE address');
    }
}
