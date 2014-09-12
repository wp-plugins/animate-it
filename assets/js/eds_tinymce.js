(function() {
	tinymce.create('tinymce.plugins.EDSAnimate', {
		init : function(editor, url) {
			editor.addButton('edsanimate', {
				title : 'Animate It!',
				icon : true,
				image : url+'/../images/edsanimate.png',
				onclick : function() {
					editor.windowManager.open({
						file : url + '/../helper/eds_tinymce_popup.php',
						width : window.innerWidth-100,
						height : window.innerHeight-100,
						inline : 1
					}, {
						plugin_url : url // Plugin absolute URL
					});				
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "Animate It! ShortCode",
				author : 'Eleopard Design Studios Pvt. Ltd.',
				authorurl : 'http://eleopard.in/',
				infourl : 'http://downloads.eleopard.in/',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('edsanimate', tinymce.plugins.EDSAnimate);
})();
