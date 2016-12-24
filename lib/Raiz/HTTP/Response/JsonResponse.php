<?php

namespace Raiz\HTTP\Response;

class JsonResponse {

    private $expiresSeconds = 0;

    /*
     * 
     */

    public final function setExpires(int $seconds = 0) {
        $this->expiresSeconds = $seconds;
        return $this;
    }

    /*
     * 
     */

    public final function send(array $data = []) {
        $this->sendExpiresHeaders();
        $data = \json_encode($data) . \str_repeat(" ", 256);
        header("Content-type: application/json; charset=UTF-8");
        header('Content-Length: ' . \strlen($data));
        die($data);
    }

    /*
     * 
     */


    private function sendExpiresHeaders() {
        if ($this->expiresSeconds) {
            $seconds = \time() + $this->expiresSeconds;
            $str = 'Expires: ' . \gmdate('D, d M Y H:i:s', $seconds) . ' GMT';
            \header($str);
            \header("Cache-Control: max-age={$this->expiresSeconds}");
        } else {// never cache, no-cache implies must-revalidate after 0 seconds.
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');
        }
    }

}
