<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_publications
 *
 * @copyright   Copyright (C) NPEU 2019.
 * @license     MIT License; see LICENSE.md
 */

defined('_JEXEC') or die;

// Import Joomla view library
jimport('joomla.application.component.view');

/**
 * HTML View class for the Publications Component
 */
class PublicationsViewPublications extends JViewLegacy
{
    /**
     * Execute and display a template script.
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  mixed  A string if successful, otherwise an Error object.
     */
    public function display($tpl = null)
    {
        $is_filtered = false;
        $form        = new JForm('filterpubs');
        JForm::addFormPath(JPATH_COMPONENT_SITE . '/models/forms');
        $form->loadFile('filterpubs', false);

        $keywords = JFactory::getApplication()->input->get('keywords');
        if (empty($keywords)) {
            $articles = $this->get('Articles');
            $reports = $this->get('Reports');
            $all = $this->get('All');
        } else {
            $is_filtered = true;
            $articles = $this->get('FilteredArticles');
            $reports  = $this->get('FilteredReports');
            $all  = $this->get('FilteredAll');
        }

        $app   = JFactory::getApplication();
        $menus = $app->getMenu();
        $menu  = $menus->getActive();

        // Get the parameters
        $this->com_params  = JComponentHelper::getParams('com_publications');
        $this->menu_params = $menu->params;


        // Combine pre-2004 reports:
        $t_reports = $reports;
        $reports['Pre-2004 (Selected)'] = array(
            'publications' => array(),
            'length'       => 0
        );
        foreach ($t_reports as $year=>$group) {
            if (((int) $year) < 2004) {
                if(!empty($group['publications'])) {
                    $reports['Pre-2004 (Selected)']['publications'] = array_merge($reports['Pre-2004 (Selected)']['publications'], $group['publications']);
                }
                unset($reports[$year]);
            }
        }
        $reports['Pre-2004 (Selected)']['length'] = count($reports['Pre-2004 (Selected)']['publications']);

        // Total publications:
        $articles_total = 0;
        foreach ($articles as $data) {
            if (!empty($data['publications'])) {
                $articles_total += count($data['publications']);
            }
        }
        $reports_total = 0;
        foreach ($reports as $data) {
            if (!empty($data['publications'])) {
                $reports_total += count($data['publications']);
            }
        }

        // Assign data to the view
        $this->articles           = $articles;
        $this->reports            = $reports;
        $this->all                = $all;
        $this->articles_total     = $articles_total;
        $this->reports_total      = $reports_total;
        $this->publications_total = $articles_total + $reports_total;
        $this->form               = $form;
        $this->is_filtered        = $is_filtered;
        $this->title              = $menu->title;

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }
        // Display the view
        parent::display($tpl);
    }
}