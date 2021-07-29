<?php

namespace Pupuga\Custom\Lighthouse;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Pupuga\Libs\Files\Files as Files;

final class Fields
{
    private static $instance = null;

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action('carbon_fields_register_fields', array($this, 'register'));
    }

    public function register()
    {
        Container::make('post_meta', 'Data of site')
            ->where('post_type', '=', 'site')
            ->add_fields($this->addFields());
    }

    private function addFields(): array
    {
        $fields = DataFields::app()->get();
        $add = array();
        if (is_array($fields) && !empty($fields)) {
            foreach ($fields as $name => $field) {
                $object = Field::make($field['type'], strtolower(str_replace(' ', '_', $name)), $name);
                if ($field['type'] == 'html') {
                    $method = 'getHtml' . ucfirst($name);
                    $object->set_html($this->$method());
                }
                if (!empty($field['default'])) {
                    $object->set_default_value($field['default']);
                }
                if (!empty($field['class'])) {
                    $object->set_classes($field['class']);
                }
                $add[] = $object;
            }
        }

        return $add;
    }

    private function getHtmlGoogle(): string
    {
        if (!empty($_GET['post'])) {
            $url = urlencode(get_the_title($_GET['post']));
            $html = "<a class='button' href='https://developers.google.com/speed/pagespeed/insights/?url={$url}' target='_blank'>Check with google speed</a>";
        }

        return $html ?? '';
    }

    private function getHtmlHistory(): string
    {
        $html = '<strong>History</strong>';
        $history = Site::app()->getHistory();
        $id = $history['id'];
        $items = $history['data'];
        if (is_array($items) && count($items) > 0) {
            $countItems = count($items) + 1;
            foreach ($items as $key => $score) {
                $countItems--;
                $link = Site::app()->getLink($key);
                $classStyle = 'black';
                $classAlertStyle = '';
                $minScore = intval(get_post_meta($id, '_min_score', true));
                if (is_numeric($score)) {
                    $score = intval($score);
                    $parts = explode(' ', $key);
                    $date = (new \DateTime($parts[0]))->format('d.m.Y') . ' ' . $parts[1];
                    $link = "<a href='{$link}' target='_blank'>{$date}</a>";
                    $classAlertStyle = $minScore > $score ? 'background-alert' : $classAlertStyle;
                }
                $circle = Files::getTemplate(__DIR__ . '/templates/circle',
                    array(
                        'minScore' => $minScore,
                        'score' => $score,
                        'stroke' => '2',
                        'radius' => '14'
                    ),false);
                $html .= Files::getTemplate(__DIR__ . '/templates/row',
                    array(
                        'classStyle' => $classStyle,
                        'classAlertStyle' => $classAlertStyle,
                        'countItems' => $countItems,
                        'link' => $link,
                        'circle' => $circle
                    ),false);
            }
            $html = Files::getTemplate(__DIR__ . '/templates/table',
                array(
                    'html' => $html
                ),false);
        }

        return "<div>{$html}</div>";
    }

}