/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	//khi len host
	//var base_url = window.location.origin + '/public'
	//native local
	var base_url = 'http://localhost:88/vietvangjsc/vietvangjsc/public';
	config.filebrowserBrowseUrl= base_url + '/ckfinder/ckfinder.html';
    config.filebrowserImageBrowseUrl= base_url + '/ckfinder/ckfinder.html?Type=Images';
    config.filebrowserFlashBrowseUrl= base_url + '/ckfinder/ckfinder.html?Type=Flash';
    config.filebrowserUploadUrl= base_url + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
    config.filebrowserImageUploadUrl= base_url + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
    config.filebrowserFlashUploadUrl= base_url + '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
