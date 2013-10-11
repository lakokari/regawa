<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of QBook
 * API to acces QBaca books data
 *
 * @author master
 */
class Schedule {

    private $startDate = '';
    private $endDate = '';
    private $cellWidth = 35;
    private $rowHeight = 60;

    public function setStartDate($newDateStr) {
        $this->startDate = $newDateStr;
    }

    public function setEndDate($newDateStr) {
        $this->endDate = $newDateStr;
    }

    public function getCalendar() {
        
    }

    public function getDataDummy() {
        $dataTmp = array(
            array('title' => 'Upload video', 'start_date' => '2013-9-25', 'end_date' => '2013-11-30', 'jml_col' => 9, 'id'=> 0),
            array('title' => 'Voting', 'start_date' => '2013-9-25', 'end_date' => '2013-12-10', 'jml_col' => 11, 'id'=> 0),
            array('title' => 'Pengumuman 10 finalis', 'start_date' => '2013-12-13', 'end_date' => '2013-12-13', 'jml_col' => 1, 'id'=> 3),
            //array('title' => 'Penjurian dan voting babak final', 'start_date' => '2013-11-12', 'end_date' => '2013-12-19', 'jml_col' =>4, 'id'=> 2),
            array('title' => 'Screening & Pengumuman pemenang', 'start_date' => '2013-12-19', 'end_date' => '2013-12-19', 'jml_col' => 1, 'id'=> 3),
        );
        return $dataTmp;
    }

    public function tableData($opt, $param1 = '', $param2 = '') {

        if ($opt == 'header') {
            return $this->tableHeaderData($param1);
        } else if ($opt == 'week-title') {
            return $this->tableWeekData();
        } else if ($opt == 'col-month') {
            return $this->dataWidthCol();
        } else if ($opt == 'jml-data') {
            return count($this->getDataDummy());            
        }
    }

    public function dataWidthCol() {
        $start = $this->startDate;
        $end = $this->endDate;

        $startMonth = date('m', strtotime($start));
        $year = date('Y', strtotime($start));
        $endMonth = date('m', strtotime($end));

        $ret = array();
        //$endMonth = ($endMonth > $startMonth )? $endMonth: ($startMonth-12) + $endMonth;
        $result = array();
        if ($endMonth > $startMonth) {
            for ($i = $startMonth; $i <= $endMonth; $i++) {
                $ret[] = $this->weekOfMonth($i);
            }
        } else {
            for ($i = $startMonth; $i <= 12; $i++) {
                $ret[] = $this->weekOfMonth($i);
            }
            for ($i = 1; $i <= $endMonth; $i++) {
                $ret[] = $this->weekOfMonth($i);
            }
        }
        return $ret;
    }

    public function getMonthLength() {
        $start = $this->startDate;
        $end = $this->endDate;

        $startMonth = date('m', strtotime($start));
        $year = date('Y', strtotime($start));
        $endMonth = date('m', strtotime($end));

        $jml = 0;
        //$endMonth = ($endMonth > $startMonth )? $endMonth: ($startMonth-12) + $endMonth;
        $result = array();
        if ($endMonth > $startMonth) {
            for ($i = $startMonth; $i <= $endMonth; $i++) {
                $jml++;
            }
        } else {
            for ($i = $startMonth; $i <= 12; $i++) {
                $jml++;
            }
            for ($i = 1; $i <= $endMonth; $i++) {
                $jml++;
            }
        }
        return $jml;
    }

    private function weekOfMonth($month) {
        $nWeek = 4;
        return $nWeek * $this->cellWidth;
    }

    private function tableWeekData() {
        $maxWeek = 4;
        $result = array();
        for ($i = 1; $i <= $maxWeek; $i++) {
            $result[$i] = 'W' . $i;
        }
        return $result;
    }

    private function tableHeaderData($opt='') {
        $start = $this->startDate;
        $end = $this->endDate;

        $startMonth = date('m', strtotime($start));
        $year = date('Y', strtotime($start));
        $endMonth = date('m', strtotime($end));

        //$endMonth = ($endMonth > $startMonth )? $endMonth: ($startMonth-12) + $endMonth;
        $result = array();
        if ($endMonth > $startMonth) {

            for ($i = $startMonth; $i <= $endMonth; $i++) {
                if ($opt == 'int-month') {
                    $result[] = $i;
                } else {
                    $result[] = date('M', mktime(0, 0, 0, $i, 1, $year));
                }
                
            }
        } else {
            for ($i = $startMonth; $i <= 12; $i++) {
                if ($opt == 'int-month') {
                    $result[] = $i;
                } else {                
                    $result[] = date('M', mktime(0, 0, 0, $i, 1, $year));
                }
            }
            for ($i = 1; $i <= $endMonth; $i++) {
                if ($opt == 'int-month') {
                    $result[] = $i;
                } else {                
                    $result[] = date('M', mktime(0, 0, 0, $i, 1, $year));
                }
            }
        }
        return $result;
    }
    private function getPosisiByMonth($intMonth) {
        $start = $this->startDate;
        $end = $this->endDate;

        $startMonth = date('m', strtotime($start));
        $year = date('Y', strtotime($start));
        $endMonth = date('m', strtotime($end));
        $j = 0;
        //$endMonth = ($endMonth > $startMonth )? $endMonth: ($startMonth-12) + $endMonth;
        $result = array();
        if ($endMonth > $startMonth) {

            for ($i = $startMonth; $i <= $endMonth; $i++) {
                
                
                if ($i === $intMonth) {
                    return $j;
                    break;
                }  
              $j++; 
                 
            }
        } else {
            for ($i = $startMonth; $i <= 12; $i++) {
                
                if ($i === $intMonth) {
                    return $j;
                    break;
                }  
                $j++; 
            }
            for ($i = 1; $i <= $endMonth; $i++) {
                 
                if ($i === $intMonth) {
                    return $j;
                    break;
                }  
                $j++;
            }
        }
        return $j;        
    }
    public function renderWeekHeader() {
        $week = $this->tableWeekData();
        foreach ($week as $wk) {
            echo '<li class="wk-title-cell" style="width:' . $this->cellWidth . 'px;">' . $wk . '</li>';
        }
    }

    public function renderTableHeader() {
        
    }
    
    
    
    public function renderTableSpace() {
        $jmlRecord = count($this->getDataDummy());
        echo '<div style="height:' . ($jmlRecord * $this->rowHeight) . 'px;"></div>';
    }

    /* chart process */

    public function renderChart($indexData) {
        $datas = $this->getDataDummy();
        $data = $datas[$indexData];
        //$idM = date('m',strtotime($data['start_date']));
        
        //$id = $this->getPosisiByMonth($idM);
        $id = $data['id'];
        //die(var_dump($idM, $id));
        $weekNum = $this->getWeeks(strtotime($data['start_date']));
        $weekPerMonth = 4;
        $emptyColWidth = ($id * $weekPerMonth * $this->cellWidth) + (($weekNum-1) * $this->cellWidth);
        $spaceColWidth = ($data['jml_col'] * $this->cellWidth);
        
        /*render html*/
        echo '<div class="row-chart" style="height:'.$this->rowHeight.'px">'.
                '<div class="chart-line-empty" style="width:'.$emptyColWidth.'px"></div>'.
                '<div class="chart-line" style="width:'.$spaceColWidth.'px"></div>'.
            '</div>';
        
    }

//    private function get


    public function getWeeks($timestamp) {
        $maxday = date("t", $timestamp);
        $thismonth = getdate($timestamp);
        $timeStamp = mktime(0, 0, 0, $thismonth['mon'], 1, $thismonth['year']);    //Create time stamp of the first day from the give date.
        $startday = date('w', $timeStamp);    //get first day of the given month
        $day = $thismonth['mday'];
        $weeks = 0;
        $week_num = 0;

        for ($i = 0; $i < ($maxday + $startday); $i++) {
            if (($i % 7) == 0) {
                $weeks++;
            }
            if ($day == ($i - $startday + 1)) {
                $week_num = $weeks;
            }
        }
        return $week_num;
    }

}