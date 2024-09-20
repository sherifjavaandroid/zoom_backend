<div>


    <x-form action="saveNotificationSetting" :noStyle="true">
        <div class="w-full md:w-4/5 lg:w-5/12">
            <x-input title="Firebase Server Key" name="fcmServerKey" :defer="true" />
            <x-input title="Firebase Server Sender ID" name="fcmSenderID" :defer="true" />
            <x-input title="Firebase Server API Key" name="fcmAPIKey" :defer="true" />

            <div class='h-1 mt-5 bg-gray-300 rounded'></div>
            <x-media-upload title="Service Account" name="photo" :photo="$photo" :photoInfo="$photoInfo" :image="false"
                types="JSON" rules="application/JSON" />
            <x-buttons.primary title="Save Changes" />
        </div>
    </x-form>



</div>
