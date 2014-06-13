<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8' />
        
        <link rel="stylesheet" type="text/css" href="Library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="Header/Css/general.css">
        <link rel="stylesheet" type="text/css" media="all" href="Library/mediaelement/css/styles.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="Library/bootstrap/js/bootstrap.min.js"></script>
        <script src="Library/mediaelement/js/mediaelement-and-player.min.js"></script>
    </head>
    <body>
        <div class="audio-player">
<!--            <audio id="audio-player" src="Library/mediaelement/media/daft4.mp3" autoplay loop controls></audio>-->
        </div><!-- @end .audio-player -->
        <script>
        $(function(){
            $('#audio-player').mediaelementplayer({
                alwaysShowControls: true,
                features: ['playpause','progress','volume'],
                audioVolume: 'horizontal',
                audioWidth: 200,
                iPadUseNativeControls: true,
                iPhoneUseNativeControls: true,
                AndroidUseNativeControls: true
            });
        });
    </script>
        <div id="contentPage">