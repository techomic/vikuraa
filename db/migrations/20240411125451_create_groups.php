<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateGroups extends AbstractMigration
{
    public function up(): void
    {
        $sql = "create group vikuraa_admins";
        $this->execute($sql);

        $sql = "grant all privileges on database vikuraa to vikuraa_admins";
        $this->execute($sql);
        
        $sql = "create group vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute('DROP GROUP vikuraa_users');
        $this->execute('DROP GROUP vikuraa_admins');
    }
}
