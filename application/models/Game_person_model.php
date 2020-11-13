<?php

require_once(ENTITIES_DIR . "Person_entity.php");

class Game_person_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getSpecificGame(int $gameId, int $personId){
		$this->db->where('id >', 0);
		$this->db->where('gameId', $gameId);
		$this->db->where('personId', $personId);
		$query = $this->db->get('game_person');

		return $query->row();
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

    /**
     * Check if person is the 2nd last person. This check must be done to see is the
     * last person is not himself
     *
     * @param $gameId
     * @return bool
     */
    public function checkIfPersonIsSecondLast($gameId)
    {
        $this->db->where('gameId', $gameId);
        $this->db->where('hasChosenPersonId', -1);
        $query = $this->db->get('game_person');

        return (sizeof($query->result()) === 2);
    }

    /**
     * Return the lastPersonId, if the last person will not be himself
     * Otherwise return -1
     *
     * @param $gameId
     * @param $currentPersonId
     * @param $randomPersonId
     * @return int
     */
    public function getLastPersonIdIfHeWillBeHimself($gameId, $currentPersonId, $randomPersonId)
    {
        // get the last person that has to choose
        // --------------------------------------
        // in this case we now the result beased on hasChosenPersonId == -1 will always be 2
        // to get the last one, filter where personId !== currentPersonId to get a single row (the last person)
        $this->db->where('gameId', $gameId);
        $this->db->where('hasChosenPersonId', -1);
        $this->db->where('personId !=', $currentPersonId);
        $query = $this->db->get('game_person');
        $lastPerson = $query->row();

        // get the last person that must be chosen after this choice (of the 2nd last person)
        // ----------------------------------------------------------------------------------
        // get all persons that are unchosen and is not this current randomPersonId
        // this also will return 1 single value
        $this->db->where('gameId', $gameId);
        $this->db->where('isChosen', 0);
        $this->db->where('personId !=', $randomPersonId);
        $query = $this->db->get('game_person');
        $lastUnchosenPerson = $query->row();

        return ($lastPerson->personId === $lastUnchosenPerson->personId) ? $lastPerson->personId : -1;
    }
}
