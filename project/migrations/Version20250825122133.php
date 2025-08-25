<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250825122133 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
CREATE TABLE customer
(
    id         CHAR(36)     NOT NULL COMMENT '(DC2Type:uuid)',
    email      VARCHAR(100) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name  VARCHAR(100) NOT NULL,
    UNIQUE INDEX UNIQ_CUSTOMER_EMAIL (email),
    PRIMARY KEY (id)
)
    DEFAULT CHARACTER SET utf8mb4
    COLLATE `utf8mb4_unicode_ci`
    ENGINE = InnoDB;
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE customer');
    }
}
