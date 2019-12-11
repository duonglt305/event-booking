<?php

namespace DG\Dissertation\Admin\Supports;

/**
 * Class ConstantDefine
 * @author Giang Nguyen
 */
class ConstantDefine
{
    const ARTICLE_STATUS_PUBLISH = 3;
    const ARTICLE_STATUS_HIDE = 2;
    const ARTICLE_STATUS_DRAFT = 1;

    const EVENT_STATUS_PENDING = 0;
    const EVENT_STATUS_ACTIVE = 1;


    /**
     * @return array
     */
    public static function getEventStatus()
    {
        return [
            'pending' => self::EVENT_STATUS_PENDING,
            'active' => self::EVENT_STATUS_ACTIVE
        ];
    }

    /**
     * @return array
     */
    public static function getArticleStatus(): array
    {
        return [
            'publish' => self::ARTICLE_STATUS_PUBLISH,
            'hide' => self::ARTICLE_STATUS_HIDE,
            'draft' => self::ARTICLE_STATUS_DRAFT
        ];
    }
}
