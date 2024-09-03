<?php
namespace App\Http\Requests\BorrowBookRequest;

use Log;
use Mail;
use Illuminate\Validation\Rule;
use App\Rules\DueDateAfterBorrowedAt;
use Illuminate\Foundation\Http\FormRequest;

class BorrowRecordFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   $borrowedAt = $this->input('borrowed_at');
        return [
            'book_id' => 'required|exists:books,id',
            'borrowed_at' => 'required|date|before:due_date',
            'due_date' => [
                'required',
                'date',
                new DueDateAfterBorrowedAt($borrowedAt),
            ],
        ];
    }

    /**
     * Get custom attribute names.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'book_id' => 'Book ID',
            'borrowed_at' => 'Borrowed At',
            'due_date' => 'Due Date',
        ];
    }
    
}
