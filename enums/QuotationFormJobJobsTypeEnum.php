<?php

namespace app\enums;

enum QuotationFormJobJobsTypeEnum: int {

    case JOB = 1;
    case SPARE_PART = 10;

    /**
     * Instance label for UI display, e.g., "Job", "Spare Part".
     */
    public function label(): string {
        return match ($this) {
            self::JOB => 'Job',
            self::SPARE_PART => 'Spare Part',
        };
    }

}
