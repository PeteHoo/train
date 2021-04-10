<?php


namespace App\Utils;


use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class AliTask
{
    private $config;

    public function __construct()
    {
        $this->config = config('ali');
        AlibabaCloud::accessKeyClient($this->config['accessKeyId'], $this->config['accessSecret'])
            ->regionId($this->config['regionId'])
            ->asDefaultClient();
    }

    public function sendMessage($phone, $template, $sign, $ep, $param)
    {
        if (!$template) {
            return false;
        }

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->options([
                    'query' => [
                        'PhoneNumbers' => $phone,
                        'SignName' => $sign,
                        'TemplateCode' => $template,
                        'TemplateParam' => json_encode($param)
                    ],
                ])
                ->request();

            if ($result->Message == 'OK') {
                $data['phone'] = $phone;
                $data['sms_template'] = $template;
                $data['content'] = getMessageContent($ep, $param);
                $ref['result'] = $result->toArray();
                $ref['data'] = $data;
                return $ref;
            }
            return false;

        } catch (ClientException $exception) {
            return false;
        } catch (ServerException $exception) {
            return false;
        }

    }
}
