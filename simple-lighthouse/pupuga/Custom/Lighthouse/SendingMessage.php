<?php

namespace Pupuga\Custom\Lighthouse;

final class SendingMessage
{
    private static $instance = null;
    private $home;
    private $message = '';
    private $i = 0;

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(): string
    {
        $tableStyle = '
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 12px;
            text-align: left;
            border-collapse: collapse;
            border-spacing: 0;
        ';
        $headerRowStyle = '
            background-color: #ededed;
        ';
        $headerCellStyle = '
            padding: 8px 10px;
        ';

        return "
            <table style='{$tableStyle}'>
                <tr style='{$headerRowStyle}'>
                    <th style='{$headerCellStyle}'>Number</th>
                    <th style='{$headerCellStyle}'>Site</th>
                    <th style='{$headerCellStyle}'>Min score</th>
                    <th style='{$headerCellStyle}'>Score</th>
                </tr>
                $this->message
            </table>
        ";
    }

    public function set($id, $name, $minScore, $score): void
    {
        $this->i++;
        $rowStyle = '
            background-color: #ffffff;
            padding-bottom: 1px solid #ededed;
        ';
        $cellStyle = '
            padding: 8px 10px;
        ';
        $this->message .= "
            <tr style='{$rowStyle}'>
                <td style='{$cellStyle}'>{$this->i}</td>
                <td style='{$cellStyle}'>
                    <a href='{$this->home}post.php?post={$id}&action=edit' target='_blank'>{$name}</a>
                </td>
                <td style='{$cellStyle}'>
                    {$minScore}
                </td>
                <td style='{$cellStyle}'>
                    {$score}
                </td>
            </tr>
        ";
    }

    private function __construct()
    {
        $this->home = get_admin_url();
    }
}