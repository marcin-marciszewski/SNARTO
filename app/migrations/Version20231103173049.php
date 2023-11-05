<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231103173049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add companies table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE companies (
                id CHARACTER(36) PRIMARY KEY,
                regon VARCHAR(15),
                name VARCHAR(255),
                voivodeship VARCHAR(255),
                county VARCHAR(255),
                borough VARCHAR(255),
                town VARCHAR(255),
                postcode VARCHAR(10),
                street VARCHAR(255)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE companies');
    }
}
