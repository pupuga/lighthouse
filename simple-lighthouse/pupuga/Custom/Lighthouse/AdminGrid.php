<?php

namespace Pupuga\Custom\Lighthouse;

use Pupuga\Libs\Files\Files as Files;

final class AdminGrid
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
        add_filter( 'manage_site_posts_columns', array($this, 'addColumns'));
        add_action( 'manage_site_posts_custom_column', array($this, 'setColumnValue'));
    }

    public function addColumns($columns): array
    {
        $addition = array(
            'score'    => 'Score',
            'minScore'    => 'Min score',
            'link'    => 'Google link',
        );

        $firsts = array_slice($columns, 0, 2);
        $others = array_slice($columns, 2);

        return $firsts + $addition + $others;
    }

    public function setColumnValue($name): void
    {
        switch ($name) {
            case 'score':
                $this->setColumnScore();
                break;
            case 'minScore':
                $this->setColumnMinScore();
                break;
            case 'link':
                $this->setColumnLink();
                break;
        }
    }

    private function setColumnLink(): void
    {
        $url = get_the_title();
        echo "<a class='button' href='https://developers.google.com/speed/pagespeed/insights/?url={$url}' target='_blank'>Check with google speed</a>";
    }

    private function setColumnScore(): void
    {
        $scores = Site::app()->getScores();
        Files::getTemplate(__DIR__ . '/templates/circle',
            array(
                'minScore' => $scores['minScore'],
                'score' => $scores['score'],
                'stroke' => '2',
                'radius' => '20',
                'link' => Site::app()->getLink()
            ),true);
    }

    private function setColumnMinScore(): void
    {
        $minScore = Site::app()->getScores()['minScore'];
        $score = Site::app()->getScores()['score'];
        $warningClass = $minScore > $score ? 'red' : '';
        echo "<div class='{$warningClass}'>{$minScore}</div>";
    }
}