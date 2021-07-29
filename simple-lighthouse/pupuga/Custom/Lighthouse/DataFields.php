<?php

namespace Pupuga\Custom\Lighthouse;

final class DataFields
{
    public static $instance = null;
    private $fields = array(
        'Min score' => array(
            'type' => 'text',
            'default' => '70',
            'class' => 'cf-field--half'
        ),
        'Google' => array(
            'type' => 'html',
            'class' => 'cf-field--half'
        ),
        'History' => array(
            'type' => 'html',
        ),
    );

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(): array
    {
        return $this->fields;
    }
}