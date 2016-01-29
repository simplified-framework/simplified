var build = require('simplified-build');

build(function(mix) {
	var bpath = 'vendor/bootstrap-sass/assets';
	var jqueryPath = 'vendor/jquery/dist';
	var jqueryuiPath = 'vendor/jquery-ui';
	var bootboxPath = 'vendor/bootbox';
	var tinymcePath = 'vendor/tinymce';
	var hintcssPath = 'vendor/hint.css';
	var fontawesomePath = 'vendor/font-awesome';
	var tagsPath = 'vendor/tag-it';
	var opensansFontPath = 'vendor/google-open-sans';
	var underscorePath = 'vendor/underscore';
	var underscorestringPath = 'vendor/underscore.string';
	var transitpath = 'vendor/jquery.transit';
	var lightboxpath = 'vendor/lightbox2';
	var knockoutpath = 'vendor/knockoutjs';
	var jformpath = 'vendor/jquery-form';
	var sortablepath = 'vendor/sortable';
	
	mix.sass('scss/*')
		.copy(jqueryPath + '/jquery.min.js', 'public/scripts')
		.copy(jqueryuiPath + '/jquery-ui.min.js', 'public/scripts')
		.copy(bootboxPath + '/bootbox.js', 'public/scripts')
		.copy(tinymcePath, 'public/scripts/tinymce')
		.copy(underscorePath + '/underscore-min.js', 'public/scripts')
		.copy(underscorestringPath + '/dist/underscore.string.min.js', 'public/scripts')
		.copy(tagsPath + '/js/tag-it.min.js', 'public/scripts')
		.copy(tagsPath + '/css/jquery.tagit.css','public/css')
		.copy(fontawesomePath + "/css", 'public/css')
		.copy(hintcssPath + "/hint.min.css", 'public/css')
		.copy(fontawesomePath + "/fonts", 'public/fonts')
		.copy(opensansFontPath + '/open-sans', 'public/fonts/open-sans')
		.copy(bpath + '/fonts', 'public/fonts')
		.copy(bpath + '/javascripts/bootstrap.min.js', 'public/scripts')
		.copy(transitpath + '/jquery.transit.js', 'public/scripts')
		.copy(lightboxpath + '/dist/css/lightbox.min.css', 'public/css')
		.copy(lightboxpath + '/dist/images', 'public/images')
		.copy(lightboxpath + '/dist/js/lightbox.min.js', 'public/scripts')
		.copy(knockoutpath + '/dist/knockout.js', 'public/scripts')
		.copy(jformpath + '/jquery.form.js', 'public/scripts')
		.copy(sortablepath + '/Sortable.min.js', 'public/scripts')
		.copy(sortablepath + '/knockout-sortable.js', 'public/scripts')
		.copy('scripts', 'public/scripts')
		.copy('images', 'public/images')
});
