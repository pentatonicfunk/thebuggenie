<tr id="show_component_<?php print $component->getID(); ?>" class="hover_highlight">
	<td style="width: 20px; padding: 2px;"><?php echo image_tag('icon_components.png'); ?></td>
	<td style="width: auto; padding: 2px;" id="component_<?php echo $component->getID(); ?>_name"><?php print $component->getName(); ?></td>
	<td style="width: 60px; text-align: right;">
		<a href="javascript:void(0);" class="image" onclick="$('edit_component_<?php print $component->getID(); ?>').show();$('c_name_<?php echo $component->getID(); ?>').focus();" style="font-size: 9px;"><?php echo image_tag('icon_edit.png'); ?></a>
		<a href="javascript:void(0);" onclick="$('component_<?php echo $component->getID(); ?>_permissions').toggle();" class="image" title="<?php echo __('Set permissions for this component'); ?>" style="margin-right: 5px;"><?php echo image_tag('cfg_icon_permissions.png'); ?></a>
		<?php echo javascript_link_tag(image_tag('action_delete.png'), array('class' => 'image', 'onclick' => "TBG.Main.Helpers.Dialog.show('".__('Please confirm')."', '".__('Do you really want to delete this component?')."', {yes: {click: function() {TBG.Project.Component.remove('".make_url('configure_delete_component', array('project_id' => $component->getProject()->getID(), 'component_id' => $component->getID()))."', ".$component->getID().");}}, no: {click: TBG.Main.Helpers.Dialog.dismiss}})")); ?>
	</td>
</tr>
<tr id="edit_component_<?php print $component->getID(); ?>" style="display: none;">
	<td colspan="3">
		<div class="backdrop_box large">
			<div class="backdrop_detail_header"><?php echo __('Edit component'); ?></div>
			<div class="backdrop_detail_content">
				<form accept-charset="<?php echo TBGContext::getI18n()->getCharset(); ?>" action="<?php echo make_url('configure_update_component', array('project_id' => $component->getProject()->getID(), 'component_id' => $component->getID())); ?>" method="post" id="edit_component_<?php echo $component->getID(); ?>_form" onsubmit="TBG.Project.Component.update('<?php echo make_url('configure_update_component', array('project_id' => $component->getProject()->getID(), 'component_id' => $component->getID())); ?>', <?php echo $component->getID(); ?>);return false;">
				<table>
					<tr><td><label for="cname_<?php print $component->getID(); ?>"><?php echo __('Name'); ?></label></td><td colspan="2"><input type="text" name="c_name" id="c_name_<?php echo $component->getID(); ?>" value="<?php print $component->getName(); ?>" style="width: 260px;"></td></tr>
					<tr>
						<td>
							<b><?php echo __('Auto assign'); ?></b>
						</td>
						<td style="<?php if (!$component->hasLeader()): ?>display: none; <?php endif; ?>padding: 2px;" id="comp_<?php echo $component->getID(); ?>_auto_assign_name">
							<div style="width: 270px; display: <?php if ($component->hasLeader()): ?>inline<?php else: ?>none<?php endif; ?>;" id="comp_<?php echo $component->getID(); ?>_auto_assign_name">
								<?php if ($component->getLeader() instanceof TBGUser): ?>
									<?php echo include_component('main/userdropdown', array('user' => $component->getLeader())); ?>
								<?php elseif ($component->getLeader() instanceof TBGTeam): ?>
									<?php echo include_component('main/teamdropdown', array('team' => $component->getLeader())); ?>
								<?php endif; ?>
							</div>
						</td>
						<td style="<?php if ($component->hasLeader()): ?>display: none; <?php endif; ?>padding: 2px;" class="faded_out" id="no_comp_<?php echo $component->getID(); ?>_auto_assign">
							<?php echo __('Noone'); ?>
						</td>
						<td style="padding: 2px; width: 100px; font-size: 0.9em; text-align: right;"><a href="javascript:void(0);" onclick="$('comp_<?php echo $component->getID(); ?>_auto_assign_change').toggle();" title="<?php echo __('Switch'); ?>"><?php echo __('Change / set'); ?></a></td>
					</tr>
					<tr><td class="config_explanation" colspan="3"><?php echo __('You can optionally set a user to automatically assign issues filed against this component to. This setting is independant of the save button below.')?></td></tr>
				</table>
				<?php echo image_tag('spinning_20.gif', array('id' => 'component_'.$component->getID().'_indicator', 'style' => 'display: none;')); ?>
				<input type="submit" value="<?php echo __('Save'); ?>">
				</form>
				<?php include_component('main/identifiableselector', array(	'html_id'		=> 'comp_'.$component->getID().'_auto_assign_change',
																		'header' 			=> __('Change / set auto assignee'),
																		'clear_link_text'	=> __('Set auto assignee by noone'),
																		'style'				=> array('position' => 'absolute'),
																		'callback'			=> "TBG.Project.setUser('" . make_url('configure_component_set_assignedto', array('project_id' => $component->getProject()->getID(), 'component_id' => $component->getID(), 'field' => 'lead_by', 'identifiable_type' => '%identifiable_type%', 'value' => '%identifiable_value%')) . "', 'comp_".$component->getID()."_auto_assign');",
																		'base_id'			=> 'comp_'.$component->getID().'_auto_assign',
																		'absolute'			=> true,
																		'include_teams'		=> true)); ?>
			</div>
			<div class="backdrop_detail_footer">
				<a href="javascript:void(0);" onclick="$('edit_component_<?php echo $component->getID(); ?>').hide();"><?php echo __('Close'); ?></a>
			</div>
		</div>
		<div class="fullpage_backdrop"></div>
	</td>
</tr>
<tr id="component_<?php echo $component->getID(); ?>_permissions" style="display: none;">
	<td colspan="3">
		<div class="rounded_box white" style="margin: 5px 0 10px 0; padding: 3px; font-size: 12px;">
			<div class="header"><?php echo __('Permission details for "%itemname%"', array('%itemname%' => $component->getName())); ?></div>
			<div class="content">
				<?php echo __('Specify who can access this component.'); ?>
				<?php include_component('configuration/permissionsinfo', array('key' => 'canseecomponent', 'mode' => 'project_hierarchy', 'target_id' => $component->getID(), 'module' => 'core', 'access_level' => $access_level)); ?>
			</div>
		</div>
	</td>
</tr>
