<?php

namespace Vikuraa\Modules\AppConfig;

use Vikuraa\Core\Model;
use Vikuraa\Exceptions\NoDataException;

class AppConfigModel extends Model
{
    /**
     * Check if a key exists in the app config.
     * 
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        $sql = "SELECT * FROM app_config WHERE key = :key";

        $data = $this->db->query($sql, ['key' => $key]);

        return is_array($data) && count($data) > 0;
    }

    /**
     * Get all app configs.
     * 
     * @return AppConfigs
     * @throws NoDataException if no app configs are found
     */
    public function all(): AppConfigs
    {
        $sql = "SELECT * FROM app_config";

        $data = $this->db->query($sql);

        if (!is_array($data)) {
            throw new NoDataException('No app configs found');
        }

        if (count($data) === 0) {
            throw new NoDataException('No app configs found');
        }

        $appConfigs = new AppConfigs();

        foreach ($data as $row) {
            $appConfigs->add(AppConfig::fromDbArray($row));
        }

        return $appConfigs;
    }

    /**
     * Get an app config by key.
     * 
     * @param string $key
     * @return AppConfig
     * @throws NoDataException if no app config is found
     */
    public function get(string $key): AppConfig
    {
        $sql = "SELECT * FROM app_config WHERE key = :key";

        $data = $this->db->query($sql, ['key' => $key]);

        if (!is_array($data)) {
            throw new NoDataException('No app config found');
        }

        if (count($data) === 0) {
            throw new NoDataException('No app config found');
        }

        return AppConfig::fromDbArray($data[0]);
    }

    /**
     * Save an app config.
     * 
     * @param string $key
     * @param string $value
     * @return bool
     * @throws DatabaseException if the app config could not be saved
     */
    public function save(string $key, string $value): bool
    {
        $sql = "INSERT INTO app_config (key, value) VALUES (:key, :value)";

        return $this->db->execute($sql, ['key' => $key, 'value' => $value]);
    }

    /**
     * Delete an app config by key.
     * 
     * @param string $key
     * @return bool
     * @throws DatabaseException if the app config could not be deleted
     */
    public function delete(string $key): bool
    {
        $sql = "DELETE FROM app_config WHERE key = :key";

        return $this->db->execute($sql, ['key' => $key]);
    }

    /**
     * Delete all app configs.
     * 
     * @return bool
     * @throws DatabaseException if the app configs could not be deleted
     */
    public function deleteAll(): bool
    {
        $sql = "DELETE FROM app_config";

        return $this->db->execute($sql);
    }

    /**
     * Acquire next invoice sequence.
     * 
     * @param bool $save
     * @return int
     * @throws NoDataException if the sequence could not be acquired
     */
    public function acquireNextInvoiceSequence(bool $save = true): int
    {
        $appConfig = $this->get('last_used_invoice_number');
        $next = intval($appConfig->value) + 1;

        if ($save) {
            $this->save('last_used_invoice_number', strval($next));
        }

        return $next;
    }

    /**
     * Acquire next quote sequence.
     * 
     * @param bool $save
     * @return int
     * @throws NoDataException if the sequence could not be acquired
     */
    public function acquireNextQuoteSequence(bool $save = true): int
    {
        $appConfig = $this->get('last_used_quote_number');
        $next = intval($appConfig->value) + 1;

        if ($save) {
            $this->save('last_used_quote_number', strval($next));
        }

        return $next;
    }

    /**
     * Acquire next work order sequence.
     * 
     * @param bool $save
     * @return int
     * @throws NoDataException if the sequence could not be acquired
     */
    public function acquireNextWorkOrderSequence(bool $save = true): int
    {
        $appConfig = $this->get('last_used_work_order_number');
        $next = intval($appConfig->value) + 1;

        if ($save) {
            $this->save('last_used_work_order_number', strval($next));
        }

        return $next;
    }

    /**
     * Saves a batch of AppConfigs.
     * 
     * @todo for multiple rows, call $this->save
     */
    public function batchSave($data) : int|false
    {
        return false;
    }
}