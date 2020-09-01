<?php

declare(strict_types=1);

namespace migrations;

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
        $this->addSql('CREATE TABLE cinema (id INT AUTO_INCREMENT NOT NULL, origin_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, category VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ratings (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, pos INT NOT NULL, date_created DATE, average_score FLOAT DEFAULT 0, calculated_score FLOAT DEFAULT 0, votes INTEGER DEFAULT 0, PRIMARY KEY(id))');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE cinema');
        $this->addSql('DROP TABLE ratings');

    }
}
