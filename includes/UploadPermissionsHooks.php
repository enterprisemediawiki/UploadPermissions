<?php

class UploadPermissionsHooks {

	/**
	 * Handler for PersonalUrls hook. Replace the "watchlist" item on the user
	 * toolbar ('personal URLs') with a link to Special:PendingReviews.
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/PersonalUrls
	 *
	 * @param array &$title
	 * @param string &$path
	 * @param string &$name
	 * @param array &$result
	 * @return bool
	 */
	public static function onImgAuthBeforeStream(
		Title &$title, string &$path, string &$name, array &$result
	) {
		global $wgUser, $wgUploadPermsRejectFilesForGroups;
		$userGroups = $wgUser->getGroups();
		$fileExt = pathinfo( $path )['extension'];

		foreach ( $wgUploadPermsRejectFilesForGroups as $group => $extensions ) {
			// user is a member of this group, and current file is in reject list for the group
			if ( in_array( $group, $userGroups ) && in_array( $fileExt, $extensions ) ) {
				$result = [
					'img-auth-accessdenied',
					'img-auth-noread',
					$name
				];
				return false;
			}
		}

		// User is allowed to view
		return true;
	}

}
