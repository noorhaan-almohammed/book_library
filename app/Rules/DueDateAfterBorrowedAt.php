<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class DueDateAfterBorrowedAt implements Rule
{
    protected $borrowedAt;

    /**
     * Create a new rule instance.
     *
     * @param string $borrowedAt
     * @return void
     */
    public function __construct($borrowedAt)
    {
        $this->borrowedAt = Carbon::parse($borrowedAt);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $dueDate = Carbon::parse($value);
        return $dueDate->lessThanOrEqualTo($this->borrowedAt->addDays(14));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The due date must be at least 14 days after the borrowed date.';
    }
}
