<?php

namespace Pupuga\Custom\Lighthouse;

final class Site
{
    private static $instance = null;
    private $id;

    public static function app(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function insertHistory($id, $value): void
    {
        $this->id = $id;
        $data = get_post_meta($id, Params::app()->getHistoryField())[0];
        $data = is_array($data) ? $data : array();
        $data = $value + $data;
        update_post_meta($this->id, Params::app()->getHistoryField(), $data);
    }

    public function updateHistory($id): array
    {
        $result = array(
            'warning' => true,
        );;
        $this->id = $id;
        $history = $this->getHistory()['data'];
        if (is_array($history) && !empty($history > 0)) {
            $minScore = $this->getMinScore();
            $firstKey = array_key_first($history);
            $firstKeyParts = explode(' ', $firstKey);
            $patterns = array(
                '{{id}}' => $id,
                '{{date}}' => $firstKeyParts[0],
                '{{file}}' => $firstKeyParts[1]
            );
            $object = json_decode(file_get_contents(str_replace(array_keys($patterns), array_values($patterns),Params::app()->getOrderPath() . '.json')));
            $score = $object->categories->performance->score * 100;
            $history[$firstKey] = $score;
            $warning = $minScore > intval($score);
            update_post_meta($this->id, Params::app()->getHistoryField(), $history);

            $result = array(
                'warning' => $warning,
                'minScore' => $minScore,
                'score' => $score,
            );
        }

        return $result;
    }

    public function getHistory(): ?array
    {
        $data = array();
        $id = $this->id ?: get_the_ID();
        if (!empty($id)) {
            $data = get_post_meta($id, Params::app()->getHistoryField())[0];
        }
        return array(
            'id' => $id,
            'data' => $data
        );
    }

    public function getMinScore(): int
    {
        $id = $this->id ?: get_the_ID();
        return intval(get_post_meta($id, '_min_score', true));
    }

    public function getScore(): int
    {
        return intval(array_shift($this->getHistory()['data']));
    }

    public function getScores(): array
    {
        return array(
            'score' => $this->getScore(),
            'minScore' => $this->getMinScore()
        );
    }

    public function getLink($date = null): string
    {
        $date = $date ?? array_key_first($this->getHistory()['data']);
        $keyParts = explode(' ', $date);
        $patterns = array(
            '{{id}}' => $this->id ?: get_the_ID(),
            '{{date}}' => $keyParts[0],
            '{{file}}' => $keyParts[1]
        );
        return str_replace(array_keys($patterns), array_values($patterns), Params::app()->getOrderUrl() . '.html');
    }

    private function __construct()
    {
        $this->id = (isset($_GET['post']) && is_numeric($_GET['post'])) ? intval($_GET['post']) : 0;
    }
}