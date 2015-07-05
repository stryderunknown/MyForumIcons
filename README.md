# MyForumIcons
Set custom icons for your MyBB forums.

MyForumIcons allows you to set custom images for your forum icons.

You can edit these icons through your Forum Management settings in the "Edit Forum Settings" tabs.

##### Alternative version #####
For this alternative version there are some changes you'd need to make to get this to work:
Firstly you need to make sure that you've decided on a size for the images and you'll need to create a replacement
forum_icon_sprite.png based upon that.  In this example lets say you want to use 50 x 50 pixels images. That means the forum_icon_sprite.png will be 50x(50x4) pixels in size.

That's four squares of 50 x 50 in a vertical strip.

The first block (The top 50 x 50 pixels) represents there is new posts,
The second represents there is no new posts,
The third represents that the subforum is locked,
the forth (The bottom 50 x 50 pixels) represents that the subforum is a link to an external site.

These blocks are then used by CSS when the right status is met.  You'll find code similar to "below" in your forums global.css stylesheet (although the sizes have been altered to fit with this example)

##### global.css stylesheet ####
.forum_status {
	background: url(images/forum_icon_sprite.png) no-repeat 0 0;
	height: 50px;
	display: inline-block;
	width: 50px;
}

.forum_on {
	background-position: 0 0;
}

.forum_off {
	background-position: 0 -50px;
}

.forum_offlock {
	background-position: 0 -100px;
}

.forum_offlink {
	background-position: 0 -150px;
}

#### end global.css stylesheet ####

When you create the image, keep the majority of the blocks transparent since these images will appear on top of your forum custom images.

The only other thing that needs editing is the forumbit_depth2_forum template where the first TD element has a width of only 1px on new installs.  In this version the value had been changed to 50px.




