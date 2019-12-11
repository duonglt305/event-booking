<?php


namespace DG\Dissertation\Admin\Http\Requests;


use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicket extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'cost' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'special_validity' => ['nullable', 'in:amount,date,both'],
            'amount' => ['nullable', 'required_if:special_validity,amount,both', 'numeric', 'integer'],
            'valid_until' => ['nullable', 'required_if:special_validity,date,both', 'date_format:d/m/Y H:i'],
        ];
    }

    public function attributes()
    {
        return [
            'amount' => 'maximum amount of tickets to be sold',
            'date' => 'tickets can be sold until',
        ];
    }

    public function validated()
    {
        $validated = parent::validated();
        return $this->parseSpecialValidity($validated);
    }

    /**
     * @param array $validated
     * @return array
     */
    protected function parseSpecialValidity(array $validated): array
    {
        if (!empty($validated['valid_until']) || !empty($validated['amount'])) {
            $specialValidity = [
                'type' => $validated['special_validity'],
            ];
            if (!empty($validated['valid_until']) && empty($validated['amount'])) {
                $specialValidity['date'] = Carbon::createFromFormat('d/m/Y H:i', $validated['valid_until'])->toDateTimeString();
            } else if (!empty($validated['amount']) && empty($validated['valid_until'])) {
                $specialValidity['amount'] = $validated['amount'];
            } else {
                $specialValidity['date'] = Carbon::createFromFormat('d/m/Y H:i', $validated['valid_until'])->toDateTimeString();
                $specialValidity['amount'] = $validated['amount'];
            }
            $validated['special_validity'] = json_encode($specialValidity);
        }
        return $validated;
    }
}
