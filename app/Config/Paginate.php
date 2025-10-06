<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pagination extends BaseConfig
{
    // Number of records per page
    public int $perPage = 5;

    // Optional: Bootstrap template
    public string $template = 'default';
}
