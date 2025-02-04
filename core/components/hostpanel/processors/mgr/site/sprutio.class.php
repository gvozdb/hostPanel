<?php

/**
 * Sprut.io auth
 */
class hostPanelSprutioAuthProcessor extends modObjectProcessor
{
    public $objectType = 'hostPanelSite';
    public $classKey = 'hostPanelSite';
    public $languageTopics = ['hostpanel'];
    //public $permission = 'remove';

    /**
     * @return array|string
     */
    public function process()
    {
        if (!$this->checkPermissions()) {
            return $this->failure($this->modx->lexicon('access_denied'));
        }
        if (!$id = (int)$this->getProperty('id')) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_ns'));
        }

        /** @var hostPanelSite $object */
        if (!$object = $this->modx->getObject($this->classKey, $id)) {
            return $this->failure($this->modx->lexicon('hostpanel_site_err_nf'));
        }

        //
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://' . $this->modx->getOption('hostpanel_host_domain') . ':9443/auth',
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'login' => $object->get('sftp_user'),
                'password' => $object->get('sftp_pass'),
                'language' => 'ru',
            ]),
        ]);
        $response = curl_exec($curl);
        if ($errno = curl_errno($curl)) {
            $response = [
                'errorCode' => $errno,
                'errorMessage' => curl_error($curl),
            ];

            return $this->failure(print_r($response, 1), $response);
        }
        curl_close($curl);

        $cookies = [];
        if (preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $response, $matches)) {
            foreach ($matches[1] as $v) {
                parse_str($v, $cookie);
                $cookies = array_merge($cookies, $cookie);
            }
        }
        if (!empty($cookies['token'])) {
            $cookies['token'] = substr($cookies['token'], 1, -1);
            setrawcookie('token', $cookies['token'], time() + 31556926, '/');
        }

        return $this->success();
    }
}

return 'hostPanelSprutioAuthProcessor';