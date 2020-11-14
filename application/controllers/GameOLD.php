<?php

declare(strict_types=1);

defined('BASEPATH') or exit('No direct script access allowed');

class Game extends CI_Controller
{
	const COOKIE_NAME = '63PAzVDVdstkFCA8';
	const COOKIE_VALUE_PREFIX = 'R34aLVwLJayxF94m'; // a random string to prepend to the id
	const COOKIE_EXPIRE_DATE = '2147483647'; // The maximum value compatible with 32 bits systems is:( = 2^31 = ~year 2038)
//
//	/**
//	 * @var Person_entity
//	 */
//	private $loggedInUser;

	private $gameId;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('game_model');
		$this->load->model('person_model');
		$this->load->model('game_person_model');
		$this->load->helper('cookie');
	}


	/**
	 * @param int $id
	 */
	function setUserCookie(int $id): void
	{
		// expires over 10 years
		$newCookie = [
			'name' => Game::COOKIE_NAME,
			'value' => Game::COOKIE_VALUE_PREFIX . $id,
			'expire' => Game::COOKIE_EXPIRE_DATE
		];

		$this->input->set_cookie($newCookie);
	}

	/**
	 * @return mixed
	 */
	function getUserCookie()
	{
		return get_cookie(Game::COOKIE_NAME);
	}

	public function getUserByCookie()
	{
		$cookieValue = $this->getUserCookie();
		$userId = (int)str_replace(Game::COOKIE_VALUE_PREFIX, '', $cookieValue);
		return $this->person_model->getPersonById($userId);
	}

	public function verify()
	{
		// redirect when there is a cookie set. (it's set during ajax when checking the accessCode)
		if ($this->getUserCookie()) {
			redirect('game/home');
			// user is ingelogd
		}

		$partials = array('myContent' => 'verify');
		$this->template->load('main_master', $partials);
	}

	public function home()
	{
		if (!$this->getUserCookie()) {
			redirect('game/verify');
		}

		$data['user'] = $this->getUserByCookie();

		$partials = array('myContent' => 'home');
		$this->template->load('main_master', $partials, $data);
	}


	public function selectGame()
	{
		$data['games'] = $this->getGamesFromPerson();

		if (count($data['games']) === 1) {
			$this->gameId = (int)$data['games'][0]->getId();

			var_dump('test');
			var_dump($data['games'][0]->getId());

			redirect('game/play/'.$data['games'][0]->getId());
		}

		$partials = array('myContent' => 'select_game');
		$this->template->load('main_master', $partials, $data);
	}

	public function play()
	{
		$gameId = (int)$this->input->post('gameId');

		// if redirected from selectGame(), the parameter $gameId will be set
		// example explode('/',$_SERVER['REQUEST_URI']:
		//		array (size=4)
		//  0 => string '' (length=0)
		//  1 => string 'game' (length=4)
		//  2 => string 'play' (length=4)
		//  3 => string '1' (length=1)

		// otherwise it should come out of the form from select_game.php
		$uriParts = explode('/', $_SERVER['REQUEST_URI']);

		if (count($uriParts) === 4) {
			$gameId = (int)$uriParts[3];
		}

		$data['game'] = $this->game_model->get($gameId);
		$data['currentPerson'] = $this->getUserByCookie();
		$data['chosenPerson'] = null;

		$hasAlreadyChosen = $this->game_person_model->getSpecificGame($gameId, $this->getUserByCookie()->getId());
		if ((int)$hasAlreadyChosen->hasChosenPersonId !== -1) {
			$data['chosenPerson'] = $this->person_model->getPersonById($hasAlreadyChosen->hasChosenPersonId);
		}

		$this->game_person_model->getSpecificGame($gameId,$this->getUserByCookie()->getId());
		$data['persons'] = $this->getPersonsByGameId($gameId);

		$partials = array('myContent' => 'game');
		$this->template->load('main_master', $partials, $data);
	}


	/**
	 * Returns an array with 'Game' objects
	 * @return array
	 * @var Game_entity $game
	 * @var Game_entity $game
	 */
	private function getGamesFromPerson(): array
	{
		$gamesFromPerson = [];
		$allGamesThisYear = $this->game_model->getAll();

		foreach ($allGamesThisYear as $game) {
			$possibleGame = $this->game_person_model->getSpecificGame($game->getId(), $this->getUserByCookie()->getId());
			if ($possibleGame) {
				$gamesFromPerson[] = $game;
			}
		}

		return $gamesFromPerson;
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
	 * Returns json with userId (or -1 when accesscode is not correct
	 *
	 */
	public function ajaxVerifyAccessCode()
	{
		$userId = -1;
		$accessCode = $this->input->post('accessCode');

		if ($accessCode) {
			$userId = $this->person_model->getIdByAccessCode((int)$accessCode);
		}

		if ($userId !== -1) {
			$this->setUserCookie($userId);
		}

		echo json_encode(["userId" => $userId]);
	}

	/**
	 * Returns json with 2 arrays
	 *
	 * 1 Returns persons from a game, who aren't chosen and who is not himself
	 * 2 Returns all persons except himself (for random images effect)
	 */
	public function ajaxGetRandomPerson()
	{
		$currentPersonId = $this->getUserByCookie()->getId();
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
		$data['wishlist'] = [];
		$data['person'] = $this->person_model->getPersonById($personId);

		$currentPerson = $this->getUserByCookie();
		$data['showEditBtn'] = false;
		if($this->getUserByCookie() === $data['person']->){
			$data['showEditBtn'] = true;
		}

		$wishlist = $this->person_model->getWishlist($personId);
		if ($wishlist) {
			$data['wishlist'] = explode(',', $wishlist);
		}
		$partials = array('myContent' => 'gift_list');
		$this->template->load('main_master', $partials, $data);
	}

	public function editList()
	{
		$wishlist = (string)$this->person_model->getWishlist($this->getUserByCookie()->getId());
		$data['wishlist'] = $wishlist;

		if (strpos($wishlist, ',') !== false) {
			$data['wishlist'] = str_replace(",", "\r\n", $wishlist);
		}

		$partials = array('myContent' => 'edit_list');
		$this->template->load('main_master', $partials, $data);
	}

	public function updateWishlist()
	{
		$wishlist = $this->input->post('wishlist');
		$wishlistCorrected = trim(preg_replace('/\s\s+/', ',', $wishlist));

		//strip last char if needed
		$lastChar = substr($wishlistCorrected, strlen($wishlistCorrected) - 1, strlen($wishlistCorrected));
		if ($lastChar === ',') {
			$wishlistCorrected = substr($wishlistCorrected, 0, -1);
		}

		$currentUser = $this->getUserByCookie();
		$currentUser->setWishlist($wishlistCorrected);
		$this->person_model->updatePerson($currentUser);

		redirect('game/editList');
	}
}
