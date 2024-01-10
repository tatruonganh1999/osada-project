
(function () {
    tinymce.PluginManager.add('insertDivPlugin', function (editor, url) {
        editor.ui.registry.addButton('insertDivButton', {
            text: 'Insert Div',
            onAction: function () {
                insertDiv(editor);
            }
        });

        function insertDiv(editor) {
            const content = '<div style="padding:15px">Your content here.</div>';
            editor.insertContent(content);
        }

        return {
            getMetadata: function () {
                return {
                    name: 'Insert Div Plugin',
                    url: 'https://example.com/docs/insertdivplugin'
                };
            }
        };
    });
  })();