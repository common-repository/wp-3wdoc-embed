(function() {
	tinymce.create('tinymce.plugins.tag_3wdoc', {
		init : function(ed, url) {
			ed.addButton('tag_3wdoc', {
				title : 'tag_3wdoc.tag_3wdoc',
				image : url+'/tag_3wdoc.png',
				onclick : function() {
					ed.execCommand('mceInsertContent', false, "[tag_3wdoc]");
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "3wdoc",
				author : '3wdoc',
				authorurl : 'http://www.3wdoc.com/',
				infourl : 'http://www.3wdoc.com/',
				version : "0.1"
			};
		}
	});
	tinymce.PluginManager.add('tag_3wdoc', tinymce.plugins.tag_3wdoc);
})();