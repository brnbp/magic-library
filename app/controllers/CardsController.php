    <?php

use Phalcon\Mvc\Controller;

class CardsController extends \Phalcon\Mvc\Controller
{
    /**
     * @cardsModel Object Model Class Cards
     */
    private $cardsModel;

    /**
     * Construtir valida se usuario esta logado
     * caso nao esteja, redireciona para tela de login
     */
    public function onConstruct()
    {
        $this->cardsModel = new Cards();
        $this->cardsModel->setDb($this->db);
    }

    /**
     * Responsavel por receber as cartas de acordo com filtros
     * e enviar para view
     */
    public function indexAction()
    {
        $request = new \Phalcon\Http\Request();

        $session_active = false;
        if ($this->dispatcher->getParam('wishlist')) {
            $cardsCollection = $this->getWishlistCards();
        } else {
            $cardsCollection = $this->definePostType($request);
        }

        if ($this->session->has("user_name")) {
            $session_active = true;
        }
        
        $this->view->setVars(array(
            'cardsCollection' => $cardsCollection,
            'session_active' => $session_active
        ));
    }

    /**
     * Verify what kind of post/form was sended
     *  and send the infos about the cards with or without filters
     * @param object $request bring post/get requests
     * @return array with cards data
     */
    private function definePostType($request)
    {
        if ($request->getPost('artist_name')) {
            return $this->getCardsByArtist($request->getPost('artist_name'));

        } elseif ($request->getPost('card_name')) {
            return $this->getCardsByName($request->getPost('card_name'));

        } else {
            $getPost = $request->getPost();
            return $this->getCollectionByFilter($getPost);
        }
    }

    /**
     * Get WIshlist Cards
     */
    private function getWishlistCards()
    {
        $user_id = $this->session->get('user_id');

            $multiverseid = $this->cardsModel->getAllWishCardsFromUserId($user_id);

        if (empty($multiverseid)) {
        	echo '<h1>Wishlist: </h1><br><h4 style="margin-left: 150px; color: #F04124">Não existem cartas na wishlist</h4>';
        	$this->view = false;
        	exit();
        }

        foreach($multiverseid as $card) {
            $cards .= $card['id_multiverseid'];
            $cards .= ', ';
        }
        $card = null;

        $cards = substr($cards, 0, -2);

        $retorno = $this->cardsModel->getWishlistCards($cards);

        $cards = null;

        foreach ($retorno as $key => $card) {
            $card['imagem'] = $this->getImageCard($card);
            $cards['cards'][] = $card;
        }

        $cards['wishlist'] = true;

        return $cards;
    }

    public function wishedCardAction()
    {
        $request = new \Phalcon\Http\Request();
        $multiverseid = $request->getPost('multiverseid');
        $user_id = $this->session->get('user_id');

        if ($request->getPost('wishlistaddcard')) {
            $this->setWishedCard($user_id, $multiverseid);
        } elseif ($request->getPost('wishlistdelcard')) {
            $this->unsetWishedCard($user_id, $multiverseid);
        }
        
    }

    private function setWishedCard($user_id, $multiverseid)
    {
        try {
            if ($this->cardsModel->gravarWishedCard($user_id, $multiverseid) == false) {
                echo '2';
            } else {
               echo '1';
            }

        } catch (Exception $ex) {
            //retorna 0 para no sucesso do ajax saber que foi um erro
            echo '0';
        }
    }

    private function unsetWishedCard($user_id, $multiverseid)
    {
        try {
            $this->cardsModel->deletarWishedCard($user_id, $multiverseid);
            echo '1';

        } catch (Exception $ex) {
            echo '0';
        }
    }


    /**
     * Responsavel por reunir informações das cartas de acordo com filtros
     * @param array $filters filtros para seleção de cartas
     * @return mixed redirect to index or cards data
     */
    private function getCollectionByFilter(Array $filters)
    {
        extract($filters);

        $colors = $this->cardsModel->getAllColors();

        if (!empty($col) && !empty($color) && !empty($mana)) {
            if ($col == 0 || !in_array($color, $colors) || $mana < 1 || $mana > 8) {
                return header("Location: ../");
            }

            return $this->getCards($col, $color, $mana);

        } elseif (!empty($col) && !empty($color)) {
            if ($col == 0 || !in_array($color, $colors)) {
                return header("Location: ../");
            }

            return $this->getCards($col, $color);

        } elseif (!empty($col) && !empty($mana)) {
            if ($col == 0 || $mana < 1 || $mana > 8) {
                return header("Location: ../");
            }

            return $this->getCards($col, null, $mana);     
        
        } elseif (!empty($col) && $col != 0) {
            return $this->getCards($col);
        }

        return header("Location: ../");
    }

    /**
     * Call to model Cards to get data about cards with filters
     * @param integer $id_collection
     * @param integer | null $color
     * @param integer | null $mana
     * @return array with cards data
     */
    private function getCards($id_collection, $color = null, $mana = null)
    {
        $params['id_collection'] = $id_collection;
        $params['order'] = 'c.number';
        $params['limit'] = '9'; 
    
        if (!is_null($color)) {
            $params['color'] = $color;
        }

        if (!is_null($mana)) {
            $params['mana'] = $mana;
        }

        $cartas = $this->cardsModel->getCardsFromCollection($params);

        $deck = $this->cardsModel->getDeck($id_collection);

        $cardsWithImages['cards'] = $this->getCardsFullInfos($cartas);
            
        $cardsWithImages['deck'] = $deck;

        return $cardsWithImages;
    }

    /**
     * Get cards with filter by artist name
     * @param string $artist_name
     * @return array with cards with selected filter
     */
    private function getCardsByArtist($artist_name)
    {
        $artist_cards = $this->cardsModel->getArtistCards($artist_name);
        $cardsCollection['artist_name'] = $artist_name;
        $cardsCollection['cards'] = $this->getCardsFullInfos($artist_cards);

        return $cardsCollection;
    }

    /**
     * Get cards with filter by name
     * @param string $card_name
     * @return array |redirect array with cards with selected filter
     */
    private function getCardsByName($card_name)
    {

    	$card_name = trim($card_name);
        if (($card = $this->cardsModel->getCardsByName($card_name)) == false) {

            return header("Location: ../");
        }

        $ret['cards'][0] = $card;
        $ret['cards'][0]['imagem'] =  $this->getImageCard($card);
        $ret['deck'] = $this->cardsModel->getDeck($ret['cards'][0]['id_collection']);

        return $ret;
    }

    /**
     * get selected cards with specific formated array
     * @param $cards array com todas as cartas a serem organizadas
     * @return array com todas as cartas organizadas em array de especifico formato
     */
    private function getCardsFullInfos($cards)
    {   
        $fullCards = array();
        foreach ($cards as $card) {
            if (isset($fullCards[$card['multiverseid']])) {
                continue;
            }
            $fullCards[$card['multiverseid']] = $card;
            $fullCards[$card['multiverseid']]['imagem'] = $this->getImageCard($card);
        }

        return $fullCards;
    }

    /**
     * @param $card array with data card
     * @return string with image card url
     */
    private function getImageCard($card)
    {
        $images = new Images();
        $param = $card['info_code'].'/'.$card['number'];
        $image_card = $images->getImage($param, $card['multiverseid']);

        return $image_card;
    }


    /**
    *   METODO PARA ATUALIZAR PREÇOS DE CARTAS
    *
    **/
    public function updatePricesAction()
    {
        //$select = "SELECT name, multiverseid FROM cards WHERE price_updated_in < INSERIR AQUI DATA 2 DIAS ATRAS";
        $select = "SELECT name, multiverseid FROM cards order by id_collection desc limit 500 ";
        $ret = $this->db->fetchAll($select, Phalcon\Db::FETCH_ASSOC);

        foreach($ret as $card) {
            extract($card);
            $price_card = $this->getPriceCard($name);
            $query = 'UPDATE cards SET ';
            $query .= "medium_price = '{$price_card}'";
            $query .= " WHERE multiverseid = {$multiverseid} ";

            $this->db->query($query);
            sleep(3);
        }

    }

    private function getPriceCard($cardName)
    {
        error_reporting(0); 

        $url ='http://www.ligamagic.com/?view=cards%2Fsearch&card=';
        $url .= str_replace(' ', '+', $cardName);

        $dom = new DOMDocument();
        $dom->loadHTMLFile($url);

        if (is_null($dom->getElementById('omoMedioPreco')->textContent)) {
            return '0,00';
        }

        return trim(str_replace('R$', '', $dom->getElementById('omoMedioPreco')->textContent));
    }

    /**
    *   Metodo para Atualizar db com nome dos
    *   cards em portugues
    */
    public function getPTBRNamesAction()
    {
        $string = 'cardTitle';
        
        $select = "SELECT name, multiverseid FROM cards WHERE nome IS NULL order by id_collection desc limit 500";
        $ret = $this->db->fetchAll($select, Phalcon\Db::FETCH_ASSOC);
        
        foreach($ret as $card) {
            extract($card);
            $name = str_replace(' ', '+', trim($name));
            $url ="http://www.ligamagic.com/?view=cards%2Fsearch&card=$name";
            $cardTitle = explode(addslashes($string), htmlentities($this->curl($url)));
            $nome = html_entity_decode(substr(strstr($cardTitle[1], "font", true), 10, -5));

            if (strlen($nome) < 1) {
                sleep(2);
                continue;
            }
            
            $query = "UPDATE cards set nome = '{$nome}' WHERE multiverseid = {$multiverseid}";
            
            $this->db->query($query);

            sleep(2);
        }
    
    }

    private function curl($url)
    {
        $cURL = curl_init($url);

        // Define a opção que diz que você quer receber o resultado encontrado
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

        // Executa a consulta, conectando-se ao site e salvando o resultado na variável $resultado
        $result_request_data = curl_exec($cURL);

        $http_response_code = curl_getinfo($cURL, CURLINFO_HTTP_CODE);

        if ($http_response_code == 404) {
            return false; 
        }

        curl_close($cURL);

        return $result_request_data;
    }


}