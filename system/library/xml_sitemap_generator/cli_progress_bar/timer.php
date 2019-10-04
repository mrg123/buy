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

class Timer {

  public $time;

  public function __construct() {
    $this->start();
  }

  public function start($offset = 0) {
    $this->time = microtime(true) + $offset;
  }

  public function seconds() {
    return microtime(true) - $this->time;
  }

}

