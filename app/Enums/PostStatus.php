<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PostStatus extends Enum
{
    const PUBLISHED = 'published';
    const DRAFT = 'draft';

    public static function getDescription($value): string
    {
        if ($value == self::PUBLISHED) {
            return __('Published');
        }

        if ($value == self::DRAFT) {
            return __('Draft');
        }

        return parent::getDescription($value);
    }
}
