<?php

namespace App\Http\Livewire;

use Exception;
use LaravelFCM\Message\Topics;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class NotificationLivewire extends BaseLivewireComponent
{

    public $headings;
    public $message;

    protected $rules = [
        "headings" => "required|string",
        "message" => "required|string",
    ];

    public function render()
    {
        return view('livewire.notification');
    }

    public function sendNotification(){

        $this->validate();
        \Config::set('fcm.http.server_key', setting('fcmServerKey', ""));
        \Config::set('fcm.http.sender_id', setting('fcmSenderID', ""));

        try{

            $notificationBuilder = new PayloadNotificationBuilder( $this->headings );
            $notificationBuilder->setBody( $this->message )
                                ->setSound('default');

            $notification = $notificationBuilder->build();

            $topic = new Topics();
            $topic->topic('all');

            $topicResponse = FCM::sendToTopic($topic, null, $notification, null);

            if( $topicResponse->isSuccess() ){

                $this->showSuccessAlert("Notification sent successful");
                $this->reset();

            }else{
                throw new Exception( $topicResponse->error());
            }

        }catch(Exception $error){

            $this->showErrorAlert( $error->getMessage() ?? "Notification failed");

        }

    }




}
