<?php
/**
 * Analyzes a bet game score and compares it to the real score
 * 
 * @author Ronald Vilbrandt <info@rvi-media.de>
 * @copyright 2016 Ronald Vilbrandt, www.rvi-media.de
 * @since 2016-06-02
 */

namespace rvilbrandt\lostandfound\BettingGame;

class BetResultAnalyzer {
    
    private $intRealHomeScore = null;
    private $intRealAwayScore = null;
    
    private $intBetHomeScore = null;
    private $intBetAwayScore = null;
    
    /**
     * Constructor
     * 
     * @param integer $intRealHomeScore Home score (optional)
     * @param integer $intRealAwayScore Away score (optional)
     */
    public function __construct($intRealHomeScore = null, $intRealAwayScore = null, $intBetHomeScore = null, $intBetAwayScore = null) {
        
        if (true === isset($intRealHomeScore)) {
            $this->setRealResult($intRealHomeScore, $intRealAwayScore);
        }
        
        if (true === isset($intBetHomeScore)) {
            $this->setBetResult($intBetHomeScore, $intBetAwayScore);
        }
        
    }
    
    /**
     * Sets real result score
     * 
     * @param integer $intHomeScore Home score
     * @param integer $intAwayScore Away score
     * 
     * @throws \InvalidArgumentException
     */
    public function setRealResult($intHomeScore, $intAwayScore) {
        
        if (false === $this->isValidScore($intHomeScore, true)) {
            throw new \InvalidArgumentException("Home score has to be a positive integer: " . var_export($intHomeScore, true));
        }
        
        if (false === $this->isValidScore($intAwayScore, true)) {
            throw new \InvalidArgumentException("Away score has to be a positive integer: " . var_export($intAwayScore, true));
        }
        
        $this->intRealHomeScore = $intHomeScore;
        $this->intRealAwayScore = $intAwayScore;
        
    }
    
    /**
     * Sets bet result score
     * 
     * @param integer $intHomeScore Home score
     * @param integer $intAwayScore Away score
     * 
     * @throws \InvalidArgumentException
     */
    public function setBetResult($intHomeScore, $intAwayScore) {
        
        if (false === $this->isValidScore($intHomeScore, true)) {
            throw new \InvalidArgumentException("Home score has to be a positive integer: " . var_export($intHomeScore, true));
        }
        
        if (false === $this->isValidScore($intAwayScore, true)) {
            throw new \InvalidArgumentException("Away score has to be a positive integer: " . var_export($intAwayScore, true));
        }
        
        $this->intBetHomeScore = $intHomeScore;
        $this->intBetAwayScore = $intAwayScore;
        
    }
    
    /**
     * Tells if bet result is exact to real result
     * 
     * @return boolean Status
     */
    public function isExactResult() {
        
        if (false === isset($this->intRealHomeScore) || false === isset($this->intBetHomeScore)) {
            throw new \BadMethodCallException("Real and bet results must be set");
        }
        
        return $this->intBetHomeScore === $this->intRealHomeScore && $this->intBetAwayScore === $this->intRealAwayScore;
    }
    
    /**
     * Tells if bet result has the same difference as the real result
     * 
     * @return boolean Status
     */
    public function isSameScoreDifference() {
        
        if (false === isset($this->intRealHomeScore) || false === isset($this->intBetHomeScore)) {
            throw new \BadMethodCallException("Real and bet results must be set");
        }
        
        return $this->intRealHomeScore - $this->intRealAwayScore === $this->intBetHomeScore - $this->intBetAwayScore;
    }
    
    /**
     * Returns if bet result has the same tendency as the real result
     * 
     * @return boolean Status
     */
    public function isSameTendency() {
        
        if (false === isset($this->intRealHomeScore) || false === isset($this->intBetHomeScore)) {
            throw new \BadMethodCallException("Real and bet results must be set");
        }
        
        return 
        ($this->intRealHomeScore < $this->intRealAwayScore &&  $this->intBetHomeScore < $this->intBetAwayScore) 
        || ($this->intRealHomeScore > $this->intRealAwayScore && $this->intBetHomeScore > $this->intBetAwayScore) 
        || ($this->intRealHomeScore === $this->intRealAwayScore && $this->intBetHomeScore === $this->intBetAwayScore);
    }
    
    /**
     * Checks for valid score (min 0)
     *
     * @param integer $intScore Score
     * @return boolean Status
     */
    protected function isValidScore($intScore) {
        return is_int($intScore) && -1 < $intScore;
    }
    
}