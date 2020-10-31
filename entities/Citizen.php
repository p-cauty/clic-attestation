<?php

namespace PitouFW\Entity;

class Citizen {
    private string $firstname = '';
    private string $lastname = '';
    private string $birth_date = '';
    private string $birth_location = '';
    private string $street_address = '';

    /**
     * @return string
     */
    public function getFirstname(): string {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return Citizen
     */
    public function setFirstname(string $firstname): Citizen {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return Citizen
     */
    public function setLastname(string $lastname): Citizen {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getBirthDate(): string {
        return $this->birth_date;
    }

    /**
     * @param string $birth_date
     * @return Citizen
     */
    public function setBirthDate(string $birth_date): Citizen {
        $this->birth_date = $birth_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getBirthLocation(): string {
        return $this->birth_location;
    }

    /**
     * @param string $birth_location
     * @return Citizen
     */
    public function setBirthLocation(string $birth_location): Citizen {
        $this->birth_location = $birth_location;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreetAddress(): string {
        return $this->street_address;
    }

    /**
     * @param string $street_address
     * @return Citizen
     */
    public function setStreetAddress(string $street_address): Citizen {
        $this->street_address = $street_address;
        return $this;
    }

}
