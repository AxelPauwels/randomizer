<?php

class Game_entity
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $year;
	/**
	 * @var int
	 */
	private $budget;

	public function __construct(
		int $id,
		string $name,
		string $year,
		int $budget
	) {
		$this->id = $id;
		$this->name = $name;
		$this->year = $year;
		$this->budget = $budget;
	}

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param string $year
     */
    public function setYear(string $year)
    {
        $this->year = $year;
    }

	/**
	 * @return int
	 */
	public function getBudget(): int
	{
		return $this->budget;
	}

	/**
	 * @param int $budget
	 */
	public function setBudget(int $budget): void
	{
		$this->budget = $budget;
	}

}
