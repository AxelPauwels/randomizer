<?php

declare(strict_types=1);

defined('BASEPATH') or exit('No direct script access allowed');

class Game extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('game_model');
        $this->load->model('person_model');
        $this->load->model('game_person_model');
    }

    public function index()
    {
        $data['games'] = $this->getGames();

        $partials = array('myContent' => 'home');
        $this->template->load('main_master', $partials, $data);
    }

    public function play()
    {
        $gameId = (int)$this->input->post('gameId');
        $data['persons'] = $this->getPersonsByGameId($gameId);
        $data['gameId'] = $gameId;

        $partials = array('myContent' => 'game');
        $this->template->load('main_master', $partials, $data);
    }

    /**
     * Returns an array with 'Game' objects
     *
     * @return array
     */
    private function getGames(): array
    {
        return $this->game_model->getAll();
    }

    /**
     * Returns an array with 'Person' objects
     *
     * @param int $gameId
     * @return array
     */
    private function getPersonsByGameId(int $gameId): array
    {
        // get personIds
        $gamePersons = $this->game_person_model->getGamePersonsByGameId($gameId);
        $persons = [];

        /**
         * @var Person_entity $person
         */
        foreach ($gamePersons as $gamePerson) {
            $person = $this->person_model->getPersonById($gamePerson->personId);
            $person->setIsChosen((boolean)$gamePerson->isChosen);
            $person->setHasChosenPersonId(intval($gamePerson->hasChosenPersonId));
            $persons[] = $person;
        }
        return $persons;
    }

    // AJAX FUNCTIONS

    /**
     * Returns json with 2 arrays
     *
     * 1 Returns persons from a game, who aren't chosen and who is not himself
     * 2 Returns all persons except himself (for random images effect)
     */
    public function ajaxGetRandomPerson()
    {
        $currentPersonId = $this->input->post('currentPersonId');
        $gameId = (int)$this->input->post('gameId');

        // get all game persons by gameId
        $gamePersons = $this->game_person_model->getGamePersonsByGameId($gameId);

        // get and update all person objects
        $allPersons = [];
        foreach ($gamePersons as $gamePerson) {
            $person = $this->person_model->ajaxGetPersonById($gamePerson->personId);
            $person->isChosen = (boolean)$gamePerson->isChosen;
            $person->hasChosenPersonId = intval($gamePerson->hasChosenPersonId);
            $allPersons[] = $person;
        }

        // fill array with only names for images
        $allPersonsImageNames = [];
        // filter persons that aren't chosen yet, and that isn't is the current person
        $unchosenPersons = [];

        foreach ($allPersons as $person) {
            // imagenames
            $allPersonsImageNames[] = $person->image;

            // unchosen persons
            if (!$person->isChosen && $person->id != $currentPersonId) {
                $unchosenPersons [] = $person;
            }
        }

        //randomize
        $randomIndex = rand(0, count($unchosenPersons) - 1);
        $randomPerson = $unchosenPersons[$randomIndex];

        // if this is the 2nd last person, check if te last person will be himself
        $currentPersonIsSecondLast = $this->game_person_model->checkIfPersonIsSecondLast($gameId);
        if ($currentPersonIsSecondLast) {
            // check if remaining person will be himself, if this is the case, get his id for this current (2nd last) person
            $lastPersonId = $this->game_person_model->getLastPersonIdIfHeWillBeHimself(
                $gameId,
                $currentPersonId,
                $randomPerson->id
            );

            // update $randomPerson with the last person, so the last person will be himself
            if ($lastPersonId !== -1) {
                /** @var $lastPerson Person_entity */
                $lastPerson = $this->person_model->getPersonById($lastPersonId);

                // dirty fix (make a normal object from the PersonObject)
                $convertedPerson = new stdClass();
                $convertedPerson->id = $lastPerson->getId();
                $convertedPerson->name = $lastPerson->getName();
                $convertedPerson->lastname = $lastPerson->getLastName();
                $convertedPerson->nickname = $lastPerson->getNickname();
                $convertedPerson->isMale = $lastPerson->getIsMale();
                $convertedPerson->accessCode = $lastPerson->getAccessCode();
                $convertedPerson->wishlist = $lastPerson->getWishlist();
                $convertedPerson->isChosen = $lastPerson->getIsChosen();
                $convertedPerson->hasChosenPersonId = $lastPerson->getHasChosenPersonId();
                $convertedPerson->image = $lastPerson->getImage();
                $randomPerson = $convertedPerson;
            }
        }

        // save result
        $this->game_person_model->updatePerson($gameId, $currentPersonId, $randomPerson->id);
        $this->game_person_model->updateChosenPerson($gameId, $randomPerson->id);

        echo json_encode(["randomPerson" => $randomPerson, "allPersonsImageNames" => $allPersonsImageNames]);
    }

    public function giftLists()
    {
        $data['persons'] = $this->person_model->getAll();

        $partials = array('myContent' => 'gift_lists');
        $this->template->load('main_master', $partials, $data);
    }

    public function giftList($personId)
    {
        $data['person'] = $this->person_model->getPersonById($personId);

        $wishlist = $this->person_model->getWishlist($personId);
        $data['wishlist'] = explode(',', $wishlist);

        $partials = array('myContent' => 'gift_list');
        $this->template->load('main_master', $partials, $data);
    }
}
