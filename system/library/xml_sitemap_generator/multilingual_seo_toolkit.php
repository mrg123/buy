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

final class MultilingualSeoToolkit {
  
  /**
   * Registry
   *
   * @var object
   */     
  private $registry;
   
  /**
   * Holds the class instances in the registry object.
   *
   * @var object
   */  
  private $config;
  
  /**
   * Constructor.
   *
   * @param object $registry
   */  
	public function __construct($registry) {
		$this->registry = $registry;
  }
  
  /**
   * Find out whether the Multilingual SEO Toolkit extension is loaded.
   *
   * @param void
   * @return boolean Returns true if the Multilingual SEO Toolkit extension is loaded, false otherwise
   */
  public function extensionLoaded() {
    if (!$this->extensionClassExists()) {
      return false;
    }
    
    return \MultilingualSeoToolkit::extensionLoaded();
  }
  
  /**
   * Find out whether the Multilingual SEO Toolkit extension is enabled.
   *
   * @param void
   * @return boolean Returns true if the Multilingual SEO Toolkit extension is enabled, false otherwise
   */
  public function extensionEnabled() {
    if (!$this->extensionClassExists()) {
      return false;
    }
    
    return \MultilingualSeoToolkit::extensionEnabled();
  }
  
  /**
   * Check whether or not the Multilingual SEO URLs option is enabled.
   *
   * @param void
   * @return boolean
   */
  public function isMultilingualSeoUrlEnabled() {
    if (!$this->extensionClassExists()) {
      return false;
    }
    
    return \MultilingualSeoToolkit::isMultilingualSeoUrlEnabled(); 
  }

  /**
   * Check whether or not the Language Prefix in URL option is enabled.
   *
   * @param void
   * @return boolean
   */
  public function isLanguagePrefixInUrlEnabled() {
    if (!$this->extensionClassExists()) {
      return false;
    }
    
    return \MultilingualSeoToolkit::isLanguagePrefixInUrlEnabled();  
  }
  
  /**
   * Get a language prefix.
   *
   * @param string $code Language code
   * @return string Language prefix
   */
  public function getLangPrefix($code) {
    if (!$this->extensionClassExists()) {
      return false;
    }
    
    return \MultilingualSeoToolkit::getLangPrefix($code);      
  }
  
  /**
   * Checks if the MultilingualSeoToolkit class has been defined.
   *
   * @param void
   * @return boolean Returns true if MultilingualSeoToolkit has been defined, false otherwise. 
   */
  private function extensionClassExists() {
    if (class_exists('\MultilingualSeoToolkit')) {
      return true;
    }
    
    return false;
  }  
  
}
