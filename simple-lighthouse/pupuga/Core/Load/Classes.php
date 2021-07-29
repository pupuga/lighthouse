<?php

namespace Pupuga\Core\Load;

final class Classes
{
    public static $instance;
    private $classes = '';

    public static function app() : self
    {
        return self::$instance = is_null(self::$instance) ? new self() : self::$instance;
    }

    public function set($classes): void
    {
        $this->classes = $this->classes . ' ' . $classes;
    }

    public function get(): string
    {
        return $this->classes;
    }
}