<?php

namespace Phiro\UI\Partials;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Constants;

class Head extends \Phiro\UI\Partials {

    public function __construct($title = null) {
        $this->toHTML($title);
    }

    public function toHTML($title = null) {
        $ID = rand(111111, 999999); ?>
        <!DOCTYPE html>
        <head>
            <title><?php echo $title; ?></title>
            <link rel='stylesheet' href='<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/www/assets/stylesheets/theme.css?v=1.0' />
            <link rel='stylesheet' href='<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/www/assets/stylesheets/animate.css?v=3.5.1' />
            <script src='<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/www/assets/javascripts/jquery.minified.js?v=3.1.1'></script>
            <link rel='stylesheet' href='<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>//www/assets/packages/sweetAlert/style.css?v=1.1.3' />
            <script src='<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/www/assets/packages/sweetAlert/jquery.minified.js?v=1.1.3'></script>
            <link rel='stylesheet' href='<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/www/assets/stylesheets/font-awesome.minified.css?v=4.7.0' />
            <meta charset="UTF-8" />
        </head>

        <script>
            var Instance = function(instance) {
                this.instance = instance;
            }

            $.extend(Instance.prototype, {
                centerOnScreen: function() {
                    this.instance.css('top', ( $(window).height() - this.object.outerHeight() )/ 2 );
                },
            });

            function Instance_centerOnScreen(instance) {
                var height;
                if( ($(window).height() - instance.outerHeight()) >= 0) height = ( $(window).height() - instance.outerHeight() ) / 2;
                else height = 0;
                instance.css('top', height);
            }

            function Instance_isNull(instance) {
                if(instance == undefined || instance == null || instance.length < 1) return true;
                return false;
            }

            jQuery(document).ready(function ($) {
                var close = window.swal.close;
                var previousWindowKeyDown = window.onkeydown;
                window.swal.close = function() {
                    close();
                    window.onkeydown = previousWindowKeyDown;
                };
			});
        </script>

        <div id="phiro-overlay-<?php echo $ID; ?>" class="phiro-overlay">
            <div class='container'>
                <div class='content'>
                    <h3 class='heading'>Installazione guidata di Phiro Framework 1.0</h3>
                </div>
            </div>
        </div>

        <script>
            var phiroOverlay = [];
            phiroOverlay.instance = $('#phiro-overlay-<?php echo $ID;?>');
            phiroOverlay.content = phiroOverlay.instance.find('.content');

            jQuery(document).ready(function($) {
                Instance_centerOnScreen(phiroOverlay.content);
            });

            jQuery(window).resize(function() {
                if(!Instance_isNull(phiroOverlay.content)) Instance_centerOnScreen(phiroOverlay.content);
            });
        </script>


   <?php }

}


?>