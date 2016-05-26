<?php
/**
 * Calculates zodiac full date or day/month
 *
 * @author Ronald Vilbrandt <info@rvi-media.de>
 * @copyright 2016 Ronald Vilbrandt, www.rvi-media.de
 * @since 2016-05-26 
 */

namespace rvilbrandt\lostandfound\Zodiac;

class DateToZodiacConverter {
    
    private $arrZodiacs = [
        "Capricorn", 
        "Capricorn", 
        "Aquarius", 
        "Pisces", 
        "Aries",
        "Taurus", 
        "Gemini", 
        "Cancer", 
        "Leo", 
        "Virgo", 
        "Libra",
        "Scorpio", 
        "Sagittarius"
    ];
    
    /**
     * Constructor
     */
    public function __construct() {
        
    }
    
    /**
     * Converts zodiac from given date
     * 
     * Valid formats:
     * 
     * YYYY-mm-dd
     * mm-dd
     * 
     * @param string $strInput Input
     * @return string Zodiac
     * 
     * @throws \OutOfBoundsException
     */
    public function convert($strInput) {

        $arrInput = $this->parseInput($strInput);
        
        $intMonth = $arrInput[0];        
        $intDay = $arrInput[1];

        $arrDates = [
            0 => [
                mktime(0, 0, 0, 12, 22), 
                mktime(0, 0, 0, 12, 31)
            ],
            1 => [
                mktime(0, 0, 0, 1, 1), 
                mktime(0, 0, 0, 1, 20)
            ],
            2 => [
                mktime(0, 0, 0, 1, 21), 
                mktime(0, 0, 0, 2, 18)
            ],
            3 => [
                mktime(0, 0, 0, 2, 19), 
                mktime(0, 0, 0, 3, 20)
            ],
            4 => [
                mktime(0, 0, 0, 3, 21), 
                mktime(0, 0, 0, 4, 19)
            ],
            5 => [
                mktime(0, 0, 0, 4, 20), 
                mktime(0, 0, 0, 5, 20)
            ],
            6 => [
                mktime(0, 0, 0, 5, 21), 
                mktime(0, 0, 0, 6, 21)
            ],
            7 => [
                mktime(0, 0, 0, 6, 22), 
                mktime(0, 0, 0, 7, 22)
            ],
            8 => [
                mktime(0, 0, 0, 7, 23), 
                mktime(0, 0, 0, 8, 22)
            ],
            9 => [
                mktime(0, 0, 0, 8, 23), 
                mktime(0, 0, 0, 9, 22)
            ],
            10 => [
                mktime(0, 0, 0, 9, 23), 
                mktime(0, 0, 0, 10, 23)
            ],
            11 => [
                mktime(0, 0, 0, 10, 24), 
                mktime(0, 0, 0, 11, 21)
            ],
            12 => [
                mktime(0, 0, 0, 11, 22), 
                mktime(0, 0, 0, 12, 21)
            ]
        ];

        $intDate = mktime(0, 0, 0, $intMonth, $intDay);
        
        $strZodiac = null;
        
        foreach ($arrDates as $intKey => $arrDateRange) {

            if ($intDate >= $arrDateRange[0] && $intDate <= $arrDateRange[1]) {
                $strZodiac = $this->arrZodiacs[$intKey];
            }
        }
      
        if (false === isset($strZodiac)) {
            throw new \OutOfBoundsException("No zodiac found for this date: {$intMonth}-{$intDay}");
        }
        
        return $strZodiac;
    }
    
    /**
     * Parses month and date from input
     * 
     * Valid formats:
     * 
     * YYYY-mm-dd
     * mm-dd
     * 
     * @param string $strInput Input date
     * @return array Month, Day
     * 
     * @throws \InvalidArgumentException
     * @throws \OutOfBoundsException
     */
    private function parseInput($strInput) {
        
        $arrMatches = [];
        
        if (false == preg_match("/(?:\d{4}\-)?(\d{1,2})-(\d{1,2})/", $strInput, $arrMatches)) {
            throw new \InvalidArgumentException("Input date is invalid: " . var_export($strInput, true));
        }
        
        $intMonth = $arrMatches[1];
        $intDay = $arrMatches[2];
        
        if (1 > $intMonth || 12 < $intMonth) {
            throw new \OutOfBoundsException("Month is out of range: " . $intMonth);
        }
        
        if (1 > $intDay || 31 < $intDay) {
            throw new \OutOfBoundsException("Day is out of range: " . $intDay);
        }
        
        return [$intMonth, $intDay];
    }
    
}