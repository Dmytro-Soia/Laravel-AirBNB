<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DateValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $dates = explode(' to ', $value);

        if (count($dates) !== 2) {
            $fail('Please choose start reservation and end reservation date');
            return;
        }

        [$reserved_at, $expired_at] = $dates;

        request()->merge(['reserved_at' => $reserved_at, 'expired_at' => $expired_at]);
    }
}
