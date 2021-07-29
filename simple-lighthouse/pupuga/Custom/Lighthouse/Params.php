<?php

namespace Pupuga\Custom\Lighthouse;

final class Params
{
    private static $instance = null;
    private $historyField = 'history_lighthouse';
    private $shFile = 'run-create-score.sh';
    private $ordersPath = '/orders/';
    private $orderUrl = '';
    private $orderPath = '';
    private $scorePath = '{{id}}/{{date}}';
    private $scoreFile = '{{file}}';

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getHistoryField(): string
    {
        return $this->historyField;
    }

    public function getShFile(): string
    {
        return $this->shFile;
    }

    public function getOrdersPath(): string
    {
        return $this->ordersPath;
    }

    public function getOrderPath(): string
    {
        return $this->orderPath;
    }

    public function getOrderUrl(): string
    {
        return $this->orderUrl;
    }

    public function getScorePath(): string
    {
        return $this->scorePath;
    }

    public function getScoreFile(): string
    {
        return $this->scoreFile;
    }

    private function __construct()
    {
        $this->setOrderUrl();
        $this->setOrderPath();
        $this->setShFile();
        $this->setOrdersPath();
    }

    private function setOrderUrl(): void
    {
        $this->orderUrl = content_url() . $this->ordersPath . $this->scorePath . '/' . $this->scoreFile . '.report';
    }

    private function setOrderPath(): void
    {
        $this->orderPath = WP_CONTENT_DIR . $this->ordersPath . $this->scorePath . '/' . $this->scoreFile . '.report';
    }

    private function setShFile()
    {
        $this->shFile = __DIR__ . '/' . $this->shFile;
    }

    private function setOrdersPath(): void
    {
        $this->ordersPath = WP_CONTENT_DIR . $this->ordersPath;
    }
}