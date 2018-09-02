<?php
/**
 * XML Sitemap Generator
 * 
 * @author  Cuispi
 * @version 1.0.1
 * @license Commercial License
 * @package system
 * @subpackage  system.library.xml_sitemap_generator.cli_progress_bar
 */

namespace XmlSitemapGenerator\CliProgressBar;

require_once DIR_SYSTEM . 'library/xml_sitemap_generator/cli_progress_bar/timer.php';
require_once DIR_SYSTEM . 'library/xml_sitemap_generator/cli_progress_bar/fps_limit.php';

use XmlSitemapGenerator\CliProgressBar\Timer;
use XmlSitemapGenerator\CliProgressBar\FPSLimit;

/**
 * Command line progress bar class
 *
 * Example:
 * <code>
 *  $tasks = rand() % 700 + 600;
 *  $done = 0;
 *
 *  $cli_progress_bar = new Progress();
 *
 *  for($done = 0; $done <= $tasks; $done++){
 *    usleep((rand() % 127)*100);
 *    $cli_progress_bar->update($done, $tasks);
 *  }  
 * </code>
 */
final class Progress {
  
  private $cols;
  private $limiter;
  private $units;
  private $total;

  public function __construct() {    
    // Change the fps limit as needed
    $this->limiter = new FPSLimit(10);
    echo "\n";
  }

  public function __destruct() {
    $this->draw();
  }

  public function update($units, $total) {    
    $this->units = $units;
    $this->total = $total;
    
    if (!$this->limiter->frame()) {
      return;
    }
    
    $this->draw();
  }
  
  private function updateSize() {
    // Get the number of columns.
    $this->cols = exec("tput cols");
  }

  private function draw() {
    $this->updateSize();
    $this->showStatus($this->units, $this->total, $this->cols, $this->cols);
  }
  
  private function showStatus($done, $total, $size = 30, $lineWidth = -1) {
    if ($lineWidth <= 0) {
      $lineWidth = isset($_ENV['COLUMNS']) ? $_ENV['COLUMNS'] : $lineWidth;
    }

    static $start_time = null;

    // Take account of [ and ]
    $size -= 3;

    // If we go over our bound, just ignore it
    if ($done > $total) {
      return;
    }

    if (is_null($start_time)) {
      $start_time = time();
    }

    $now = time();
    
    if ($total > 0) {
      $perc = (double) ($done / $total);
    } else {
      $perc = (double) 1;
    }
    
    $bar = floor($perc * $size);

    // Jump to the begining
    echo "\r";

    // Jump a line up
    echo "\x1b[A";

    $status_bar = "[";
    $status_bar .= str_repeat("=", $bar);

    if ($bar < $size) {
      $status_bar .= ">";
      $status_bar .= str_repeat(" ", $size - $bar);
    } else {
      $status_bar .= "=";
    }

    $disp = number_format($perc * 100, 0);
    $status_bar .= "]";

    $details = $disp . '% ' .  (int)$done . '/' . (int)$total;
    
    if ($done > 0) {
      $rate = ($now - $start_time) / $done;
    } else {
      $rate = $now - $start_time;
    }
    
    $left = $total - $done;
    $eta = round($rate * $left, 2); // Estimated time of arrival
    $elapsed = $now - $start_time; // Elapsed time
    
    $details .= "  Elapsed time: " . $this->toTime($elapsed) . "  Remaining time: " . $this->toTime($eta);
    
    $lineWidth--;

    if (strlen($details) >= $lineWidth) {
      $details = substr($details, 0, $lineWidth - 1);
    }

    echo "$details\n$status_bar";

    flush();
    
    
    if ($done == $total) {
      $start_time = null;
      
      // When done, send a newline.
      echo "\n";
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
  
}
