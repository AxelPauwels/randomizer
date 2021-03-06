<?php

require_once(ENTITIES_DIR . "Person_entity.php");

class Person_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $personId
     * @return object
     */
    public function getPersonById($personId)
    {
        $this->db->where('id', $personId);
        $query = $this->db->get('person');
        $personItem = $query->row();

        return $this->getPersonObject($personItem);
    }

    /**
     * @param $personId
     * @return object
     */
    public function ajaxGetPersonById($personId)
    {
        $this->db->where('id', $personId);
        $query = $this->db->get('person');

        return $query->row();
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $this->db->where('id >', 0);
        $this->db->where('isActive', 1);
        $this->db->order_by('name');
        $query = $this->db->get('person');
        $result = $query->result();

        $persons = [];
        foreach ($result as $result_item) {
            $persons[] = $this->getPersonObject($result_item);
        }

        return $persons;
    }

    /**
     * Creates and returns a 'PersonEntity' object
     *
     * @param $item
     * @return Person_entity
     */
    public function getPersonObject($item)
    {
        $person = new Person_entity(
            $item->id,
            $item->name,
            $item->lastname,
            $item->nickname,
            $item->image,
            $item->isMale,
            $item->accessCode,
            $item->wishlist,
            0,
            -1,
            $item->isActive
        );

        return $person;
    }

    /**
     * Return the wishlist from one person
     *
     * @param $personId int
     * @return string
     */
    public function getWishlist($personId)
    {
        $this->db->select('wishlist');
        $this->db->where('id', $personId);
        $query = $this->db->get('person');

        return $query->row()->wishlist;
    }

	/**
	 * @param int $accessCode
	 * @return int
	 */
	public function getIdByAccessCode(int $accessCode): int
	{
		$this->db->select('id');
		$this->db->where('accessCode', $accessCode);
		$query = $this->db->get('person');
		$id = $query->row()->id;

		return ($id) ? (int)$id : -1;
	}

	/**
	 * @param Person_entity $person
	 */
	public function updatePerson(Person_entity $person)
	{
		$this->db->where('id', $person->getId());
		$this->db->set('wishlist',$person->getWishlist());
		$this->db->update('person');
	}
}
