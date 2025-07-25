<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

require_once __DIR__ . '/../MigrationTrait.php';

final class CreateDatabase extends AbstractMigration
{
    use MigrationTrait;

    public function up(): void
    {
        // $this->createDatabase($this->dbName, []);
        // $this->execute("CREATE DATABASE {$this->dbName}");
    }

    public function down(): void
    {
        // $this->dropDatabase($this->dbName);
        // $this->execute("DROP DATABASE {$this->dbName}");
    }
}
