<div>

    @production

        <x-form action="saveAppSettings" :noStyle="true">

            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    {{-- type --}}
                    <x-select title="{{ __('Preferred AI System') }}" name="preferredAISystem" :options="$aiSystems ?? []"
                        :noMargin="true" />
                    {{-- keys --}}
                    <hr class="my-2" />
                    @if ($preferredAISystem == 'openai')
                        <x-input title="{{ __('OpenAI API Key') }}" name="openAIKey" />
                        <x-input title="{{ __('OpenAI Ogranization') }}" name="openAIOrganization" />
                    @endif
                    @if ($preferredAISystem == 'gemini')
                        <x-input title="{{ __('Google Gemini API Key') }}" name="googleGeminiAPIKey" />
                    @endif
                </div>
                {{-- options --}}
                <div>

                    <x-checkbox title="AI Chat" name="aiChatbot" description="{{ __('Enable AI Chatbot') }}" />
                    <x-checkbox title="AI Image Generator" name="aiImageGenerator"
                        description="{{ __('Enable AI Image Generator') }}" />
                    <x-checkbox title="{{ __('Login Required') }}" name="aiLoginRequired"
                        description="{{ __('User must be registered and logged in to use AI') }}" />

                </div>

            </div>
            <x-buttons.primary title="Save Changes" />
        </x-form>
    @else
        <div class="p-12">
            <p class="text-red-500 text-center uppercase">
                {{ __('This page is only available in production mode') }}
            </p>
        </div>

    @endproduction

    <x-loading />
</div>
