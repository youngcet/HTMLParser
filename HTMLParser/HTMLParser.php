<?php

	namespace App\Custom;

	require ('ErrorDescriptions.php');
    require ('Error.php');

	/**
	 * Substitutes data on a given string
	 *
	 * This class substitutes a dataset in a given string. 
	 * Compiles php code contained in the string enclosed in <!--php-code endcode--> 
	 * Populates a list enclosed between <%=list dataset="name" =%> using the dataset in dataset="name"
	 *
	 * @category   App\Custom
	 * @package    App\Custom\HTMLParser
	 * @author     Cedric Maenetja <cedricm@permanentlink.co.za>
	 * @copyright  2022 Permanent Link CO
	 * @license    Permanent Link CO
	 * @version    Release: 1.0
	 */ 

	class HTMLParser
	{
		private $_htmlstring;
		private $_data;

		private $_execcodepattern = '<!--php-code(.|\n)*?endcode-->';
		private	$_execcodestartpattern = '<!--php-code';
		private	$_execcodeendpattern = 'endcode-->';

		private $_classname;

		public function __construct ($string, $data)
		{
			$this->_htmlstring = $string;
			$this->_data = $data;

			$this->_classname = get_class();
		}


		/**
		 * Substitutes data on a given string
		 *
		 * @param string  	$string The string to do substitutions on
		 * @param array 	$data 	The dataset to substitute on the string
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return String Substituted string or error
		 */ 

		public function GetSubstitutedString()
		{
			$string = $this->SubstListData ($this->_htmlstring, $this->_data);
			if (Error::IsAnError ($string)) return $string;

			$string = $this->CompileExecutableCode ($string, $this->_data);

			return (Error::IsAnError ($string)) ? $string : $this->SubstStringData ($string, $this->_data);
		}



		/**
		 * Compile PHP Code
		 *
		 * @param String  	$string The string to do substitutions on
		 * @param array 	$data 	The dataset to substitute on the string
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return String Substituted string or an error
		 */ 

		private function CompileExecutableCode ($string, $data)
		{
			$execcodepattern = $this->_execcodepattern;
			$startpattern = $this->_execcodestartpattern;
			$endpattern = $this->_execcodeendpattern;
			
			if (preg_match_all ("/$execcodepattern/", $string, $executablecode))
			{
				foreach ($executablecode[0] as $code)
				{
					$substtext = trim ($this->SubstStringData ($code, array ($startpattern => '', $endpattern => '')));
					$substtext = $this->SubstStringData ($substtext, $data);
					
					try
					{
						$substtext = eval ("$substtext");
					}
					catch (ParseError $e)
					{
						return new Error (100, sprintf ('%s\Error: '.$e->getMessage().' - %s', $this->_classname, $code));
					}
						
					$string = str_replace ($code, $substtext, $string);
				}
				
				return $string;
			}
		}



		/**
		 * Populates a list
		 *
		 * @param String  	$string The string to do substitutions on
		 * @param array 	$data 	The dataset to substitute on the string
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return String Substituted string or error
		 */ 

		private function SubstListData ($string, $data)
		{
			$startpattern = $this->_execcodestartpattern;

			if (preg_match_all ('/<%=list dataset="([^"]+?)"/', $string, $listsInString))
			{
				for ($i = 0; $i < count ($listsInString[0]); $i++)
				{
					$id = $listsInString[1][0];
					$list = $listsInString[0][0];

					if (preg_match_all ("/$list/", $string, $totalListsById))
					{
						if (count ($totalListsById[0]) > 1) return new Error (-1, sprintf ('%s\Error: Duplicate list id [%s]', $this->_classname, $id));
					}
					
					for ($h = 0; $h < count ($listsInString[0]); $h++)
					{
						$htmlList = $listsInString[0][$h];
						$listContent = '';
						
						if (preg_match ("/$htmlList(.|\n)*?=%>/", $string, $listSection))
						{	
							if (! isset ($data[$listsInString[1][$h]])) 
							{
								return new Error (-1, sprintf ('%s\Error: Array [%s] not defined', $this->_classname, $listsInString[1][$h]));
							}

							foreach ($this->Iterator ($data[$listsInString[1][$h]]) as $dataArray)
							{
								$textToSubstitute = trim ($this->SubstStringData ($listSection[0], array ($htmlList => '', '=%>' => '')));

								if (preg_match ("/$startpattern/", $textToSubstitute)) $textToSubstitute = $this->CompileExecutableCode ($textToSubstitute, $dataArray);
								if (! empty ($textToSubstitute)) $listContent .= $this->SubstStringData ($textToSubstitute, $dataArray);
							}

							$string = str_replace ($listSection[0], $listContent, $string);
						}
					}
				}
			}

			return $string;
		}

		/**
		 * Substitutes strings
		 *
		 * @param String  	$string The string to do substitutions on
		 * @param array 	$data 	The dataset to substitute on the string
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return String Substituted string or error
		 */ 

		private function SubstStringData ($templateString, $data)
		{
			if (! is_array ($data)) return $templateString;
			
			foreach ($this->Iterator ($data) as $key => $value)
			{
				$templateString = (is_array ($value)) ? $this->SubstStringData ($templateString, $value) : str_replace ($key, $value, $templateString);
			}

			return $templateString;
		}

		/**
		 * PHP Generator
		 *
		 * @param array 	$arr 	The array to yield
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return array yield element
		 */ 

		private function Iterator ($arr)
		{
			foreach ($arr as $key => $value)
			{
				yield $key => $value;
			}
		}
	}

?>