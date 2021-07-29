<?php

namespace Pupuga\Custom\Lighthouse;

use Pupuga\Libs\Send\Send;

final class CalculateScores
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
        $sites = Sites::app()->get();
        if (is_array($sites) && !empty($sites)) {
            $this->loop($sites);
        }
    }

    private function loop($sites): void
    {
        foreach ($sites as $site) {
            $results = Site::app()->updateHistory($site->ID);
            if($results['warning']) {
                SendingMessage::app()->set($site->ID, $site->post_title, $results['minScore'], $results['score']);
            }
        }
        $message = SendingMessage::app()->get();
        file_put_contents(__DIR__ . '/1.html',  $message);
        //$this->send($message);
    }

    private function Send($message): void
    {
        $to = array_column(get_users( array(
            'role'   => 'administrator',
            'fields' => ['user_email'],
        )), 'user_email');
        $subject = 'Lighthouse Warning';
        (new Send($to, $subject, $message))->mail();
    }

}