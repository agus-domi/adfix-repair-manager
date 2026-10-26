<?php

namespace App\Enums;

enum RepairStatus: string
{
    case PENDIENTE = 'pendiente';
    case EN_PROCESO = 'en_proceso';
    case COMPLETADO = 'completado';

    public function label(): string
    {
        return match ($this) {
            self::PENDIENTE => 'Pendiente',
            self::EN_PROCESO => 'En proceso',
            self::COMPLETADO => 'Completado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDIENTE => 'bg-gray-200',
            self::EN_PROCESO => 'bg-yellow-200',
            self::COMPLETADO => 'bg-green-200',
        };
    }

    public static function options(): array
    {
        return array_column(self::cases(), 'value');
    }
}