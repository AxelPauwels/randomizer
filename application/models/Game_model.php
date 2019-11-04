<?php

require_once(ENTITIES_DIR . "Game_entity.php");

class Game_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Returns an array with 'Game' objects
     *
     * @return array
     */
    public function getAll()
    {
        $this->db->where('id >', 0);
        $this->db->where('year', date('Y'));

        $this->db->order_by('name');
        $query = $this->db->get('game');
        $result = $query->result();

        $games = [];
        foreach ($result as $item) {
            $games[] = $this->getGameObject($item);
        }
        return $games;
    }

    /**
     * Creates and returns a 'Game' object
     *
     * @param $item
     * @return Game_entity
     */
    public function getGameObject($item): Game_entity
    {
        $game = new Game_entity(
            $item->id,
            $item->name,
            $item->year
        );
        return $game;
    }
}
