<?php
/**
 * @package      Projectfork
 *
 * @author       Tobias Kuhn (eaxs)
 * @copyright    Copyright (C) 2006-2012 Tobias Kuhn. All rights reserved.
 * @license      http://www.gnu.org/licenses/gpl.html GNU/GPL, see LICENSE.txt
 */

defined('_JEXEC') or die();


/**
 * File Repository Helper Class
 *
 */
class ProjectforkHelperRepository
{
    /**
     * Method to get the base upload path for a project
     *
     * @param     int       $project     Optional project id
     *
     * @return    string    $basepath    The upload directory
     */
    public static function getBasePath($project = NULL)
    {
        jimport('joomla.filesystem.path');

        $params = JComponentHelper::GetParams('com_projectfork');

        $base = JPATH_ROOT . '/';
        $dest = $params->get('repo_basepath', '/media/com_projectfork/repo/');

        $fchar = substr($dest, 0, 1);
        $lchar = substr($dest, -1, 1);

        if ($fchar == '/' || $fchar == '\\') {
            $dest = substr($dest, 1);
        }

        if ($lchar == '/' || $lchar == '\\') {
            $dest = substr($dest, 0, -1);
        }

        if (is_numeric($project)) {
            $dest .= '/' . (int) $project;
        }

        $basepath = JPath::clean($base . $dest);

        return $basepath;
    }


    /**
     * Method for translating an upload error code into human readable format
     *
     * @param     integer    $num     The error code
     * @param     string     $name    The name of the file
     *
     * @return    string     $msg     The error message
     */
    public static function getFileErrorMsg($num, $name)
    {
        $size_limit = ini_get('upload_max_filesize');
        $name = '"' . htmlspecialchars($name, ENT_COMPAT, 'UTF-8') . '"';

        switch ($num)
        {
            case 1:
                $msg = JText::sprintf('COM_PROJECTFORK_WARNING_FILE_UPLOAD_ERROR_' . $num, $name, $size_limit);
                break;

            case 2:
                $msg = JText::sprintf('COM_PROJECTFORK_WARNING_FILE_UPLOAD_ERROR_' . $num, $name);
                break;

            case 3:
            case 7:
            case 8:
                $msg = JText::sprintf('COM_PROJECTFORK_WARNING_FILE_UPLOAD_ERROR_' . $num, $name);
                break;

            case 4:
            case 6:
                $msg = JText::_('COM_PROJECTFORK_WARNING_FILE_UPLOAD_ERROR_' . $num);
                break;

            default:
                $msg = JText::sprintf('COM_PROJECTFORK_WARNING_FILE_UPLOAD_ERROR_UNKNOWN' . $num, $name, $num);
                break;
        }

        return $msg;
    }
}
