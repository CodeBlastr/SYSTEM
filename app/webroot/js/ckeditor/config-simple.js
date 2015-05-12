$(function () {
	window.simpletext = window.simpletext || {};
	/**
	 * @param $ | jQuery
	 * @param CK | CKEDITOR
	 * @param w | window
	 *
	 */
	(function ($, CK, w) {
		var MyEditor = function ($container) {
			if ($container.length) {
				var self = this,
						$buttons = $container.find('button');

				if (!$buttons.length) {
					$buttons = $container.find('a');
				}
				if ($buttons.length) {
					$buttons.each(function () {
						var action = 'self.' + $(this).data('action');
						if ($.isFunction(eval(action))) {
							$(this).click(function (e) {
								e.preventDefault();
								eval(action + '()');
							});
						}

					});
				}
			}

		};//editor class
		MyEditor.prototype = (function () {

			var configEditor = function (toolbarButtons, callback) {
				var instanceId = editor_id;
				var editor = CK.instances[instanceId],
						defaultButtons = ['Bold', 'Italic', 'Underline',
							'-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'NumberedList', 'BulletedList', 'Blockquote'];

				if (editor) {
					editor.destroy(true);
				}

				toolbarButtons = $.isArray(toolbarButtons) ? defaultButtons.concat(toolbarButtons) : defaultButtons;

				CK.replace(instanceId, {
					toolbar: [toolbarButtons],
					on: {
						instanceReady: function (event) {
							if ($.isFunction(callback)) {
								callback(event.editor);
							}
						}
					}
				});
			};
			/**
			 *
			 * @param remoteContentsList | array of tab ids which you want to remove from dialog
			 * @param func | callback function
			 */
			var customDialog = function (remoteContentsList, func) {
				CKEDITOR.on('dialogDefinition', function (ev) {
					// Take the dialog name and its definition from the event data.
					var dialogName = ev.data.name,
							dialogDefinition = ev.data.definition;

					if (remoteContentsList.length) {
						for (var index in remoteContentsList) {
							dialogDefinition.removeContents(remoteContentsList[index]);
						}
					}
					func(dialogName, dialogDefinition);
				});
			};
			return{
				'text': function () {
				}, //text method end
				
				'links': function () {
					configEditor(['sharelink'], function (editor) {
						editor.commands.sharelink.exec();
					});
				}, //links methods end
				
				'photos': function () {
					configEditor(['Image'], function (editor) {
						customDialog(['Link', 'advanced'], function (dialogName, dialogDefinition) {
							if (dialogName === 'image') {
								var uploadButton = dialogDefinition.getContents('info').get('txtUrl');
								dialogDefinition.onShow = function () {
								};//overwrite onShow function
								if (uploadButton) {
									uploadButton['onChange'] = function (fileUrl, errorMessage) {
										if (!errorMessage) {
											editor.insertHtml('<img src="' + fileUrl.data.value + '" />');
											CKEDITOR.dialog.getCurrent().hide();
										}
									};
								}
							}
						});
						editor.commands.image.exec();
					});
				}, //photos method end
				
				'audios': function () {
					this.videos();
				}, //audios method end
				
				'videos': function () {
					configEditor(['oembed'], function (editor) {
						customDialog([], function (dname, def) {
							if (dname === 'oembed') {
								var uploadButton = def.getContents('Upload').get('uploadButton');
								if (uploadButton) {
									uploadButton['filebrowser']['onSelect'] = function (fileUrl, error) {
										if (!error) {
											var ext = fileUrl.split('.').pop().toLowerCase(),
													source = '<source src="' + fileUrl + '">Your browser does not support the html 5 media element.';
											if (ext === 'mp4') {
												source = '<video controls>' + source + '</video>';
											} else {
												source = '<audio controls>' + source + '</audio>';
											}
											var element = CKEDITOR.dom.element.createFromHtml('<p>' + source + '</p>');
											editor.insertElement(element);
											CKEDITOR.dialog.getCurrent().hide();
										} else {
											alert(error);
										}
									};
								}
							}
						});
						editor.commands.oembed.exec();
					});
				}, //videos method end
				'documents': function () {
					configEditor(['Link'], function (editor) {
						editor.commands.link.exec();
						customDialog(['target', 'advanced'], function (dialogName, dialogDefinition) {
							if (dialogName === 'link') {
								var uploadButton = dialogDefinition.getContents('info').get('txtUrl');
								if (uploadButton) {
									uploadButton['onChange'] = function (fileUrl, errorMessage) {
										if (!errorMessage) {
											editor.insertHtml('<p><a href="' + fileUrl + '">' + fileUrl.data.value + '</a></p>');
											CKEDITOR.dialog.getCurrent().hide();
										}
									};
								}
							}
						});
					});
				}//documents method end
			};
		})();
		w.simpletext.ck = new MyEditor(jQuery('#editor-buttons'));
	})(jQuery, CKEDITOR, window);
});
