<div wire:init="privacySettings">

    <x-baseview title="Privacy Policy">

        <x-form action="savePrivacyPolicy">
            <div class="w-full md:w-4/5 lg:w-5/12">

                <div class="mb-4">
                    <x-label title="Privacy & Policy" />
                </div>
                <div class="hidden ">
                    <x-input title="" name="privacyPolicy" />
                </div>
                <div wire:ignore>
                    <textarea id="privacyPolicy"></textarea>
                </div>
                <x-buttons.primary title="Save Changes" />

            </div>
        </x-form>

    </x-baseview>

</div>
@push('scripts')
    <script src="{{ asset('js/easymde.min.js') }}"></script>
    <script src="{{ asset('js/privacy.js') }}"></script>
@endpush
