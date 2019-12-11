<?php

namespace DG\Dissertation\Core\Supports;

/**
 * Class PageTitle
 * @package DG\Dissertation\Core\Supports
 */
class PageTitle
{
    /**
     * @var string;
     */
    private $title;

    /**
     * PageTitle constructor.
     */
    public function __construct()
    {
        $this->title = '';
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @param boolean $full
     * @return string
     */
    public function getTitle($full = true): string
    {
        if ($full) {
            return empty($this->title) ?
                config('core.common.app-title-post-fix') :
                $this->title . " | " . config('core.common.app-title-post-fix');
        }
        return empty($this->title) ? config('core.common.app-title-post-fix') : $this->title;
    }
}
