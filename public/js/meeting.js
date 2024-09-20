$(function () {

    livewire.on('startMeeting', (domain, meetingId, meetingTitle, displayName, myId, isMine, bgColor) => {

        var mInterfaceConfigOverwrite = {};
        var mConfigOverwrite = {};
        //admin participant role
        if (isMine) {
            mInterfaceConfigOverwrite = {
                TILE_VIEW_MAX_COLUMNS: 4,
                HIDE_INVITE_MORE_HEADER: true,
                MOBILE_APP_PROMO: false,
                DEFAULT_BACKGROUND: bgColor,
                SHARING_FEATURES: [],
                //
                CLOSE_PAGE_GUEST_HINT: false,
                SETTINGS_SECTIONS: ["language", "profile", "calendar", "sounds"],
            }
            //
            mConfigOverwrite = {
                hiddenPremeetingButtons: ["invite"],
                disableInviteFunctions: false,
                hideLobbyButton: false,
                subject: meetingTitle,
                toolbarButtons: [
                    "camera",
                    "chat",
                    "closedcaptions",
                    "desktop",
                    "download",
                    "embedmeeting",
                    "etherpad",
                    "feedback",
                    "filmstrip",
                    "fullscreen",
                    "hangup",
                    "help",
                    "invite",
                    "livestreaming",
                    "microphone",
                    "mute-everyone",
                    "mute-video-everyone",
                    "participants-pane",
                    "profile",
                    "raisehand",
                    "recording",
                    "security",
                    "select-background",
                    "settings",
                    "shareaudio",
                    "sharedvideo",
                    "shortcuts",
                    "stats",
                    "tileview",
                    "toggle-camera",
                    "videoquality",
                    "__end",
                ],
                remoteVideoMenu: {
                    // If set to true the 'Kick out' button will be disabled.
                    disableKick: false,
                    // If set to true the 'Grant moderator' button will be disabled.
                    disableGrantModerator: false,
                },
                disableRemoteMute: false,
                startWithAudioMuted: true,
                startWithVideoMuted: true,
                liveStreamingEnabled: true,
                fileRecordingsEnabled: true,
            };
        }
        //regular participant role
        else {
            //
            mInterfaceConfigOverwrite = {
                TILE_VIEW_MAX_COLUMNS: 4,
                HIDE_INVITE_MORE_HEADER: true,
                MOBILE_APP_PROMO: false,
                DEFAULT_BACKGROUND: bgColor,
                SHARING_FEATURES: [],
                //
                CLOSE_PAGE_GUEST_HINT: false,
                SETTINGS_SECTIONS: ["language", "profile", "calendar", "sounds"],
            }
            //
            mConfigOverwrite = {
                hiddenPremeetingButtons: ["invite"],
                disableInviteFunctions: true,
                hideLobbyButton: true,
                subject: meetingTitle,
                toolbarButtons: [
                    "camera",
                    "chat",
                    "desktop",
                    "etherpad",
                    "filmstrip",
                    "fullscreen",
                    "hangup",
                    "help",
                    "livestreaming",
                    "microphone",
                    "raisehand",
                    "recording",
                    "select-background",
                    "stats",
                    "tileview",
                    "toggle-camera",
                    "videoquality",
                    "__end",
                ],
                remoteVideoMenu: {
                    disableKick: true,
                    disableGrantModerator: true,
                },
                disableRemoteMute: true,
                startWithAudioMuted: true,
                startWithVideoMuted: true,
                liveStreamingEnabled: false,
                fileRecordingsEnabled: false,
            };
        }


        const options = {
            roomName: meetingId,
            parentNode: document.querySelector("#meeting"),
            userInfo: {
                id: myId,
                displayName: displayName,
                role: isMine ? "moderator" : "participant",
            },
            interfaceConfigOverwrite: mInterfaceConfigOverwrite,
            configOverwrite: mConfigOverwrite,
            onload: function () {
                console.log("Meeting loaded");
            },
        };


        const api = new JitsiMeetExternalAPI(domain, options);

        api.addListener("readyToClose", (value) => {
            console.log("Rady to close the meeting");
            console.log(value);
        });
        api.addListener("videoConferenceLeft", (value) => {
            window.close();
        });


    });
});
