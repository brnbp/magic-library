<?php

use Phalcon\Mvc\Model;

class Images extends \Phalcon\Mvc\Model
{
    public function getImage($param, $multiverseid)
    {
        $img = "http://magiccards.info/scans/pt/$param.jpg";

        if ($this->verifyCurl($img)) {
            return $img;
        }

        return $this->getImageSD($multiverseid);

    }

    /*public function getImageHD($multiverseId)
    {
        $img = "http://api.mtgdb.info/content/hi_res_card_images/$multiverseId.jpg";

        if ($this->verifyCurl($img)) {
            return $img;
        }

        return $this->getImageSD($multiverseId);
    }*/

    public function getImageSD($multiverseId)
    {
        $img = "http://api.mtgdb.info/content/card_images/$multiverseId.jpeg";

        if ($this->verifyCurl($img)) {
            return $img;
        }

        return false;
    }

    private function verifyCurl($url)
    {
        // Inicia o Curl com a url desejada
        $cURL = curl_init($url);

        // Define a opção que diz que você quer receber o resultado encontrado
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

        // Executa a consulta, conectando-se ao site e salvando o resultado na variável $resultado
        curl_exec($cURL);

        // Pega o código de resposta HTTP
        $resposta = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

        // Encerra a conexão com o site
        curl_close($cURL);

        if ($resposta == 404) {
            return false;
        } else {
            return true;
        }

    }



}