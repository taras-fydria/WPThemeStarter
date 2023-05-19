<?php

namespace App\Admin;

use App\Base\Singleton;

class DynamicAdmin extends Singleton
{
    private string $featured_image_key;

    public array $list_field = [];

    public array $acf_list_field = [];

    protected function __construct($featured_image_key = 'da_featured_image')
    {
        parent::__construct();
        $this->featured_image_key = $featured_image_key;
    }
}
