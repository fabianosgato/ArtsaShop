<?php

namespace Modules\Eav\Enums;

enum FrontendInputType: string
{
    case BOOLEAN = 'boolean';
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case SELECT = 'select';
    case MULTISELECT = 'select-options';

    public function hasOptions(): bool
    {
        return match ($this) {
            self::SELECT,
            self::MULTISELECT => true,

            default => false,
        };
    }

    public function hasDefaultValue(): bool
    {
        return match ($this) {
            self::TEXT,
            self::TEXTAREA,
            self::BOOLEAN => true,

            default => false,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::BOOLEAN => 'Sim/Não',
            self::TEXT => 'Texto',
            self::TEXTAREA => 'Área de Texto',
            self::SELECT => 'Seleção Simples (dropdown)',
            self::MULTISELECT => 'Seleção Múltipla',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $case) => [
                $case->value => $case->label(),
            ])
            ->all();
    }
}
