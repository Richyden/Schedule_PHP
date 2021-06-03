<?php

namespace App\Date;

class Month{

    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mais', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    
    public $month;
    public $year;

    /**
     * Constructor:
     * @param int $month -> le mois, compris entre 1 et 12
     * @param int $year => l'année
     * @throws Exception
     */
    public function __construct(?int $month = null, ?int $year = null)
    {
        //Si le mois n'est pas indiqué, renvoie le mois actuel de la machine, en entier
        if($month === null) {
            $month = intval(date('m'));
        }
        //Si le mois n'est pas indiqué, renvoie l'année actuel de la machine, en entier
        if($year === null) {
            $year = intval(date('Y'));
        }

        if($month < 1 || $month > 12) {
            throw new \Exception("Le mois $month n'est pas valide !"); // le backslash "\" devant Exception est la pour prevenir qu'il vient de la racine.
        }

        if($year < 1970) {
            throw new \Exception("L'année est inférieur à 1970");
        }
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * renvoie le premier jour du mois.
     */
    public function getStartingDay():\DateTime {
        return new \DateTime("{$this->year}-{$this->month}-01");
    }

    /**
     * Return month in string.
     */
    public function toString():string {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    public function getWeeks():int {
        $start = $this->getStartingDay();
        $end = (clone $start)->modify('+1 month -1 day');

        $weeks = intval($end->format('W')) - intval($start->format('W')) + 1;

        if($weeks < 0) {
            $weeks = intval($end->format('W'));
        }

        return $weeks;
    }

    /**
     * Est-ce que le jour est dans le mois en cours
     */
    public function withinMonth(\DateTime $date):bool {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * Fonction gérant le mois suivant.
     */
    public function nextMonth():Month {
        $month = $this->month + 1;
        $year = $this->year;

        if($month > 12) {
            $month = 1;
            $year = $year + 1;
        }

        return new Month($month, $year);
    }

    /**
     * Fonction gérant le mois précédent.
     */
    public function previousMonth():Month {
        $month = $this->month - 1;
        $year = $this->year;

        if($month < 1) {
            $month = 12;
            $year = $year - 1;
        }

        return new Month($month, $year);
    }
}