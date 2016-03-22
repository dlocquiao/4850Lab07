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
    
    
     public function __construct() {
        parent:: __construct();
        $this->xml = simplexml_load(DATAPATH, './data/WinterTerm.xml', "SimpleXMLElement", LIBXML_NOENT);

        //build list of school days
        foreach ($this->xml->dayOfWeek as $dayOfWeek) {
            $this->weekday[(string) $dayOfWeek['weekday']] = (string) $dayOfWeek;
        }
        //build list of school time periods
        foreach ($this->xml->period as $period) {
            foreach ($period->peBook as $peBook)
            {
                $this->period[] = new Book($peBook,$period);
            }
        }
        
        
        foreach ($this->xml->course->course as $course)
        {
            foreach ($course->coBook as $coBook)
            {
                $this->course[] = new Book($coBook,$course);
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
    }



    //  List Builders
    
    
    /**
     * Gets a list of all weekdays.
     */
    public function getDayList()
    {
        $dayList = array(
            'Monday' => array(
                'value' => 'Monday'
            ),
            'Tuesday' => array(
                'value' => 'Tuesday'
            ),
            'Wednesday' => array(
                'value' => 'Wednesday'
            ),
            'Thursday' => array(
                'value' => 'Thursday'
            ),
            'Friday' => array(
                'value' => 'Friday'
            )
        );
        
        return $dayList;
    }
    
  
   