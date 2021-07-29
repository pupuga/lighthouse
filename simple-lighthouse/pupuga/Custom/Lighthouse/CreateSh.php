<?php

namespace Pupuga\Custom\Lighthouse;

final class CreateSh
{
    private static $instance = null;
    private $scoreFilePath = '';
    private $command = 'lighthouse {{url}} --quiet --no-enable-error-reporting --skip-audits --chrome-flags="--headless --disable-gpu --no-sandbox --disable-dev-shm-usage --ignore-certificate-errors" --only-categories="performance" --form-factor="mobile" --output json --output html --output-path="{{path}}"';

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
            $this->clearShFile();
            $this->loop($sites);
        }
    }

    private function loop($sites): void
    {
        $date = date('y.m.d');
        $time = date('G:i:s');
        $patterns = array(
            '{{date}}' => $date,
            '{{file}}' => $time
        );
        foreach ($sites as $site) {
            $patterns['{{id}}'] = $site->ID;
            Site::app()->insertHistory($site->ID, array($date . ' ' . $time => ''));
            $this->checkFolders(array_keys($patterns), array_values($patterns));
            $this->fillFile($site);
        }
    }

    private function clearShFile(): void
    {
        file_put_contents(Params::app()->getShFile(), null);
        $this->addToShFile('#!/bin/bash');
    }

    private function checkFolders($keys, $values): void
    {
        $dir = str_replace($keys, $values, Params::app()->getOrdersPath() . Params::app()->getScorePath() . '/');
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $this->scoreFilePath = $dir . str_replace($keys, $values, Params::app()->getScoreFile());
    }

    private function fillFile($site): void
    {
        $patterns = array(
            '{{url}}' => $site->post_title,
            '{{path}}' => $this->scoreFilePath
        );
        $line = str_replace(array_keys($patterns), array_values($patterns), $this->command);
        $this->addToShFile($line);
    }

    private function addToShFile(string $line): void
    {
        $line = $line . " \n";
        file_put_contents(Params::app()->getShFile(), $line, FILE_APPEND | LOCK_EX);
    }
}