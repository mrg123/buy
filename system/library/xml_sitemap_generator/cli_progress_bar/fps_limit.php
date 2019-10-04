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

/**
 * We need this to limit the frequency of the progress bar; otherwise, it hugely slows down the application.
 */
class FPSLimit {

  public $frequency;
  public $maxDt;
  public $timer;
   
  public function __construct($freq) {
    $this->setFrequency($freq);
    $this->timer = new Timer();
    $this->timer->start();
  }

  private function setFrequency($freq) {
    $this->frequency = $freq;
    $this->maxDt = 1.0 / $freq;
  }

  public function frame() {
    $dt = $this->timer->seconds();
    
    if ($dt > $this->maxDt) {
      $this->timer->start($dt - $this->maxDt);
      return true;
    }
    
    return false;
  }

}
