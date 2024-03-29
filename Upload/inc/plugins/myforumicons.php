<?php
	
	/*
	 *	MyForumIcons
	 *	Created by Ethan DeLong
	 *
	 *	- File: "{$mybb->settings['bburl']}/inc/plugins/myforumicons.php"
	 *
	 *  This plugin and its contents are free for use.
	 *
	 *	Like pokemon? Check out http://www.pokemonforum.org/
	 */
	 
	// Admin settings injection
	$plugins->add_hook("admin_formcontainer_output_row", "myforumicons_admin_settings");
	$plugins->add_hook("admin_forum_management_add_commit", "myforumicons_admin_settings_save");
	$plugins->add_hook("admin_forum_management_edit", "myforumicons_admin_settings_save");
	
	// Inject creation of forum row.
	$plugins->add_hook("build_forumbits_forum", "myforumicons_display_icons");
	
	
	function myforumicons_info()
	{
		return array(
			'name'			=> 'MyForumIcons',
			'description'	=> 'Lets you implement custom icons for your forums.',
			'website'		=> 'http://www.pokemonforum.org',
			'author'		=> 'Ethan',
			'authorsite'	=> 'http://www.pokemonforum.org',
			'version'		=> '1.00',
			'guid'			=> '',
			'compatibility' => '18*'
		);
	}
	
	function myforumicons_install()
	{
		global $db;
		$db->add_column('forums', 'myforumicons_icon', 'TEXT NOT NULL');
	}
	
	function myforumicons_is_installed()
	{
		global $db;
		return $db->field_exists('myforumicons_icon', 'forums');
	}
	
	function myforumicons_uninstall()
	{
		global $db;
		$db->drop_column('forums', 'myforumicons_icon');
	}
	
	function myforumicons_activate()
	{
		require_once MYBB_ROOT."inc/adminfunctions_templates.php";
		find_replace_templatesets("forumbit_depth2_forum", "#".preg_quote("id=\"mark_read_{\$forum['fid']}\"></span>")."#i", "id=\"mark_read_{\$forum['fid']}\" {\$forum['myforumicon_override']}></span>{\$forum['myforumicon']}");
	}
	
	function myforumicons_deactivate()
	{
		require_once MYBB_ROOT."inc/adminfunctions_templates.php";
		find_replace_templatesets("forumbit_depth2_forum", "#".preg_quote(" {\$forum['myforumicon_override']}></span>{\$forum['myforumicon']}")."#i", "></span>");
	}
	
	function myforumicons_display_icons($forum)
	{
		global $theme;
		if(!empty($forum['myforumicons_icon']))
		{
			$icon_path = str_replace("{theme}", $theme['imgdir'], $forum['myforumicons_icon']);
			$forum['myforumicon_override'] = ' style="display: none;"';
			$forum['myforumicon'] = "<img src=\"{$icon_path}\" alt=\"{$forum['name']}\" />";
		}
		return $forum;
	}
	
	function myforumicons_admin_settings(&$pluginargs)
	{
		global $form, $form_container, $forum_data, $lang, $mybb;
		
		if($mybb->input['module'] == 'forum-management')
		{
			if($pluginargs['title'] == $lang->display_order)
			{
				$lang->load('forum_management_myforumicons');
				$form_container->output_row($lang->forum_icons, $lang->forum_icons_desc, $form->generate_text_box('myforumicons_icon', $forum_data['myforumicons_icon'], array('id' => 'myforumicons_icon')));
			}
		}
	}
	
	function myforumicons_admin_settings_save()
	{
		global $db, $fid, $mybb;
		
		if($mybb->request_method == "post")
		{
			$db->update_query("forums", array("myforumicons_icon" => $db->escape_string($mybb->input['myforumicons_icon'])), "fid='{$fid}'");
		}
	}

?>