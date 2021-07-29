<?php

namespace Pupuga\Custom\Lighthouse;

use Pupuga\Core\Posts\GetPosts;

final class Sites
{
    private static $instance = null;
    private $sites = array();

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(): array
    {
        return $this->sites;
    }

    private function __construct()
    {
        $this->set();
    }

    private function set(): void
    {
        $this->sites = GetPosts::app()
            ->postType('site')
            ->numberPosts(0)
            ->order('DESC')
            ->doAction();
    }
}