<?php

    namespace App\Custom;

    /**
	 * Sets & Returns Errors
	 *
	 * This class returns errors. 
	 *
	 * @category   App\Custom
	 * @package    App\Custom\Error
	 * @author     Cedric Maenetja <cedricm@permanentlink.co.za>
	 * @copyright  2022 Permanent Link CO
	 * @license    Permanent Link CO
	 * @version    Release: 1.0
	 */ 

    class Error
    {
        private $_error;
        private $_error_code;

        public function __construct ($code, $error)
        {
            $this->_error = $error;
            $this->_error_code = $code;

            $this->SetError ($error);
            $this->SetErrorCode ($code);
        }

        private function SetError ($error)
        {
            $this->_error = $error;
        }

        private function SetErrorCode ($code)
        {
            $this->_error_code = $code;
        }

        public static function IsAnError ($error)
        {
            return (is_a ($error, 'App\Custom\Error')) ? true : false;
        }

        public function GetError()
        {
            return $this->_error;
        }

        public function GetErrorCode()
        {
            return $this->_error_code;
        }

        public static function GetErrorDescription ($code)
        {
            return Error\Descriptions::GetDescription ($code);
        }
    }
?>