<?php

/**
 * RSS
 * @author Kalashnikov Igor <igor.kalashnikov@gmail.com>
 * @license Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported
 */
 
 // FIXME achtung, shit code!
 
 class RSS {
 
	private $writer;
 
	public static function create($filename) {	
		return new self($filename);
	}
	
	public function __construct($filename) {
		$this->writer = new XMLWriter();
		$this->writer->openURI($filename);
		
		if (defined('DEBUG')) {
			$this->writer->setIndent(4);
		}
		
		$this->writer->startDocument('1.0');
		
		$this->writer->startElement('rss');
			$this->writer->writeAttribute('version', '2.0');
			$this->writer->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');
			
		$this->writer->startElement('channel');
		$this->writer->writeElement('title', 'WorkBreeze');
		$this->writer->writeElement('description', 'WorkBreeze');
		$this->writer->writeElement('link', 'http://workbreeze.com');
		$this->writer->writeElement('ttl', 5);
		$this->writer->writeElement('pubDate', date('D, d M Y H:i:s e'));
	}
	
	public function addItem($title, $link, $description, $guid, $stamp) {
		$this->writer->startElement('item');
		
		$this->writer->writeElement('title', $title);
		$this->writer->writeElement('link', $link);
		
		$this->writer->startElement('description');
		$this->writer->writeCData($description);
		$this->writer->endElement();
		
		$this->writer->writeElement('guid', $guid);		
		$this->writer->writeElement('pubDate', date('D, d M Y H:i:s e', $stamp));
		
		$this->writer->endElement();
	}
	
	public function save() {
		$this->writer->endElement(); // </channel>
		$this->writer->endElement(); // </rss>
		
		$this->writer->endDocument();
		
		$this->writer->flush();
	}
 }
