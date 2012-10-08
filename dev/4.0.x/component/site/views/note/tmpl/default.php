<?php
/**
* @package   Projectfork
* @copyright Copyright (C) 2006-2011 Tobias Kuhn. All rights reserved.
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL, see LICENSE.txt
*
* This file is part of Projectfork.
*
* Projectfork is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
*
* Projectfork is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Projectfork. If not, see <http://www.gnu.org/licenses/gpl.html>.
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

// Create shortcuts to some parameters.
$item    = &$this->item;
$params	 = $item->params;
$canEdit = $item->params->get('access-edit');
$user	 = JFactory::getUser();
$uid	 = $user->get('id');

$asset_name = 'com_projectfork.note.'.$this->item->id;
$canEdit	= ($user->authorise('core.edit', $asset_name) || $user->authorise('note.edit', $asset_name));
$canEditOwn	= (($user->authorise('core.edit.own', $asset_name) || $user->authorise('note.edit.own', $asset_name)) && $this->item->created_by == $uid);
?>
<div id="projectfork" class="item-page view-task">
	<?php if ($this->params->get('show_page_heading', 1)) : ?>
        <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    <?php endif; ?>

    <div class="page-header">
	    <h2><?php echo $this->escape($item->title); ?></h2>
	</div>

	<dl class="article-info dl-horizontal pull-right">
		<dt class="project-title">
			<?php echo JText::_('JGRID_HEADING_PROJECT');?>:
		</dt>
		<dd class="project-data">
			<a href="<?php echo JRoute::_(ProjectforkHelperRoute::getDashboardRoute($item->project_slug));?>"><?php echo $item->project_title;?></a>
		</dd>
		<dt class="owner-title">
			<?php echo JText::_('JGRID_HEADING_CREATED_BY');?>:
		</dt>
		<dd class="owner-data">
			 <?php echo $this->escape($this->item->author);?>
		</dd>
	</dl>
	<div class="actions btn-toolbar">
		<div class="btn-group">
			<?php if($canEdit || $canEditOwn) : ?>
			   <a class="btn" href="<?php echo JRoute::_('index.php?option=com_projectfork&task=noteform.edit&id='.intval($item->id).':'.$item->alias);?>">
			       <i class="icon-edit"></i> <?php echo JText::_('COM_PROJECTFORK_ACTION_EDIT');?>
			   </a>
			<?php endif; ?>
			<!--<a href="#" class="btn"><i class="icon-print"></i> Print</a>
			<a href="#" class="btn"><i class="icon-envelope"></i> Email</a>
			<a href="#comments" class="btn"><i class="icon-comment"></i> Comment <span class="badge badge-warning">4</span></a>-->
            <?php echo $item->event->afterDisplayTitle;?>
		</div>
	</div>

    <?php echo $item->event->beforeDisplayContent;?>

	<div class="item-description">
		<?php echo $item->text; ?>
	</div>
	<hr />

    <?php echo $item->event->afterDisplayContent;?>

</div>