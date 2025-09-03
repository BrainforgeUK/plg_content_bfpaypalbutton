<?php
/**
* @package   PayPal Button
* @version   0.0.1
* @author    http://www.brainforge.co.uk
* @copyright Copyright (C) 2022-2025 Jonathan Brain. All rights reserved.
* @license	 GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// No direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

class plgContentBFPaypalButton extends JPlugin
{
	protected $app;
	protected $hasButton = false;

	/**
	*/
	public function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config);
	}

	/**
	*
	*/
	public function onContentPrepare($context, &$article, &$params, $limitstart)
	{
		$buttoncode = trim($this->params->get('buttoncode'));

		if (empty($buttoncode)) return;

		if (!$this->app->isClient('site')) return;

		if (preg_match_all('/{bfpaypalbutton}/i', $article->text, $matches, PREG_SET_ORDER))
		{
			foreach ($matches as $match)
			{
				if ($this->hasButton)
				{
					$article->text = str_replace($matches[0], '', $article->text);
					continue;
				}

				// Hides button in module when it is already in page content
				$this->hasButton = true;

				$article->text = str_replace('{bfpaypalbutton}', $buttoncode, $article->text);
			}
		}
	}
}
?>