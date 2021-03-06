<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
    /**
  * List of loaded sercices.
  *
  * @var array
  */
 protected $_ci_services = array();
 /**
  * List of paths to load sercices from.
  *
  * @var array
  */
 protected $_ci_service_paths = array();
    /**
     * Constructor.
     * 
     * Set the path to the Service files
     */
    public function __construct()
    {
        parent::__construct();
        $this->_ci_service_paths = array(APPPATH);
    }
    /**
     * Service Loader.
     * 
     * This function lets users load and instantiate classes.
     * It is designed to be called from a user's app controllers.
     *
     * @param string the name of the class
     * @param mixed the optional parameters
     * @param string an optional object name
     */
    public function service($service = '', $params = null, $object_name = null)
    {
        if (is_array($service)) {
            foreach ($service as $class) {
                $this->service($class, $params);
            }

            return;
        }
        if ($service == '' or isset($this->_ci_services[$service])) {
            return false;
        }
        if (!is_null($params) && !is_array($params)) {
            $params = null;
        }
        $subdir = '';
        // Is the service in a sub-folder? If so, parse out the filename and path.
        if (($last_slash = strrpos($service, '/')) !== false) {
            // The path is in front of the last slash
                $subdir = substr($service, 0, $last_slash + 1);
                // And the service name behind it
                $service = substr($service, $last_slash + 1);
        }
        foreach ($this->_ci_service_paths as $path) {
            $filepath = $path.'service/'.$subdir.$service.'.php';
            if (!file_exists($filepath)) {
                continue;
            }

            $name = config_item('subclass_prefix').'Service.php';
            if (class_exists(config_item('subclass_prefix').'Service') === false && file_exists(APPPATH.'core/'.$name)) {
                require APPPATH.'core/'.$name;
            }

            include_once $filepath;
            $service = strtolower($service);
            if (empty($object_name)) {
                $object_name = $service;
            }

            $service = ucfirst($service);
            $CI = &get_instance();
            if ($params !== null) {
                $CI->$object_name = new $service($params);
            } else {
                $CI->$object_name = new $service();
            }
            $this->_ci_services[] = $object_name;

            return;
        }
    }
}
