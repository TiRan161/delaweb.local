<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200517172302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('user');
        $table->addForeignKeyConstraint($table, ['invited_by'], ['id'], ['NO ACTION', 'RESTRICT'], 'fk_user_user');
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('user');
        $table->removeForeignKey('fk_user_user');
    }
}
