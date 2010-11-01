
function GridCargos(){
    this.colNames=['id','Cargo','Descrição'];
    this.colModel=[
            {name:'id',index:'id', jsonmap : 'id' ,
              width:15,editable:false,editoptions:{readonly:true,size:25}},
            {name:'nome',index:'nome', editable:true, jsonmap : 'nome',
              editoptions:{size:60},
              formoptions:
                {
                  label: "Cargo",
                  elmprefix:"(*)"
                },
                editrules:{required:true}
            },
            {name:'descricao',index:'descricao', editable:true, xmlmap : 'descricao',
              edittype:"textarea", 
              editoptions:{rows:"4",cols:"60"},
              formoptions:
                {
                  label: "Descrição",
                  elmprefix:"(*)"
                },
                editrules:{required:true}
            }
    ];
    this.pager =     '#pg-cargos';
    this.caption =   "Cargos";
    this.afterInsertRow  = function(rowid, rowdata, rowelem)
    {
      $('#' + rowid).contextMenu('MenuJqGrid', contextCargo);
    };
    this.init = function(){
      
      $.extend(this, GridPadrao)

 
      this.url='<?php echo $this->url(); ?>?format=json';
      var self = this;
        $("#tb-cargos").jqGrid(self);
        $("#tb-cargos").jqGrid('navGrid','#pg-instrumentos',{edit:false,add:false,del:false,search:false});
        $("#tb-cargos").jqGrid('navButtonAdd',
                '#pg-cargos',
                {caption:"Novo Instrumento", buttonicon:"ui-icon-document",
                onClickButton: function()
                {
                  $("#tb-cargos").editGridRow("new",
                     {
                       url              :'<?php echo $this->url(); ?>?format=json',
                       mtype            :'POST',
                       modal             : true,
                       closeAfterAdd    :true,
                       reloadAfterSubmit:true,
                       closeOnEscape    :true,
                       height           :250,
                       width            :530,
                       afterComplete    : Mensageiro.onComplete
                     }
                    );
                }

        });
        $("#tb-cargos").jqGrid('navButtonAdd',
            '#pg-cargos',
            {
              caption:"Editar",
              buttonicon:"ui-icon-pencil",
              onClickButton:function()
              {
                    var gsr = $("#tb-cargos").jqGrid('getGridParam','selrow');
                    if(gsr)
                    {
                      edit_url = '<?php echo $this->url();?>/'+gsr+'?format=json'
                      jQuery("#tb-cargos").jqGrid(
                              'editGridRow',
                              gsr,
                              {
                                url               : edit_url,
                                mtype             : 'PUT',
                                modal             : true,
                                closeAfterEdit    : true,
                                reloadAfterSubmit : true,
                                closeOnEscape     : true,
                                height            : 250,
                                width             : 530,
                                afterComplete     : Mensageiro.onComplete
                              }
                     );
                    } else {
                    $( "<div title='Alerta'></div>" )
                        .html('<h3>Selecione um registro</h3>')
                        .dialog(
                        {
                          modal: true,
                          buttons:
                          {
                            Ok: function()
                            {
                                $( this ).dialog( "destroy" );
                                $( this ).remove();
                            }
                          }
                        });

                    }
            }
        });
        $("#tb-cargos").jqGrid(
          'navButtonAdd',
          '#pg-cargos',
          {
            caption:"Apagar",
            buttonicon:"ui-icon-trash",
            width: 100,
            onClickButton:function()
            {
              var gsr = jQuery("#tb-cargos").jqGrid('getGridParam','selrow');
              if(gsr)
              {
                edit_url = '<?php echo $this->url();?>/'+gsr+'.json'
                jQuery("#tb-cargos").jqGrid(
                      'delGridRow',
                      gsr,
                      {
                        url               : edit_url,
                        mtype             : 'DELETE',
                        modal             : 'true',
                        topinfo           : 'Apagar',
                        closeAfterEdit    : true,
                        reloadAfterSubmit : true,
                        closeOnEscape     : true,
                        afterComplete     : Mensageiro.onComplete
                      }
                );
              } else {
                $( "<div id='msg-dialog' title='Alerta'>Selecione um registro</div>" ).dialog(
                {
                    modal: true,
                    buttons: {
                            Ok: function() {
                                    $(this).dialog( "destroy" );
                                    $(this).remove();
                            }
                    }
                });

              }
            }
        });
    }

    // Configurações do menu de contexto
    var contextCargos = {
            bindings: {
              'add': function(t) {
                  $("#tb-cargos").editGridRow("new",
                   {
                     url              :'<%= instrumentos_path %>.json',
                     mtype            :'POST',
                     modal             : true,
                     closeAfterAdd    :true,
                     reloadAfterSubmit:true,
                     closeOnEscape    :true,
                     height           :250,
                     width            :530,
                     editData         :{
                        'instrumento[instrumento_id]'       : t.id
                     },
                     afterComplete    : Mensageiro.onComplete
                   }
                  );
              },
              'del': function(t) {
                  alert('Accion [Cortar] del elemento ' + t.id);
              },
              'edit': function(t) {
                  alert('Accion [Copiar] del elemento ' + t.id);
              }
            }
        };

}

$(document).ready(function(){
	gridcargos = new GridCargos();
	gridcargos.init();
})

