<?php

namespace Pupuga\Core\Posts;

final class Pagination
{
    private $pagination;

    public function __construct($total, $current, $url = '', $previous = '', $next = '')
    {
        $this->set($total, $current, $url, $previous, $next);
    }

    public function get(): ?string
    {
        return $this->pagination;
    }

    private function set($total, $current, $url, $previous, $next): void
    {
        global $wp;
        $current = $current ?? $wp->query_vars['paged'] ?? 1;
        $args = array(
            'base'         => $url . '%_%',
            'format'       => 'page/%#%/',
            'total'        => $total,
            'current'      => $current,
            'show_all'     => false,
            'end_size'     => 1,
            'mid_size'     => 2,
            'prev_next'    => true,
            'prev_text'    => $previous,
            'next_text'    => $next,
            'type'         => 'plain',
            'add_args'     => false,
            'add_fragment' => '',
            'before_page_number' => '',
            'after_page_number'  => ''
        );

        $this->pagination = paginate_links( $args );
    }
}