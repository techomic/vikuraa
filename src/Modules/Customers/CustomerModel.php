<?php

namespace Vikuraa\Modules\Customers;

use RuntimeException;
use Vikuraa\Core\Model;
use Vikuraa\Exceptions\NoDataException;
use Vikuraa\Modules\People\PersonModel;

class CustomerModel extends Model
{
    public function save(Customer $customer): bool
    {
        $sql = "
            insert into customers (
                person_id,
                company_name,
                account_number,
                taxable,
                tax_id,
                sales_tax_code_id,
                discount,
                discount_type,
                package_id,
                points,
                employee_id,
                consent
            ) values (
                :person_id,
                :company_name,
                :account_number,
                :taxable,
                :tax_id,
                :sales_tax_code_id,
                :discount,
                :discount_type,
                :package_id,
                :points,
                :employee_id,
                :consent
            )
        ";

        $args = [
            'person_id' => $customer->personId,
            'company_name' => $customer->companyName,
            'account_number' => $customer->accountNumber,
            'taxable' => $customer->taxable,
            'tax_id' => $customer->taxId,
            'sales_tax_code_id' => $customer->salesTaxCodeId,
            'discount' => $customer->discount,
            'discount_type' => $customer->discountType,
            'package_id' => $customer->packageId,
            'points' => $customer->points,
            'employee_id' => $customer->employeeId,
            'consent' => $customer->consent,
        ];

        return (new PersonModel($this->container))->save($customer);
        // if ($args['person_id'] = (new PersonModel($this->container))->save($customer)) {
        //     $this->logger->debug('personid ' . $args['person_id']);
        //     return $this->db->execute($sql, $args, true);
        // }

        // return false;
    }

    public function exists(int $id): bool
    {
        $sql = "
            select *
            from customers
            where person_id = :customer_id
        ";

        $args = [
            'customer_id' => $id,
        ];

        return $this->db->count($sql, $args) > 0;
    }

    public function accountNumberExists(string $accountNumber): bool
    {
        $sql = "
            select *
            from customers
            where account_number = :account_number
        ";

        $args = [
            'account_number' => $accountNumber,
        ];

        return $this->db->count($sql, $args) > 0;
    }

    public function emailExists(string $email, ?int $personId) : bool
    {
        $sql = "select * from customer_person where email = :email ";

        $args['email'] = $email;

        if (!empty($personId)) {
            $sql .= " and person_id = :person_id";
            $args['person_id'] = $personId;
        }

        return $this->db->count($sql, $args) > 0;
    }

    public function total(): int
    {
        $sql = "
            select *
            from customers
            where deleted = false
        ";

        return $this->db->count($sql);
    }

    public function all(): Customers
    {
        $sql = "
            select *
            from customer_person
            where deleted = false
        ";

        $customers = new Customers();

        foreach ($this->db->query($sql) as $data) {
            $customers->add(Customer::fromDbArray($data));
        }

        return $customers;
    }

    public function byId(int $id): Customer
    {
        $sql = "
            select *
            from customer_person
            where person_id = :person_id
        ";

        $args = [
            'person_id' => $id,
        ];

        $data = $this->db->query($sql, $args);

        if (!(is_array($data) && count($data) > 0)) {
            throw new NoDataException('Customer not found');
        }

        return Customer::fromDbArray($data[0]);
    }

    public function byIds(array $ids) : Customers
    {
        if (empty($ids)) {
            throw new RuntimeException('$ids array is empty');
        }

        $placeHolders = implode(', ', array_fill(0, count($ids), '?'));

        $sql = "select * from customer_person where person_id in ({$placeHolders}) AND deleted = FALSE;";

        $data = $this->db->query($sql, $ids);

        if (empty($data)) {
            throw new NoDataException('No customers found');
        }

        $customers = new Customers();

        $customers->addAllFromDbArray($data);

        return $customers;
    }

    public function updateRewardPoints(int $customerId, int $points): bool
    {
        $sql = "
            update customers
            set points = :points
            where person_id = :person_id
        ";

        $args = [
            'points' => $points,
            'person_id' => $customerId,
        ];

        return $this->db->execute($sql, $args);
    }

    public function delete(int $id): int|false
    {
        $args = ['person_id' => $id];
        
        $result1 = false;
        $result2 = false;

        if ($this->config->getValue('enforce_privacy')) { // unset values on people table and set customer as deleted
            $sql = "
                update people
                set
                    first_name = :person_id,
					last_name = :person_id,
					phone_number = '',
					email = '',
					gender = null,
					address_1 = '',
					address_2 = '',
					city = '',
					state = '',
					zip = '',
					country = '',
					comments = ''
                where person_id = :person_id

                
            ";
            $result1 = $this->db->execute($sql, $args);

            $sql = "
                update customers
                set
                    consent = 0,
                    company_name = null,
                    account_number = null,
                    tax_id = '',
                    taxable = 0,
                    discount = 0.00,
                    discount_type = 0,
                    package_id = null,
                    points = null,
                    sales_tax_code_id = null,
                    deleted => true
                where person_id = :person_id
            ";
            $result2 = $this->db->execute($sql, $args);

            return $result1 && $result2;
        } else {
            $sql = "update customers set deleted = true where person_id = :person_id";
            return $this->db->execute($sql, $args);
        }
    }

    public function deleteMultiple(array $ids): array
    {
        $successCount = 0;
        $failureCount = 0;

        foreach ($ids as $id) {
            if ($this->delete($id) !== false) {
                $successCount++;
            } else {
                $failureCount++;
            }
        }

        return ['success' => $successCount, 'failure' => $failureCount];
    }

    public function search(string $query, int $limit = 0, int $offset = 0, string $sort = 'first_name', string $order = 'asc') : Customers
    {
        // var_dump('limit', $limit, 'offset', $offset);
        $sql = "
            select *
            from customer_person
            where (
                lower(first_name) like concat('%', cast(:query as text), '%')
                or lower(last_name) like concat('%', cast(:query as text), '%')
                or lower(email) like concat('%', cast(:query as text), '%')
                or lower(phone_number) like concat('%', cast(:query as text), '%')
                or lower(account_number) like concat('%', cast(:query as text), '%')
                or lower(company_name) like concat('%', cast(:query as text), '%')
                or concat(lower(first_name), ' ', lower(last_name)) like concat('%', cast(:query as text), '%')
            ) and deleted = false
        ";

        $args = [
            'query' => strtolower(trim($query))
        ];
		

        $sql .= " order by :sort {$order} ";
        $args['sort'] = $sort;

        if ($limit > 0) {
            $sql .= " limit cast(:limit as int) offset cast(:offset as int) ";
            $args['limit'] = $limit;
            $args['offset'] = $offset;
        }

		$customers = new Customers();

        $data = $this->db->query($sql, $args);

        if (!empty($data)) {
            foreach ($data as $row) {
                $customers->add(Customer::fromDbArray($row));
            }
        } else {
            throw new NoDataException('No customers found');
        }
        
        return $customers;
    }

    public function count(string $query)
    {
        $sql = "
            select *
            from customers
            where
                (
                    lower(first_name) like concat('%', :query, '%')
                    or lower(last_name) like concat('%', :query, '%')
                    or lower(email) like concat('%', :query, '%')
                    or lower(phone_number) like concat('%', :query, '%')
                    or lower(account_number) like concat('%', :query, '%')
                    or lower(company_name) like concat('%', :query, '%')
                    or concat(lower(first_name), ' ', lower(last_name)) like concat('%', :query, '%')
                )
                and deleted = false
                
        ";
        $args = [
            'query' => strtolower(trim($query)),
        ];

        return $this->db->count($sql, $args);
    }

    //TODO: there is one more method in this called getStats
}