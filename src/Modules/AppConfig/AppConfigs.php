<?php

namespace Vikuraa\Modules\AppConfig;

use Vikuraa\Core\Collection;

class AppConfigs extends Collection
{
    public function __construct()
    {
        parent::__construct(AppConfig::class);
    }

    public function getValue($key): mixed
    {
        $value = null;
        foreach ($this->items as $appConfig) {
            if ($appConfig->key === $key) {
                $value = $appConfig->value;
                break;
            }
        }

        return $value;
    }

    public function addAll(array $items) : void
    {
        foreach ($items as $config) {
            $this->add($config);
        }
    }

    public function addFromDbArray(array $data) : void
    {
        $config = AppConfig::fromDbArray($data);

        $this->add($config);
    }

    public function addAllFromDbArray(array $data) : void
    {
        foreach ($data as $config) {
            $this->addFromDbArray($config);
        }
    }
}