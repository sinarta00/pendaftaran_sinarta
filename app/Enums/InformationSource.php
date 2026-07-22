<?php
namespace App\Enums;

enum InformationSource: string
{
    case Rekan = 'Rekan';
    case Poster = 'Poster';
    case Banner = 'Banner';
    case Instagram = 'Instagram';
    case Facebook = 'Facebook';
    case Tiktok = 'Tiktok';

    public function label(): string
    {
        return match($this) {
            self::Rekan => 'Rekan/Teman',
            self::Poster => 'Poster',
            self::Banner => 'Banner',
            self::Instagram => 'Instagram',
            self::Facebook => 'Facebook',
            self::Tiktok => 'TikTok',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->all();
    }
}