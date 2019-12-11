/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
    config.language = 'vi';

    config.filebrowserBrowseUrl =  '/organizer/plugins/ckfinder';
    config.filebrowserImageBrowseUrl = '/organizer/plugins/ckfinder?type=Images';
    // config.filebrowserFlashBrowseUrl = '/admin/plugins/ckfinder?type=Flash';
    config.filebrowserUploadUrl = '/organizer/plugins/ckfinder/connector?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl = '/organizer/plugins/ckfinder/connector?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl = '/organizer/plugins/ckfinder/connector?command=QuickUpload&type=Flash';
    config.removePlugins = 'save';
    config.removeButtons = 'save';
};
/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
