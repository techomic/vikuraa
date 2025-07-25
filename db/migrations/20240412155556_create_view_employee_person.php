<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateViewEmployeePerson extends AbstractMigration
{
    public function up(): void
    {
        $view = $this->execute("create view employee_person as 
            select 
                p.*,
                e.username,
                e.deleted,
                e.hash_version,
                e.language,
                e.language_code
            from employees e
            join people p on e.person_id = p.person_id");
        
        $sql = "grant select on employee_person to vikuraa_users";
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute("DROP VIEW employee_person");
    }
}
