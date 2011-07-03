(function () {

    tinymce.PluginManager.requireLangPack('flash');

    tinymce.create('tinymce.plugins.FlashPlugin', {

        init: function (ed, url) {

            ed.addCommand('mceFlash', function () {

                ed.windowManager.open({
                    file: url + '/flash.htm',
                    width: 380 + parseInt(ed.getLang('example.delta_width', 0)),
                    height: 130 + parseInt(ed.getLang('example.delta_height', 0)),
                    inline: 1
                }, {
                    plugin_url: url
                });
            });

            ed.addButton('flash', {
                title: 'flash.desc',
                cmd: 'mceFlash',
                image: url + '/img/flash.gif'
            });

            ed.onNodeChange.add(function (ed, cm, n) {

                cm.setActive('flash', (n.nodeName == 'IMG' && n.className.match(/mceItem flash/)));
                cm.setDisabled('flash', !(n.nodeName == 'IMG' && n.className.match(/mceItem flash/)) && ed.selection.getContent().length > 0);
            });
        },

        createControl: function (n, cm) {
            return null;
        },

        getInfo: function () {
            return {
                longname : 'Beehive Forum TinyMCE 3.x Flash Plugin',
                author : 'Project Beehive Forum',
                authorurl : 'http://www.beehiveforum.net',
                infourl : 'http://www.beehiveforum.net',
                version : '1.0'
            };
        }
    });

    tinymce.PluginManager.add('flash', tinymce.plugins.FlashPlugin);
})();