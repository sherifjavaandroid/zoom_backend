<div>

    <x-form action="saveAppSettings" :noStyle="true">

        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div>
                <x-input title="Website Name" name="websiteName" />
                <div>
                    <x-input title="Website Color" name="websiteColor" type="color" class="h-10" />
                    <p class="text-sm text-gray-500">Note: You will need to refresh the page for the color to take
                        effect</p>
                </div>
                <div>
                    <x-input title="Phone Country Code (Country of operations)" name="countryCode" />
                    <a href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2" target="_blank"
                        class="mt-1 text-xs text-gray-500 underline">List Of Country Codes</a>
                </div>

            </div>

            <div>
                {{-- logo --}}
                <div class="flex items-center mt-5 space-x-10">
                    <img src="{{ $websiteLogo != null ? $websiteLogo->temporaryUrl() : $oldWebsiteLogo }}"
                        class="w-24 h-24 rounded" />
                    <x-input title="Website Logo" name="websiteLogo" :defer="false" type="file" />
                </div>

                {{-- favicon --}}
                <div class="flex items-center mt-5 space-x-10">
                    <img src="{{ $favicon != null ? $favicon->temporaryUrl() : $oldFavicon }}"
                        class="w-24 h-24 rounded" />
                    <x-input title="Website Favicon" name="favicon" :defer="false" type="file" />
                </div>

                {{-- loginImage --}}
                <div class="flex items-center mt-5 space-x-10">
                    <img src="{{ $loginImage != null ? $loginImage->temporaryUrl() : $oldLoginImage }}"
                        class="w-24 h-24 rounded" />
                    <x-input title="Login Image" name="loginImage" :defer="false" type="file" />
                </div>

                {{-- registerImage --}}
                <div class="flex items-center mt-5 space-x-10">
                    <img src="{{ $registerImage != null ? $registerImage->temporaryUrl() : $oldRegisterImage }}"
                        class="w-24 h-24 rounded" />
                    <x-input title="Register Image" name="registerImage" :defer="false" type="file" />
                </div>
            </div>

        </div>
        <x-buttons.primary title="Save Changes" />
    </x-form>



</div>
