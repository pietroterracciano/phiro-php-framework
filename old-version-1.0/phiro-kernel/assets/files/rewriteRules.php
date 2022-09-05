<?php if (!defined('Phiro\Constants\KERNEL_DIR')) exit; ?>

R301       : Is a redirect
DCSORE     : Disable case sensitive match on Regular Expression
DPEOO      : Disable PHP Error on Output

#START_REWRITE_RULES#
^[/]{0,1}phiro/setup[/]{0,1}$                                           phiro-kernel/www/setup.php                                   DCSORE
^phiro/api/1.0/database/checkConnection[/]{0,1}$                        phiro-core/www/api/1.0/database/checkConnection.php           DPEOO 
^phiro/api/1.0/database/tables/get[/]{0,1}$                             phiro-core/www/api/1.0/Database/Tables/get.php                DPEOO
^phiro/api/1.0/database/table/delete[/]{0,1}$                           phiro-core/www/api/1.0/Database/Table/delete.php                     
^phiro/api/1.0/database/table/getSchema[/]{0,1}$                        phiro-core/www/api/1.0/Database/Table/getSchema.php                        
^phiro/api/1.0/database/table/truncate[/]{0,1}$                         phiro-core/www/api/1.0/Database/Table/truncate.php                        
#END_REWRITE_RULES#