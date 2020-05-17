<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517114302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $tableOrganisation = $schema->createTable('organisation');
        $tableOrganisation->addColumn('id', 'integer', ['autoincrement' => true]);
        $tableOrganisation->addColumn('name', 'string');
        $tableOrganisation->setPrimaryKey(['id']);

        $table = $schema->createTable('user');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string');
        $table->addColumn('surname', 'string');
        $table->addColumn('phone', 'string');
        $table->addColumn('invited_by', 'integer');
        $table->addColumn('organisation_id', 'integer');
        $table->addColumn('password', 'string');
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint($tableOrganisation, ['organisation_id'], ['id'],
            ['NO ACTION', 'RESTRICT'], 'fk_user_organisation');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('user');
        $schema->dropTable('organisation');
    }

    public function postUp(Schema $schema): void
    {
        $connection = $this->connection;

        $sql = 'INSERT INTO organisation (id, `name`) VALUES (-1, :name)';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue('name', 'ООО Рога и Копыта');
        $stmt->execute();

        $sql = 'INSERT INTO `user` (id, `name`, surname, phone, invited_by, organisation_id, password) ';
        $sql .= 'VALUES (-1, :name, :surname, :phone, -1, -1, :password)';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue('name', 'Иван');
        $stmt->bindValue('surname', 'Иванов');
        $stmt->bindValue('phone', '88005553535');
        $stmt->bindValue('password', '12345QwertY');
        $stmt->execute();
    }
}
