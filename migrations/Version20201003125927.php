<?php declare(strict_types=1);

namespace App\Events\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201003125927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initialise tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE domain_events (id BIGINT GENERATED BY DEFAULT AS IDENTITY PRIMARY KEY, version SMALLINT NOT NULL DEFAULT 1, aggregate_root VARCHAR(255) NOT NULL, aggregate_id VARCHAR(255) NOT NULL, event_name VARCHAR(255) NOT NULL, payload jsonb, context jsonb, created_at TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL)');
        $this->addSql('CREATE INDEX idx_domain_events_aggregate_root_id ON domain_events (aggregate_root, aggregate_id)');
        $this->addSql('CREATE INDEX idx_domain_events_event_name ON domain_events (event_name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS domain_events');
    }
}
