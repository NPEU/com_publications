<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_publications
 *
 * @copyright   Copyright (C) NPEU 2019.
 * @license     MIT License; see LICENSE.md
 */

defined('_JEXEC') or die;

// Import the Joomla model library
jimport('joomla.application.component.model');

/**
 * Publications Model
 */
class PublicationsModelPublications extends JModelLegacy
{

    public function getArticles()
    {
        $base_url = JUri::base();
        return json_decode(file_get_contents($base_url . 'data/publications?type=Journal+Article&collect=year_desc'), true);
    }

    public function getReports()
    {
        $base_url = JUri::base();
        return json_decode(file_get_contents($base_url . 'data/publications?type=Report&collect=year_desc'), true);
    }

    public function getFilteredArticles()
    {
        $base_url = JUri::base();
        return json_decode(file_get_contents($base_url . 'data/publications?type=Journal+Article&collect=year_desc&full_entry=' . urlencode(JFactory::getApplication()->input->get('keywords', '', 'STRING'))), true);
    }


    public function getFilteredReports()
    {
        $base_url = JUri::base();
        return json_decode(file_get_contents($base_url . 'data/publications?type=Report&collect=year_desc&full_entry=' . urlencode(JFactory::getApplication()->input->get('keywords', '', 'STRING'))), true);
    }
}