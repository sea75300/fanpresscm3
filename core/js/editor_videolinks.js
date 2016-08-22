/**
 * FanPress CM UI Namespace
 * @article Stefan Seehafer <sea75300@yahoo.de>
 * @copyright (c) 2016, Stefan Seehafer
 * @license http://www.gnu.org/licenses/gpl.txt GPLv3
 */
if (fpcm === undefined) {
    var fpcm = {};
}

fpcm.editor_videolinks = {

    replace: function(text) {

        if (text.search('youtube.com') >= 0) {            
            return text.replace('watch?v=', 'embed/');            
        }

        if (text.search('vimeo.com') >= 0) {            
            return text.replace('vimeo.com', 'player.vimeo.com/video');
        }

        if (text.search('dailymotion.com') >= 0) {            
            return text.replace('/video', '/embed/video');
        }

        if (text.search('clipfish.de') >= 0) {

            var regex = /.*?(video)\/([0-9]*)\/.*?/i;
            var videoId = regex.exec(text);
            if (videoId[2] !== undefined) {
                return 'http://www.clipfish.de/embed_video/?vid=' + videoId[2];
            }

        }

        return text;

    },

}