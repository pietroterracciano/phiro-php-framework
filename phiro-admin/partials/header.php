<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

global $PHIRO_CONFIGURED;

?>

<div id="header">
    <div class='logo'><img src="<?php echo $PHIRO_REL_ADMIN_URL; ?>/assets/images/logo.png" /></div>

    <div class='separator'></div>

    <?php

        global $PAGE_TEMPLATE;

        switch($PAGE_TEMPLATE) {
            case DOCUMENTATION__TEMPLATE: ?>
                <script src='<?php echo $PHIRO_REL_ADMIN_URL; ?>/assets/js/widgets/jquery-tree-pseudo-widget.js'></script>

                <h6 class="heading"><?php echo DOCUMENTATION.'<br/>in '.strtolower(REAL_TIME); ?></h6>
                <p></p>
                <div class="jq-tree">
                    <a href="#">Introduzione</a>
                    <div data-isCollapsed="false" class="jq-branch-tree ">
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Scopri Phiro</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Lo sviluppatore di Phiro</a>
                    </div>
                </div>
                <p></p>
                <div class="jq-tree">
                    <a class="with-icon" href="#"><i class="fa fa-cubes"></i> Tipi di Dato Astratti / TDA</a>
                    <div class="jq-branch-tree ">
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Queue / Coda</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Stack / Pila</a>
                    </div>
                </div>
                <p></p>
                <div class="jq-tree">
                    <a class="with-icon" href="#"><i class="fa fa-hdd-o"></i> Cache</a>
                    <div class="jq-branch-tree">
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Caching su Database</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Caching su File</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Caching su File in RAM Disk</a>
                    </div>
                </div>
                <p></p>
                <div class="jq-tree">
                    <a class="with-icon" href="#"><i class="fa fa-cog"></i> Core</a>
                    <div class="jq-branch-tree ">
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Eccezioni complete </a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Eccezioni veloci </a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Informazioni sul Server </a>
                    </div>
                </div>
                <p></p>
                <div class="jq-tree">
                    <a class="with-icon" href="#"><i class="fa fa-database"></i> I/O</a>
                    <div class="jq-branch-tree">
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Database</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Local Stream</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Remote Stream</a>
                    </div>
                </div>
                <p></p>
                <div class="jq-tree">
                    <a class="with-icon" href="#"><i class="fa fa-shield"></i> Sicurezza</a>
                    <div class="jq-branch-tree ">
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Criptatori ad una via </a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Criptatori a due vie </a>
                    </div>
                </div>
                <p></p>
                <div class="jq-tree">
                    <a class="with-icon" href="#"><i class="fa fa-code"></i> Funzionalità</a>
                    <div class="jq-branch-tree ">
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Azioni (WP Like)</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Filtri (WP Like)</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Glob ricorsivo</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Gestione di Array</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Gestione di JSON</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Gestione di Numeri</a>
                        <a class="with-icon" href="#"><i class="fa fa-circle-o"></i> Gestione di Stringhe</a>
                    </div>
                </div>

                <div class="break"></div>
                <?php
                break;
        }

    /*if( !is_exception_page() ) { 
        if(!$PHIRO_CONFIGURED) { ?>
        
            <a href="#"><i class="fa fa-icon fa-envira"></i> <div class='clear'></div> Verifica dell'ambiente WEB</a>

                <div class='separator'></div>

        <a href="#"><i class="fa fa-icon fa-cog"></i> <div class='clear'></div> Installazione guidata</a>
        <a href="#">1. Connessione al Database</a>
        <a href="#">2. Schema di Database</a>
        <a href="#">3. Regole di Rewrite</a>

        <div class='separator'></div>

        <a href="#"><i class="fa fa-icon fa-check"></i> <div class='clear'></div> Configurazione completata</a>
        
            <?php } else { ?>

            <?php }
    } else { ?>

        <p href="#"><i class="fa fa-icon fa-bug"></i><br /> <?php echo EXCEPTION; ?></p>

    <?php } */?>

</div>