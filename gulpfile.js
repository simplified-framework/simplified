var build = require('simplified-build');

build(function(mix) {
    mix
        var bpath = 'vendor/bootstrap/dist';
		var jqueryPath = 'vendor/jquery';
		var jqueryuiPath = 'vendor/jquery-ui';
		var bootboxPath = 'vendor/bootbox';
		var tinymcePath = 'vendor/tinymce';
		var hintcssPath = 'vendor/hint.css';
		var fontawesomePath = 'vendor/fontawesome';
		var tagsPath = 'vendor/tag-it';
		var opensansFontPath = 'vendor/google-open-sans';
		var underscorestringPath = 'vendor/underscore.string';
		
		mix.sass('scss/*')
			.copy(jqueryPath + '/jquery.min.js', 'public/scripts')
			.copy(jqueryuiPath + '/jquery-ui.min.js', 'public/scripts')
			.copy(bootboxPath + '/bootbox.js', 'public/scripts')
			.copy(tinymcePath, 'public/scripts/tinymce')
			.copy(underscorestringPath + '/dist/underscore.string.min.js', 'public/scripts')
			.copy(tagsPath + '/js/tag-it.min.js', 'public/scripts')
			.copy(tagsPath + '/css/jquery.tagit.css','public/css')
			.copy(fontawesomePath + "/css", 'public/css')
			.copy(hintcssPath + "/hint.min.css", 'public/css')
			.copy(fontawesomePath + "/fonts", 'public/fonts')
			.copy(opensansFontPath + '/open-sans', 'public/fonts/open-sans')
			.copy(bpath + '/css/bootstrap-theme.min.css', 'public/css')
			.copy(bpath + '/css/bootstrap-theme.min.css.map', 'public/css')
			.copy(bpath + '/css/bootstrap.min.css', 'public/css')
			.copy(bpath + '/css/bootstrap.min.css.map', 'public/css')
			.copy(bpath + '/fonts', 'public/fonts')
			.copy(bpath + '/js/bootstrap.min.js', 'public/scripts');
});
