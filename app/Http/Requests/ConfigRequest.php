<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'MoneySymbol' => ['nullable', 'string', 'max:3'],
            'MoneyLowLimitToCreate' => ['nullable', 'numeric', 'min:0'],
            'MoneyAdaptLowValuesOnCreation' => ['nullable', 'boolean'],
            'MoneyLimitThatNeedsAuthorization' => ['nullable', 'numeric', 'min:0'],
            'MoneyLimitAbsolute' => ['nullable', 'numeric', 'min:0'],
            'MoneyLimitInTypeBets' => ['nullable', 'boolean'],
            'MoneyDenomination' => ['nullable', 'numeric', 'min:0'],
            'RoundPartialPrizes' => ['nullable', 'boolean'],
            'RoundPartialPrizesValue' => ['nullable', 'numeric', 'min:0'],
            'NumberOfDigits' => ['nullable', 'integer', 'min:0', 'max:255'],
            'NewTicketNumberFormat' => ['nullable', 'boolean'],
            'HeaderOfTicketNumber' => ['nullable', 'string', 'max:8'],
            'HoursBetweenAutopurges' => ['nullable', 'integer', 'min:0'],
            'NumberOfEventsToAutopurge' => ['nullable', 'integer', 'min:0'],
            'DaysToAutopurgeIfEventOlderThan' => ['nullable', 'integer', 'min:0'],
            'LastAutopurgeTimestamp' => ['nullable', 'date'],
            'AvatarsCachePath' => ['nullable', 'string', 'max:1024'],
            'AdvancedGUI' => ['nullable', 'boolean'],
            'ForceAllowExports' => ['nullable', 'boolean'],
            'ExpirationDate' => ['nullable', 'date'],
            'LastAutoexpireTimestamp' => ['nullable', 'date'],
            'TITOTitle' => ['nullable', 'string', 'max:64'],
            'TITOTicketType' => ['nullable', 'string', 'max:32'],
            'TITOStreet' => ['nullable', 'string', 'max:64'],
            'TITOPlace' => ['nullable', 'string', 'max:32'],
            'TITOCity' => ['nullable', 'string', 'max:32'],
            'TITOPostalCode' => ['nullable', 'string', 'max:8'],
            'TITODescription' => ['nullable', 'string', 'max:8'],
            'TITOExpirationType' => ['nullable', 'boolean'],
            'NumberOfItemsPerPage' => ['nullable', 'integer', 'min:0'],
            'BackupDBPath' => ['nullable', 'string', 'max:1024'],
            'HoursBetweenBackupDB' => ['nullable', 'integer', 'min:0'],
            'DaysToKeepBackupDB' => ['nullable', 'integer', 'min:0'],
            'Aux1Limit' => ['nullable', 'numeric'],
            'Aux2Limit' => ['nullable', 'numeric'],
            'Aux3Limit' => ['nullable', 'numeric'],
            'Aux4Limit' => ['nullable', 'numeric'],
            'Aux5Limit' => ['nullable', 'numeric'],
            'Aux6Limit' => ['nullable', 'numeric'],
            'Aux7Limit' => ['nullable', 'numeric'],
            'Aux8Limit' => ['nullable', 'numeric'],
            'Aux9Limit' => ['nullable', 'numeric'],
            'Aux10Limit' => ['nullable', 'numeric'],
            'HideOnTCFilter' => ['nullable', 'string'],
            'ShowCloseOnlyFromIPs' => ['nullable', 'string', 'max:1024', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'AllowIPs' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'BanIPs' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'AutoAddIPsToBan' => ['nullable', 'boolean'],
            'AllowMACs' => ['nullable', 'string', 'regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})([,.\s]*([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2}))*$/'],
            'BanMACs' => ['nullable', 'string', 'regex:/^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})([,.\s]*([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2}))*$/'],
            'AutoAddMACsToBan' => ['nullable', 'boolean'],
            'AllowTicketTypes' => ['nullable', 'string'],
            'BanTicketTypes' => ['nullable', 'string'],
            'OnCloseTicketTypeFilter1' => ['nullable', 'string'],
            'OnCloseTicketTypeAllowIPs1' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeBanIPs1' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeIPCreation1' => ['nullable', 'boolean'],
            'OnCloseTicketTypeFilter2' => ['nullable', 'string'],
            'OnCloseTicketTypeAllowIPs2' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeBanIPs2' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeIPCreation2' => ['nullable', 'boolean'],
            'OnCloseTicketTypeFilter3' => ['nullable', 'string'],
            'OnCloseTicketTypeAllowIPs3' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeBanIPs3' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeIPCreation3' => ['nullable', 'boolean'],
            'OnCloseTicketTypeFilter4' => ['nullable', 'string'],
            'OnCloseTicketTypeAllowIPs4' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeBanIPs4' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeIPCreation4' => ['nullable', 'boolean'],
            'OnCloseTicketTypeFilter5' => ['nullable', 'string'],
            'OnCloseTicketTypeAllowIPs5' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeBanIPs5' => ['nullable', 'string', 'regex:/^(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}(?:[.,\s]+\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})*)?$/'],
            'OnCloseTicketTypeIPCreation5' => ['nullable', 'boolean'],
        ];

        return $rules;
    }

    public function messages(): array
    {
        return [
            'ShowCloseOnlyFromIPs.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'AllowIPs.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'BanIPs.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'AllowMACs.regex' => 'El campo :attribute debe contener direcciones MAC válidas separadas por comas o puntos.',
            'BanMACs.regex' => 'El campo :attribute debe contener direcciones MAC válidas separadas por comas o puntos.',
            'OnCloseTicketTypeAllowIPs1.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'OnCloseTicketTypeBanIPs1.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'OnCloseTicketTypeAllowIPs2.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'OnCloseTicketTypeBanIPs2.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'OnCloseTicketTypeAllowIPs3.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'OnCloseTicketTypeBanIPs3.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'OnCloseTicketTypeAllowIPs4.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'OnCloseTicketTypeBanIPs4.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'OnCloseTicketTypeAllowIPs5.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
            'OnCloseTicketTypeBanIPs5.regex' => 'El campo :attribute debe contener direcciones IP válidas separadas por comas o puntos.',
        ];
    }
}
