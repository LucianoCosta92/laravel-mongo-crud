<?php

namespace App\Enums;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELED = 'canceled';

    public function label(): string
    {
        return match($this){
            self::PENDING => 'Pendente',
            self::IN_PROGRESS => 'Em andamento',
            self::COMPLETED => 'Concluída',
            self::CANCELED => 'Cancelada',
        };
    }

    public function color(): string
    {
        return match($this){
            self::PENDING => 'gray',
            self::IN_PROGRESS => 'blue',
            self::COMPLETED => 'green',
            self::CANCELED => 'red',
        };
    }

}
