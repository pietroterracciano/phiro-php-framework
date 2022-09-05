/**
* @author Pietro Terracciano
* @since 0.170702
*
* Aggiunge ad un oggetto String jQuery, il metodo toBoolean() che restituisce
* il valore di String nel valore Boolean corrispondente
**/

(function($) {
    String.prototype.toBoolean = function() {
        switch(this.toLowerCase().trim()) {
            case "true": case "1": return true;
            case null: case "": case "false": case "0": return false;
            default: return Boolean(this);
        }
    }
})(jQuery);