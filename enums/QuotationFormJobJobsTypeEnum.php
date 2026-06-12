<?php

namespace app\enums;

enum QuotationFormJobJobsTypeEnum: int {

    case JOB = 1;
    case SPARE_PART = 10;

    /**
     * Instance label for UI display, e.g., "Job", "Spare Part".
     */
    public function label(): string
    {
        return match ($this) {
            self::JOB => 'Job',
            self::SPARE_PART => 'Spare Part',
        };
    }

    /**
     * Static helper to get label by raw value coming from request/DB.
     * Falls back to 'Unknown' when the value is not a valid enum case.
     */
    public static function labelOf(int|string|null $value): string
    {
        $intVal = is_null($value) ? null : (int)$value;
        $case = is_null($intVal) ? null : self::tryFrom($intVal);
        return $case?->label() ?? 'Unknown';
    }
}
