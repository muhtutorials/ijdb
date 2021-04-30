<?php

namespace Core;

class Markdown {
	private $string;

	public function __construct($string)
	{
		$this->string = $string;
	}

	public function toHtml()
	{
		$text = htmlspecialchars($this->string, ENT_QUOTES, 'UTF-8');
		
		// bold
		$text = preg_replace('/__(.+?)__/s', '<strong>$1</strong>', $text);
		$text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);

		// italic
		$text = preg_replace('/_([^_]+)_/s', '<em>$1</em>', $text);
		$text = preg_replace('/\*([^\*]+)\*/s', '<em>$1</em>', $text);

		// convert Windows linebreaks (\r\n) to Unix (\n)
		// second argument is in double quotes!
		// $text = preg_replace('/\r\n/', "\n", $text);
		// or
		$text = str_replace("\r\n", "\n", $text);

		// convert Macintosh linebreaks (\r) to Unix (\n)
		// second argument is in double quotes!
		// $text = preg_replace('/\r/', "\n", $text);
		// or
		$text = str_replace("\r", "\n", $text);

		// paragraphs
		// $text = '<p>' . preg_replace('/\n\n/', '</p><p>', $text) . '</p>';
		// or
		$text = str_replace("\n\n", '<br><br>', $text);

		// line breaks
		// $text = preg_replace('/\n/', '<br>', $text);
		// or
		$text = str_replace("\n", '<br>', $text);

		// links [text](URL)
		$text = preg_replace('/\[([^\]]+)]\(([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\)/i', '<a href="$2" target="_blank">$1</a>', $text);

		return $text;
	}
}