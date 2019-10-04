<?php
/**
 * XML Sitemap Generator
 * 
 * @author  Cuispi
 * @version 1.0.1
 * @license Commercial License
 * @package system
 * @subpackage  system.library.xml_sitemap_generator
 */

namespace XmlSitemapGenerator;

final class Cli {
  
  /**
   * Constructor
   *
   * @param object $registry
   */  
  public function __construct() {
    //
  }
  
  /**
   * Outputs a messages to stdout..
   *
   * @param string $message
   * @param mixed $exitStatus
   * @return void
   */
  public function out($message, $exitStatus = null) {
    if (!$this->isCli()) {
      return false;
    }
    
    echo $message . PHP_EOL;

    if ($exitStatus !== null) {
      exit($exitStatus);
    }
  }
  
  /**
   * Passes in the number of seconds elapsed to get "hours:minutes:seconds" returned.
   * 
   * @param integer $seconds Seconds
   * @return string Time in hh:mm:ss format
   */
  public function toTime($seconds) {
    $t = round($seconds);
    return sprintf('%02d:%02d:%02d', ($t/3600),($t/60%60), $t%60);
  }
  
  /**
   * Checks if the script is run from the command line (CLI)
   *
   * @return boolean Returns true if the script is run from the command line (CLI), false otherwise. 
   */
  public function isCli() {
    if (php_sapi_name() == 'cli') {
      return true;
    }
    
    return false;
  }
  
  /**
   * Checks if the script is run from a manual invocation on a terminal.
   *
   * @return boolean Returns true if the script is run from a manual invocation on a terminal, false otherwise. 
   */
  public function isTerm() {
    if (php_sapi_name() == 'cli' && isset($_SERVER['TERM'])) {
      return true;
    }
    
    return false;
  }
  
  /**
   * Checks if the script is run from a cron job.
   *
   * @return boolean Returns true if the script is run from a cron job, false otherwise. 
   */
  public function isCron() {
    if (php_sapi_name() == 'cli' && !isset($_SERVER['TERM'])) {
      return true;
    }
    
    return false;
  }
  
  /**
   * Checks if the script is run from a web server or something else.
   *
   * @return boolean Returns true if the script is run from a web server or something else, false otherwise. 
   */
  public function isWebserver() {
    if (php_sapi_name() !== 'cli') {
      return true;
    }
    
    return false;
  }
  
}
