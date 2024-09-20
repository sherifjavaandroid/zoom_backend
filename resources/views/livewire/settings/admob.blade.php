<div>



    <x-form action="save" :noStyle="true">

        <p class="text-gray-600 text-sm">You can get your Admob App ID and Ad unit ID from your Admob account.
            <a href="https://support.google.com/admob/answer/7356431?hl=en" target="_blank"
                class="text-blue-600 hover:underline">Learn More</a>
        </p>
        <div class="h-4"></div>

        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-lg">Android</p>
                <x-input title="App ID" name="app_id" />
                <x-input title="Banner Ad unit ID" name="banner_ad_id" />
                <x-input title="Interstitial Ad unit ID" name="interstitial_ad_id" />
                <x-checkbox title="Enable" name="ad_enable" :defer="false" />

            </div>
            <div>
                <p class="text-gray-600 text-lg">iOS</p>
                <x-input title="App ID" name="ios_app_id" />
                <x-input title="Banner Ad unit ID" name="ios_banner_ad_id" />
                <x-input title="Interstitial Ad unit ID" name="ios_interstitial_ad_id" />
                <x-checkbox title="Enable" name="ios_ad_enable" :defer="false" />
            </div>
        </div>
        <x-buttons.primary title="Save Changes" />
    </x-form>


    <x-loading />

</div>
