# Upload Permissions

Extension:UploadPermissions allows making certain file types not downloadable to some users. This only works on private wikis using `img_auth.php`.

See https://www.mediawiki.org/wiki/Extension:UploadPermissions for more information

## Usage

After installing the extension, add configuration to `LocalSettings.php` like:

```php
$wgUploadPermsRejectFilesForGroups = [
    'no_images_group' => ['jpg',  'png', 'tiff'],
    'no_documents_group' =>  ['docx', 'pdf', 'xlsx' ],
];
```

The above config would cause any user in the group `no_images_group` to be unable to view/download files with `jpg`, `png`, or `tiff` extensions. The `no_documents_group` cannot download `docx`, `pdf`, or `xlsx` files.

In order for this to work, these groups must already exist. You can configure new groups by adding the following to `LocalSettings.php`:

```php
$wgGroupPermissions['my_new_group'] = [];
```
