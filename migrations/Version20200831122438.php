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
        $this->addSql('CREATE TABLE cinema (id INT AUTO_INCREMENT NOT NULL, origin_id INT UNIQUE NOT NULL, title VARCHAR(255) DEFAULT NULL, category VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, year INT, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ratings (id INT AUTO_INCREMENT NOT NULL, cinema_id INT, category VARCHAR(255) NOT NULL, pos INT NOT NULL, date_created DATE, average_score FLOAT DEFAULT 0, calculated_score FLOAT DEFAULT 0, votes INTEGER DEFAULT 0, PRIMARY KEY(id), FOREIGN KEY (cinema_id) REFERENCES cinema(origin_id)  ON DELETE CASCADE )');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE ratings');
        $this->addSql('DROP TABLE cinema');

    }
}
