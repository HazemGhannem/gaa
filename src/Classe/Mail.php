<?php


namespace App\Classe;


use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = '3e220b99d463d3419374b9ed1ce34ca5';
    private $api_key_secret = '20e3f650a4b859067aa0ef753f00d691';

    public function send($to_email,$to_name,$subject,$content){
        $mj = new Client($this->api_key , $this->api_key_secret ,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "youssef.rakrouki@ieee.org",
                        'Name' => "Revolgame"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 2614079,
                    'TemplateLanguage' => true,
                    'Subject' => $subject ,
                    'Variables' => [
                        'objet' => $subject,
                        'content' => $content
                    ]

                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() ;
    }

}