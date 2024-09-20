<div>
    <div wire:ignore>
        @php
            if (empty($inputId)) {
                $inputId = $model ?? 'phone';
                $inputId .= rand(1000, 99999);
            }
            $modelId = $model ?? 'phone';
            $defaultCountry = setting('countryCode', 'GH');
            //explode default country code and select the last part
            $defaultCountry = explode(',', $defaultCountry);
            $defaultCountry = end($defaultCountry) ?? 'US';
            //if value is longer than 2 letters, then switch to US
            if (strlen($defaultCountry) > 2) {
                $defaultCountry = 'US';
            }

            $phoneInitData = [$inputId, $modelId, $value ?? '', $defaultCountry];
        @endphp
        <div class="phoneInitDiv" data-value="{{ json_encode($phoneInitData) }}">
            <x-label title="{{ $title ?? __('Phone') }}" />
            <x-input id="{{ $inputId }}" name="{{ $modelId }}" />
            <input wire:model="{{ $modelId }}" type="hidden" id="{{ $modelId }}" name="{{ $modelId }}"
                value="{{ $value ?? '' }}" />
        </div>
    </div>
    <span class="mt-1 text-xs text-red-700">{{ $errors->first($modelId) }}</span>
</div>

{{-- push css styles --}}
@push('styles')
    <style>
        .intl-tel-input {
            width: 100% !important;
        }

        .iti {
            width: 100% !important;
        }

        .iti.iti--allow-dropdown {
            width: 100%
        }
    </style>
@endpush
