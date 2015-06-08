<?php

use Phalcon\Mvc\Model;

class Cards extends \Phalcon\Mvc\Model
{
    private $db;

    /**
     * @param object $db seta instancia de conexao para a classe model Cards
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return string com query basica de relação entre tables referentes a cards
     */
    private function getBasicSql()
    {
        //$query = 'SELECT c.*, cc.color, ct.type, cst.subtype, col.info_code FROM cards as c ';
        $query = 'SELECT c.*, cc.color, col.info_code FROM cards as c ';
        //$query .= 'left join cards_types as ct on ct.multiverseid = c.multiverseid ';
        //$query .= 'left join cards_subtypes as cst on cst.multiverseid = c.multiverseid ';
        $query .= 'left join cards_colors as cc on cc.multiverseid = c.multiverseid ';
        $query .= 'left join collections as col on col.id = c.id_collection ';

        return $query;
    }

    /**
     * @param array $params com filtros para select das cards
     * @return array com cards do result select
     */
    public function getCardsFromCollection($params)
    {
        $query = $this->getBasicSql();
        
        $query .= ' WHERE c.id_collection = '.$params['id_collection'];

        if (isset($params['color'])) {
            $query .= " AND cc.color LIKE '".$params['color']."' ";
        }

        if (isset($params['mana'])) {
            $query .= ' AND c.mana_cost = '. $params['mana'];
        }
        
        $query .= ' order by '.$params['order'].' limit '.$params['limit'];

        return $this->db->fetchAll($query, Phalcon\Db::FETCH_ASSOC);
    }

    /**
     * @param string $artist_name
     * @return array com cards do result select
     */
    public function getArtistCards($artist_name)
    {
        $query = $this->getBasicSql();

        $query .= " WHERE c.artist like '%{$artist_name}%' limit 20";

        return $this->db->fetchAll($query, Phalcon\Db::FETCH_ASSOC);   
    }

    public function getCardsByName($card_name)
    {
        $card_name = strip_tags(addslashes($card_name));

        $query = $this->getBasicSql();
        $query .= "WHERE c.name like '%".$card_name."%' OR c.nome like '%".htmlentities($card_name)."%' ";

        return $this->db->fetchOne($query, Phalcon\Db::FETCH_ASSOC);
    }


    public function getDecks()
    {
        $query = 'SELECT * FROM collections order by name';
        return $this->db->fetchAll($query, Phalcon\Db::FETCH_ASSOC);
    }

    public function getDeck($id_collection)
    {
        $query = "SELECT * FROM collections WHERE id = {$id_collection}";
        return $this->db->fetchAll($query, Phalcon\Db::FETCH_ASSOC);
    }

    public function getAllColors()
    {
        $cores = $this->db->fetchAll("SELECT DISTINCT color from cards_colors", Phalcon\Db::FETCH_ASSOC);

        foreach ($cores as $cor) {
            $colors[] = $cor['color'];
        }

        return $colors;
    }

    public function getAllWishCardsFromUserId($id_user)
    {
        $query = "select id_multiverseid from wishlist_cards where id_user = $id_user";
        return $this->db->fetchAll($query, Phalcon\Db::FETCH_ASSOC);
    }

    public function getWishlistCards($cards)
    {
        $query = $this->getBasicSql();
        $query .= "WHERE c.multiverseid IN ($cards) order by c.id_collection DESC, c.number ASC";

        return $this->db->fetchAll($query, Phalcon\Db::FETCH_ASSOC);
    }

    public function gravarWishedCard($user_id, $multiverseid)
    {
        $verifica_existencia = $this->db->fetchAll("
            SELECT * FROM wishlist_cards where id_user = '$user_id' and id_multiverseid = '$multiverseid' ",
            Phalcon\Db::FETCH_ASSOC);

        if (!empty($verifica_existencia)) {
            return false;
        }      
        $query = 'INSERT INTO wishlist_cards(id, id_user, id_multiverseid) ';
        $query .= "VALUES('1', '$user_id', '$multiverseid')";

        return $this->db->query($query);
    }

    public function deletarWishedCard($user_id, $multiverseid)
    {
        $query = 'DELETE FROM wishlist_cards ';
        $query .= " WHERE id_user = '$user_id' and id_multiverseid = '$multiverseid' ";

        return $this->db->query($query);
    }

}