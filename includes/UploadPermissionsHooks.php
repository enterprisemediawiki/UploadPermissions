<?php

class UploadPermissionsHooks {

	/**
	 * Handler for ImgAuthBeforeStream hook. Allow wikis to disallow access to files (if using
	 * img_auth.php) based on group and file extension.
	 *
	 * @see http://www.mediawiki.org/wiki/Manual:Hooks/ImgAuthBeforeStream
	 *
	 * @param Title &$title
	 * @param string &$path
	 * @param string &$name
	 * @param array &$result
	 * @return bool
	 */
	public static function onImgAuthBeforeStream(
		&$title, string &$path, string &$name, &$result
	) {
		global $wgUser, $wgUploadPermsRejectFilesForGroups;
		$userGroups = $wgUser->getGroups();
		$fileExt = strtolower( pathinfo( $path )['extension'] );

		foreach ( $wgUploadPermsRejectFilesForGroups as $group => $extensions ) {
			$lowercaseExtensions = array_map( strtolower, $extensions );

			// user is a member of this group, and current file is in reject list for the group
			if ( in_array( $group, $userGroups ) && in_array( $fileExt, $lowercaseExtensions ) ) {
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
