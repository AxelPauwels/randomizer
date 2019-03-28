<?php

require_once(ENTITIES_DIR . "Person_entity.php");

class Game_person_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getGamePersonsByGameId(int $gameId)
    {
        $this->db->where('id >', 0);
        $this->db->where('gameId', $gameId);
        $query = $this->db->get('game_person');
        return $query->result();
    }

    /**
     * Update "hasChosenPersonId" int in the database of the current person (the chooser)
     *
     * @param $gameId
     * @param $currentPersonId int
     * @param $hasChosenPersonId int
     */
    public function updatePerson($gameId, $currentPersonId, $hasChosenPersonId)
    {
        $person = new stdClass();

        $person->hasChosenPersonId = $hasChosenPersonId;
        $this->db->where('gameId', $gameId);
        $this->db->where('personId', $currentPersonId);
        $this->db->update('game_person', $person);
    }

    /**
     * Update "isChosen" boolean in the database of the chosen person
     *
     * @param $gameId
     * @param $personId int
     */
    public function updateChosenPerson($gameId, $personId)
    {
        $person = new stdClass();

        $person->isChosen = true;
        $this->db->where('gameId', $gameId);
        $this->db->where('personId', $personId);
        $this->db->update('game_person', $person);
    }
}
