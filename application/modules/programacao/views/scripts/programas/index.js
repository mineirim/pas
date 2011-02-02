function Programas(){
    this.href = '<?php echo $this->href; ?>';
    this.init = function(){};
    this.loadForm = function(){
               $('#formulario_ajax').html('Aguarde...');

                $('#formulario_ajax').load(href+'?format=html',function(){
                    $(".make-tabs").tabs({
                        collapsible: true

                    });
                    enableTabs();
                }).dialog({
                    autoOpen: false,
                    title: this.title,
                    height: 450,
                    width: 600,
                    modal: true
                });
                $('#formulario_ajax').dialog('open');
                return false;
    };
}
var programas;
$(document).ready(function(){
    alert('chegou aki');
    programas = new Programas();
    programas.loadForm();
});