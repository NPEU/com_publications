<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_publications
 *
 * @copyright   Copyright (C) NPEU 2019.
 * @license     MIT License; see LICENSE.md
 */

defined('_JEXEC') or die;

// Import Joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by Publications
$controller = JControllerLegacy::getInstance('Publications');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();