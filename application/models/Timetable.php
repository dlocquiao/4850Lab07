<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Timetable
 *
 * @author Dlocquiao
 */
class Timetable extends CI_Model {
    
    
    protected $xml = null;
    protected $dayOfWeek = array();
    protected $period = array();
    protected $course = array();
    private static $listOfDays = array('mon', 'tues', 'weds', 'thurs', 'friday');
    private static $listOfPeriods = array('0830', '0930', '1030', '1130', '1230', 
                                           '1330', '1430', '1530', '1630');
    
    
     public function __construct() {
        parent:: __construct();
        $this->xml = simplexml_load(DATAPATH, './data/WinterTerm.xml', "SimpleXMLElement", LIBXML_NOENT);

        //build list of school days
        foreach ($this->xml->dayOfWeek->day as $dayOfWeek) {
            foreach ($dayOfWeek->daBook as $daBook){
                $this->dayOfWeek[] = new Book($daBook, $dayOfWeek);
            }
        }
        //build list of school time periods
        foreach ($this->xml->period->timeslot as $period) {
            foreach ($period->peBook as $peBook)
            {
                $this->period[] = new Book($peBook, $period);
            }
        }
        
        
        foreach ($this->xml->course->class as $course)
        {
            foreach ($course->coBook as $coBook)
            {
                $this->course[] = new Book($coBook, $course);
            }
        }
        
    }
       
    //  Accessors
    
 
    public function getDay()
    {
        return $this->dayOfWeek;
    }
    

    public function getPeriod()
    {
        return $this->period;
    }
    
  
    public function getCourse()
    {
        return $this->course;
    }

    //  List Builders
    /**
     * Gets a list of all weekdays and periods.
     */
    static function getlistOfDays(){
        return self::$listOfDays;
    }
    static function getlistOfPeriods(){
        return self::$listOfPeriods;
    }
    
    public function searchdayOfWeek($sday, $speriod){
        $result = array();
        foreach ($this->getDay() as $day)
        {
            if($day->day == $sday && $day->starttime == $speriod){
                $result[] = $day;
            }
        }
        return $result;
    }
    
    public function searchPeriod($sday, $speriod){
        $result = array();
        foreach ($this->getPeriod() as $timeslot)
        {
            if($timeslot->day == $sday && $timeslot->starttime == $speriod){
                $result[] = $timeslot;
            }
        }
        return $result;
    }
    
    public function searchCourse($sday, $speriod){
        $result = array();
        foreach ($this->getCourse() as $class)
        {
            if($class->day == $sday && $class->starttime == $speriod){
                $result[] = $class;
            }
        }
        return $result;
    }
    
    }
    
    class Booking extends CI_model{
        public $day_Weekday;
        public $timeslotDuration;
        public $timeslotStart;
        public $timeslotEnd;
        public $className;
        public $classId;
        public $instructor;
        public $room;
        
        function __construct($details = null) {
            $this->day_Weekday  = (String) $details['day_weekday'];
            $this->timeslotDuration = (String) $details['timeslotDuration'];
            $this->timeslotStart = (String) $details['timeslotStart'];
            $this->timeslotEnd = (String) $details['timeslotEnd'];
            $this->className = (String) $details['className'];
            $this->classId = (String) $details['classId'];
            $this->instructor = (String) $details['instructor'];
            $this->room = (String) $details['room'];
        }
    }



    
    
  
   