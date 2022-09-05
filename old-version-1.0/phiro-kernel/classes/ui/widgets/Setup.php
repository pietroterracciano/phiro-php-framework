<?php

namespace Phiro\UI\Widgets;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Constants;

class Setup extends \Phiro\UI\Widgets {

    public function __construct() {
        $this->toHTML();
    }

    public function toHTML() { 
        $ID = rand(111111, 999999); ?>

        <div id='phiro-setup-<?php echo $ID;?>' class='phiro-setup'>
            <div id="phiro-overlay-<?php echo $ID; ?>" class="phiro-overlay">
                <div class='container'>
                    <div class='content'>
                        <h3 class='heading'>Installazione guidata di Phiro Framework 1.0</h3>
                    </div>
                </div>
            </div>
            <div class='container'>
                <div class='content'>
                        <h5 class='heading'>Installazione guidata di Phiro Framework 1.0</h5>
		
                        <div class="steps labels">
                            <p><b>01.</b> Introduzione</p>
                            <p><b>02.</b> Connessione al DB</p>
                            <p><b>03.</b> Schema DB</p>
                            <p><b>04.</b> Regole di Rewrite</p>
                            <p><b>05.</b> Configurazione Completata</p>
                        </div>
		
                        <div class="steps tab 1">
                            <p>Benvenuto =)! Questa installazione guidata ti permetterà di collegare facilmente il Database al Phiro Framework, inoltre potrai creare in tempo reale uno schema di Database (Tabelle) utilizzando il configuratore integrato</p>
                            <p>Puoi saltare l'installazione guidata modificando il file phiro-config-sample.php, salvandolo come phiro-config.php. Inoltre puoi scrivere direttamente uno Schema di Database in linguaggio MySQL nel file phiro-db-schema-sample.php, salvandolo come phiro-db-schema.php (Se si decide di utilizzare la strada manuale e di creare uno Schema di DB utilizzando il file phiro-db-schema.php, è necessario salvare prima quest'ultimo e successivamente creare il phiro-config.php)</p>
                            <a href="#" class="button forward black">Avanti</a>
                        </div>

                         <div class="steps tab 2 display-none" id="CONNECTION_TO_DATABASE">
                             <div class="field w50p left">
                                <p>*Nome Database</p>
                                <input type="text" id="DB_NAME" placeholder="<Nome Database>" />
                                <div class="error"></div>
                            </div>
                            <div class="field w50p right">
                                <p>*Host Database</p>
                                <input type="text" id="DB_HOST" placeholder="<Host Database>" />
                                <div class="error"></div>
                            </div>
                            <div class="field w50p left">
                                <p>*Nome Utente</p>
                                <input type="text" id="DB_USER" placeholder="<Nome Utente>" />
                                <div class="error"></div>
                            </div>
                            <div class="field w50p right">
                                <p>*Password Utente</p>
                                <input type="password" data-required="false" id="DB_PASSWORD" placeholder="<Password Utente>" />
                                <div class="error"></div>
                            </div>
                            <a href="#" class="button backward black">Indietro</a>
                            <a href="#" class="button forward black">Avanti</a>
                        </div>
                        
                        <div class="steps tab 3 display-none" id="EDIT_DATABASE_TABLES">
                            <div class="table database-tables">
                                <div class="row">
                                    <div class="column heading">-</div>
                                    <div class="column heading">Tabella</div>
                                    <div class="column heading">Azioni</div>
                                </div>

                                <div class="row animated" data-name="ev19ragbtfzp5ju60ghb_commentmeta"><div class="column">&nbsp;</div><div class="column" style="min-width: 600px">ev19ragbtfzp5ju60ghb_commentmeta</div><div class="column"><a data-actionfile="getTableSchema.php" href="#no-link" class="button small black">Struttura</a> <a data-actionfile="truncateTable.php" href="#no-link" class="button small red">Svuota</a> <a data-actionfile="deleteTable.php" href="#no-link" class="button small red">Elimina</a> <div class="status animated">Errore</div></div>
                                     <div class="table">
                                        <div class="row">
                                            <div class="column heading">Campo</div>
                                            <div class="column heading">Tipo</div>
                                            <div class="column heading">Azioni</div>
                                        </div>
                                        <div class="row animated">
                                            <div class="column">meta_id</div>
                                            <div class="column">bigint(20) unsigned</div>
                                            <div class="column">-</div>
                                        </div>
                                     </div>
                                
                                
                                </div>
                            </div>

                            <div class="table">
                                <div class="row">
                                    <div class="column add"><i class="fa fa-plus-circle"></i> <p>Aggiungi Tabella</p></div>
                                </div>
                            </div>

                            <a href="#" class="button backward black">Indietro</a>
                            <a href="#" class="button forward black">Avanti</a>
                        </div>
                        
                        <div class="steps tab 4 display-none">
                        
                            <a href="#" class="button backward black">Indietro</a>
                            <a href="#" class="button forward black">Avanti</a>
                        </div>

                        <div class="steps tab 5 display-none">
                        
                            <a href="#" class="button backward black">Indietro</a>
                            <a href="#" class="button forward black">Avanti</a>
                        </div>
                </div>
            </div>
        </div>

        <script>
            var phiroSetup = [];
            phiroSetup.instance = $('#phiro-setup-<?php echo $ID;?>');
            phiroSetup.content = phiroSetup.instance.find('.content');
            phiroSetup.steps = [];
            phiroSetup.steps.labels = phiroSetup.instance.find('.steps.labels p');
            phiroSetup.steps.tabs = phiroSetup.instance.find('.steps.tab');

            if(phiroSetup.steps.labels.length > 0) phiroSetup.steps.labels.eq(0).addClass("current");
			else alert("!PHIRO ERROR!  phiroSetup.steps.labels.length < 1");

            if(phiroSetup.steps.tabs.length < 1) console.log("!PHIRO ERROR!  phiroSetup.steps.tabs.length < 1");

            if(phiroSetup.steps.labels.length != phiroSetup.steps.tabs.length) console.log('!PHIRO ERROR! phiroSetup.steps.labels.length != phiroSetup.steps.tabs.length');

            jQuery(document).ready(function($) {
                phiroSetup.content.each(function() {
                    Instance_centerOnScreen($(this));
                });

                phiroSetup.steps.tabs.each(function(index) {

                    $(this).find(".backward").click(function() {
                        phiroSetup.steps.labels.eq(index).removeClass("current");
                        phiroSetup.steps.tabs.eq(index).stop().slideUp(400);
                        phiroSetup.steps.tabs.eq(index-1).stop().slideDown(400);
                        setTimeout(function() {
                            if(phiroSetup.steps.tabs.eq(index).attr('ID') == 'EDIT_DATABASE_TABLES') {
                                var tableDatabaseTables = phiroSetup.steps.tabs.eq(index).find('.table.database-tables');
                                tableDatabaseTables.html('<div class="row">'
                                    +'<div class="column heading">-</div>'
                                    +'<div class="column heading">Tabella</div>'
                                    +'<div class="column heading">Azioni</div>'
                                +'</div>');
                            };
                            phiroSetup.content.each(function() {
                                Instance_centerOnScreen($(this));
                            });
                        }, 450);
                    });

                    var forward = $(this).find(".forward");

                    if(index < phiroSetup.steps.tabs.length - 1) {

                        var ID = $(this).attr('id');
                        var inputs = $(this).find("input");

                        $(document).keyup(function(e) {
                            if(forward.is(":visible") && e.which == 13)
                                forward.trigger("click");
                        });
					
                        forward.click(function() {

                            var formOnError = false;
                            var formData = "";

                            inputs.each(function(index) {
                                var parent = $(this).parent();
                                var ID = ""; if($(this).attr("id")) ID = $(this).attr("id");
                                var value = $(this).val();
                                var type = $(this).attr("type");
                                var error = $(this).next();
                                var errorValue = "";

                                if($(this).attr("data-required") && $(this).attr("data-required") == "false") required = false;
                                else required = true;
                                
                                if(required || value.length > 0) {
                                    value = value.trim();
                                    $(this).val(value);

                                    switch(type) {
                                        default:
                                            if($(this).attr("data-minLength")) minLength = $(this).attr("data-minLength");
                                            else minLength = 0;
                                            if($(this).attr("data-length")) length = $(this).attr("data-length");
                                            else length = 0;
                                            if($(this).attr("data-maxLength")) maxLength = $(this).attr("data-maxLength");
                                            else maxLength = 9999;
                                            
                                            if(value.length <= 0) errorValue = "Vuoto!";
                                            else if(value.length < minLength) errorValue = "Almeno "+minLength+" caratteri";
                                            else if(value.length > maxLength) errorValue = "Massimo "+maxLength+" caratteri";
                                            else if(length != 0 && value.length != length) errorValue = "Esattamente "+length+" caratteri";
                                            
                                            break;
                                    }
                                } 
                                
                                if(errorValue) {
                                    formOnError = true;
                                    error.html(errorValue);
                                    error.slideDown();
                                    parent.addClass("on-error");
                                } else {
                                    error.slideUp(function() { $(this).html(""); });
                                    parent.removeClass("on-error");
                                    if(ID.length > 0) formData += "&"+ID+"="+encodeURIComponent(value);
                                }
                            
                            });

                            if(!formOnError) {
                                var errorValue = "";
                                var timeout = 1;

                                switch(ID) {
										case "CONNECTION_TO_DATABASE":
                                            timeout = 1000;
                                            swal({
												imageUrl: "<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/www/assets/images/loaders/spinner-violet.svg",
												title: "Verifica della Connessione<br/> al DB in corso...",
												imageSize: "112x112",
                                                html: true,
                                                text: null,
												showConfirmButton: false,
												allowEscapeKey: false,
                                                showConfirmButton: false,
                                                showCancelButton: false,
											});

                                            $.ajax({
												type: "GET",
												url: "<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/phiro/api/1.0/database/checkConnection",
												async: false,
												data: formData,
											}).done(function(json) {
												json = json.substring(json.indexOf("{"));
												json = $.parseJSON(json);

                                                if(json.STATUS != 'Success') {
                                                    switch(json.CODE) {
                                                        default:
                                                            errorValue = "Impossibile effettuare una Connessione al Database";
                                                            break;
                                                    }
                                                } else errorValue = "";
											});

											break;
                                }

                                if(errorValue.length > 0) {
                                    swal("ERRORE!", errorValue, "error"); return false;
                                }

                                setTimeout(function() {
                                    swal.close();
                                
                                    phiroSetup.steps.tabs.eq(index).stop().slideUp(400);
                                    phiroSetup.steps.tabs.eq(index+1).stop().slideDown(400);
                                    phiroSetup.steps.labels.eq(index+1).addClass("current");

                                    setTimeout(function() {
                                        if(phiroSetup.steps.tabs.eq(index+1).attr('ID') == 'EDIT_DATABASE_TABLES') {
                                            var tableDatabaseTables = phiroSetup.steps.tabs.eq(index+1).find('.table.database-tables');
                                            tableDatabaseTables.html(
                                                '<div class="row">'
                                                    +'<div class="column heading">-</div>'
                                                    +'<div class="column heading">Tabella</div>'
                                                    +'<div class="column heading">Azioni</div>'
                                                +'</div>'
                                            );

                                            swal({
                                                imageUrl: "<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/www/assets/images/loaders/spinner-violet.svg",
                                                title: "Importazione dello Schema Database esistente...",
                                                imageSize: "120x120",
                                                html: true,
                                                text: null,
                                                showConfirmButton: false,
                                                customClass: "loader",
                                                allowEscapeKey: false,
                                                showConfirmButton: false,
                                                showCancelButton: false,
                                            });

                                            var databaseTables = null;
                                            var timeout = 1;

                                            $.ajax({
												type: "GET",
												url: "<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/phiro/api/1.0/database/tables/get",
												async: false,
												data: formData,
											}).done(function(json) {
                                                json = json.substring(json.indexOf("{"));
												json = $.parseJSON(json);

                                                if(json.STATUS != 'Success') {
                                                    switch(json.CODE) {
                                                        default:
                                                            errorValue = "Impossibile effettuare una Connessione al Database";
                                                            break;
                                                    }
                                                    swal("ERRORE!", errorValue, "error"); return false;
                                                } else 
                                                    databaseTables = json.CONTENT;
                                                
											});

                                            if(databaseTables != null) {
                                                timeout = 1000;
                                                $.each(databaseTables, function(index, value) {
                                                    tableDatabaseTables.append(
                                                        '<div class="row animated " data-name="'+value+'">'
                                                            +'<div class="column">&nbsp;</div>'
                                                            +'<div class="column" style="min-width: 600px">'+value+'</div>'
                                                            +'<div class="column">'
                                                                +'<a data-action="getSchema" href="#no-link" class="button small black">Struttura</a> '
                                                                +'<a data-action="truncate" href="#no-link" class="button small red">Svuota</a> '
                                                                +'<a data-action="delete" href="#no-link" class="button small red">Elimina</a> '
                                                                +'<div class="status animated">Errore</div>'
                                                            +'</div>'
                                                        +'</div>');
                                                });

                                                tableDatabaseTables.find('a').each(function(index) {
                                                    $(this).click(function() {
                                                        var parent = $(this).parent().parent();
                                                        if(parent.hasClass('on-action')) return false;
                                                        var status = parent.find('.status');
                                                        if(status.hasClass('fadeIn')) status.addClass('fadeOut');
                                                        parent.addClass('on-action');
                                                        var name = parent.attr('data-name');
                                                        if(Instance_isNull(name)) return false;
                                                        var action = $(this).attr('data-action');
                                                        if(Instance_isNull(action)) return false;
                                                        var thisFormData = formData+"&DB_TABLE="+encodeURIComponent(name);

                                                        setTimeout(function() {
                                                            $.ajax({
                                                                type: "GET",
                                                                url: "<?php echo Constants\Paths\ABS_HTTP.Constants\KERNEL_DIR; ?>/phiro/api/1.0/database/table/"+action,
                                                                data: thisFormData,
                                                            }).done(function(json) {
                                                                json = json.substring(json.indexOf("{"));
                                                                json = $.parseJSON(json);

                                                                if(json.STATUS != 'Success') {
                                                                    switch(json.CODE) {
                                                                        default:
                                                                            errorValue = "Impossibile effettuare l'operazione. Phiro non è riuscito ad interfacciarsi al Database";
                                                                            break;
                                                                    }
                                                                    swal("ERRORE!", errorValue, "error"); return false;
                                                                    parent.addClass('on-error');
                                                                    status.html('Errore!').removeClass('fadeOut').addClass('fadeIn');
                                                                } else {
                                                                    switch(action) {
                                                                        default:
                                                                            status.html('OK!').removeClass('fadeOut').addClass('fadeIn');
                                                                            break;
                                                                        case 'getTableSchema':
                                                                            alert(json.CONTENT);
                                                                            $.each(json.CONTENT, function(index, value) {
                                                                                alert(value.name);
                                                                            });
                                                                            break;
                                                                        case 'deleteTable':
                                                                            parent.addClass('fadeOutUp');
                                                                            parent.find('.column').slideUp(function() {
                                                                                parent.remove();
                                                                            });
                                                                            break;
                                                                    }
                                                                    parent.removeClass('on-error').removeClass('on-action');
                                                                }
                                                            }).fail(function() {
                                                                parent.removeClass('on-action').addClass('on-error');
                                                                status.html('Errore!').removeClass('fadeOut').addClass('fadeIn');
                                                            });
                                                        }, 1000);
                                                    });
                                                });
                                            }

                                            setTimeout(function() {
                                                swal.close();
                                            }, timeout);
                                        }
                                        phiroSetup.content.each(function() {
                                            Instance_centerOnScreen($(this));
                                        });
                                    }, 450);

                                }, timeout);

                            }
                        });
                    
                    } else forward.hide();

                    //Element_CenterOnScreen(phiroSetup.content);


				});

            });

            jQuery(window).resize(function() {
                if(!Instance_isNull(phiroSetup.content)) 
                    phiroSetup.content.each(function() {
                        Instance_centerOnScreen($(this));
                    });
            });
        </script>


   <?php }

}


?>