<?php

declare(strict_types=1);

namespace app\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200831122438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE cinema (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, date_created DATE, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, average_score FLOAT DEFAULT 0, calculated_score FLOAT DEFAULT 0, votes INTEGER DEFAULT 0, PRIMARY KEY(id))');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE cinema');

    }
}
