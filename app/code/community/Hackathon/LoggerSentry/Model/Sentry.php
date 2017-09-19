<?php

class Hackathon_LoggerSentry_Model_Sentry extends Zend_Log_Writer_Abstract
{
    /**
     * @var array
     */
    protected $_options = array();

    /**
     * sentry client
     *
     * @var Raven_Client
     */
    protected $_sentryClient;

    protected $_priorityToLevelMapping
        = array(
            0 => 'fatal',
            1 => 'fatal',
            2 => 'fatal',
            3 => 'error',
            4 => 'warning',
            5 => 'info',
            6 => 'info',
            7 => 'debug'
        );

    /**
     *
     *
     * ignore filename - it is Zend_Log_Writer_Abstract dependency
     *
     * @param string $filename
     *
     * @return \Hackathon_LoggerSentry_Model_Sentry
     */
    public function __construct($filename)
    {
        /* @var $helper Hackathon_Logger_Helper_Data */
        $helper = Mage::helper('firegento_logger');
        $options = array(
            'logger' => $helper->getLoggerConfig('sentry/logger_name')
        );
        try {
            $this->_sentryClient = new Raven_Client($helper->getLoggerConfig('sentry/apikey'), $options);
        } catch (Exception $e) {
            // Ignore errors so that it doesn't crush the website when/if Sentry goes down.
        }

    }

    /**
     * Places event line into array of lines to be used as message body.
     *
     * @param FireGento_Logger_Model_Event $event Event data
     *
     * @throws Zend_Log_Exception
     * @return void
     */
    protected function _write($eventObj)
    {
        try {
            /* @var $helper Hackathon_Logger_Helper_Data */
            $helper = Mage::helper('firegento_logger');
            $helper->addEventMetadata($eventObj);

            $event = $eventObj->getEventDataArray();

            $additional = array(
                'file' => $event['file'],
                'line' => $event['line'],
            );

            foreach (array('REQUEST_METHOD', 'REQUEST_URI', 'REMOTE_IP', 'HTTP_USER_AGENT') as $key) {
                if (!empty($event[$key])) {
                    $additional[$key] = $event[$key];
                }
            }

            $this->_assumePriorityByMessage($event);

            // if we still can't figure it out, assume it's an error
            $priority = isset($event['priority']) && !empty($event['priority']) ? $event['priority'] : 3;

            if (!$this->_isHighEnoughPriorityToReport($priority)) {
                return $this; // Don't log anything warning or less severe.
            }

            $this->_sentryClient->captureMessage(
                $event['message'], array(), $this->_priorityToLevelMapping[$priority], true, $additional
            );

        } catch (Exception $e) {
            throw new Zend_Log_Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param  int  $priority 
     * @return boolean           True if we should be reporting this, false otherwise.
     */
    protected function _isHighEnoughPriorityToReport($priority)
    {
        if ($priority > (int)Mage::helper('firegento_logger')->getLoggerConfig('sentry/priority')) {
            return false; // Don't log anything warning or less severe than configured.
        }
        return true;
    }

    /**
     * Try to attach a priority # based on the error message string (since sometimes it is not specified)
     * @param FireGento_Logger_Model_Event &$event Event data
     * @return \Hackathon_LoggerSentry_Model_Sentry
     */
    protected function _assumePriorityByMessage(&$event)
    {
        if (stripos($event['message'], "warn") === 0) {
            $event['priority'] = 4;
        }
        if (stripos($event['message'], "notice") === 0) {
            $event['priority'] = 5;
        }

        return $this;
    }

    /**
     * Satisfy newer Zend Framework
     *
     * @static
     *
     * @param $config
     *
     * @return void
     */
    static public function factory($config)
    {
    }
}
