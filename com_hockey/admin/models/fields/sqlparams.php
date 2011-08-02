<?php

/*
 * @package Joomla 1.6
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Hockey League
 * @copyright Copyright (C) Klich Jarosław
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Supports an SQL select list of menu
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldSqlParams extends JFormFieldList {

    /**
     * The form field type.
     *
     * @var		string
     * @since	1.6
     */
    public $type = 'SqlParams';

    /**
     * Method to get the field options.
     *
     * @return	array	The field option objects.
     * @since	1.6
     */
    protected function getOptions() {
        // Initialize variables.
        $options = array();

        // Initialize some field attributes.
        $key = $this->element['key_field'] ? (string) $this->element['key_field'] : 'value';
        $value = $this->element['value_field'] ? (string) $this->element['value_field'] : (string) $this->element['name'];
        $translate = $this->element['translate'] ? (string) $this->element['translate'] : false;
        $opt1 = $this->element['opt1'] ? (string) $this->element['opt1'] : false;
        $query = (string) $this->element['query'];

        // Get the database object.
        $db = JFactory::getDBO();
        // Set the query and get the result list.
        $db->setQuery($query);
        $items = $db->loadObjectlist();
        // Check for an error.
        if ($db->getErrorNum()) {
            JError::raiseWarning(500, $db->getErrorMsg());
            return $options;
        }

        // Build the field options.
        if ($opt1) {
            if ($translate == true) {
                $options[] = JHtml::_('select.option',0, JText::_($opt1));
            } else {
                $options[] = JHtml::_('select.option',0, $opt1);
            }
        }

        if (!empty($items)) {
            foreach ($items as $item) {
                if ($translate == true) {
                    $options[] = JHtml::_('select.option', $item->$key, JText::_($item->$value));
                } else {
                    $options[] = JHtml::_('select.option', $item->$key, $item->$value);
                }
            }
        }
        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);
        return $options;
    }

}
