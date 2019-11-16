<?php

/**
 * Class neoTable
 *
 * Represents a HTML table constructed from an array of values
 */
class neoTable
{
	private $header;
	private $content;

    /**
     * neoTable constructor.
     *
     * @param array $tableArr An array of table values
     * @param bool $firstLineHeader Whether to treat the first row of the array as the headers
     */
    public function __construct($tableArr, $firstLineHeader = true)
    {
        $offset = 0;
        if ($firstLineHeader == true) {
            $this->header = $tableArr[0];
            $offset++;
        }

        $this->content = array_slice($tableArr, $offset);
    }

    /**
     * Returns the constructed table as HTML
     *
     * @return string A HTML string containing the table
     */
    public function getTable($excludeCols = array())
    {
        return '<table class="table table-bordered table-hover">' . $this->getHeader($excludeCols) . '<tbody>' . $this->getContent($excludeCols) . '</tbody></table>';
    }

	/**
	 * Returns the constructed table as JSON, formatted for use in OE_Charts
	 *
	 * @return string The table contents as JSON
	 */
    public function getChartData()
    {
    	$content = $this->getRawContent();
    	array_unshift($content, $this->getRawHeader());
    	return json_encode($content);
    }

	/**
	 * Returns the HTML formatted content of the table
	 *
	 * @return string Table contents
	 */
    public function getContent($excludeCols = array())
    {
    	$formattedContent = '';

    	foreach ($this->content as $row) {
    		$formattedContent .= '<tr>';
    		foreach($row as $key => $value) {
				if(in_array($key, $excludeCols)) continue;
				
				$cellType = 'td';
				
				$extraAttrs = '';
				if(is_array($value)){
					
					if(isset($value['cell_type']) && !empty($value['cell_type'])) $cellType = $value['cell_type'];
					
					$extraAttrs = $value['attrs'];
					$value = $value['value'];

				}
				
    			$formattedContent .= "<$cellType $extraAttrs>$value</$cellType>";
		    }
		    $formattedContent .= '</tr>';
	    }

	    return $formattedContent;
    }

	/**
	 * Returns the HTML formatted header of the table
	 *
	 * @return string Table header
	 */
    public function getHeader($excludeCols = array())
    {
    	$formattedHeader = '<thead><tr>';

    	foreach($this->header as $key => $value) {
			if(in_array($key, $excludeCols)) continue;
			
			$extraAttrs = '';
			if(is_array($value)){
				$extraAttrs = $value['attrs'];
				$value = $value['value'];
			}
			
	    	$formattedHeader .= "<th scope=\"col\">$value</th>";
	    }
	    $formattedHeader .= "</tr></thead>";

    	return $formattedHeader;
    }

    /**
     * Sets the header row from an array of values
     *
     * @param array $headerArr An array of headers
     */
    public function setHeader($headerArr)
    {
        $this->header = $headerArr;
    }

    /**
     * Adds a row to the table from an array of values
     *
     * @param array $rowArr An array of values
     */
    public function addRow($rowArr)
    {
        $this->content[] = $rowArr;
    }

	/**
	 * Returns the table header in raw array format
	 *
	 * @return array
	 */
	public function getRawHeader()
	{
		return $this->filterHTMLElements($this->header);
	}

	/**
	 * Returns the table content in raw array format
	 *
	 * @return array
	 */
	public function getRawContent()
	{
		return $this->filterHTMLElements($this->content);
	}

	/**
	 * Returns the full table in raw array format
	 *
	 * @return array
	 */
	public function getRawTable()
	{
		$tableArr = $this->getRawContent();
		array_unshift($tableArr, $this->getRawHeader());
		return $tableArr;
	}

	private function filterHTMLElements($array)
	{
		return array_map(function($x) {
			return preg_replace('/<.*?>/', '', $x);
		}, $array);
	}
}