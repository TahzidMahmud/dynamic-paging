<?php 
namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self DRAFT()
 * @method static self PUBLISHED()
 * @method static self ARCHIVED()
 */
class ItemNameEnum extends Enum
{
    //
    const SLIDE = 'slide';
    const ARTICLE = 'article';
    const IMAGE = 'image';
    const CARD='card';
}
