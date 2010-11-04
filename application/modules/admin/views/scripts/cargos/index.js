
function GridCargos(gridtable,paginator,parametros){
    this.gridtable=gridtable;
    this.paginator = paginator;
    this.parametros =parametros;
    this.colNames=['id','Cargo','Descrição'];
    this.colModel=[
    {
        name:'cargo[id]',
        index:'id',
        jsonmap : 'id' ,
        width:15,
        editable:false,
        editoptions:{
            readonly:true,
            size:25
        }
    },
    {
        name:'cargo[nome]',
        index:'nome',
        editable:true,
        jsonmap : 'nome',
        editoptions:{
            size:60
        },
        formoptions:
        {
            label: "Cargo",
            elmprefix:"(*)"
        },
        editrules:{
            required:true
        }
    },
    {
        name:'cargo[descricao]',
        index:'descricao',
        editable:true,
        jsonmap : 'descricao',
        edittype:"textarea",
        editoptions:{
            rows:"4",
            cols:"60"
        },
        formoptions:
        {
            label: "Descrição",
            elmprefix:"(*)"
        },
        editrules:{
            required:true
        }
    }
    ];
    this.pager =     '#pg-cargos';
    this.caption =   "Cargos";
    this.afterInsertRow  = function(rowid, rowdata, rowelem)
    {
        $('#' + rowid).contextMenu('MenuJqGrid', contextCargos);
    };
    this.init = function(){
        
        $.extend(this, GridPadrao);
        this.url='<?php echo $this->url(array("action"=>"get")); ?>?format=json';
        var self = this;
        $("#tb-cargos").jqGrid(self);
        this.initBar();

    };
    this.initBar = function(){
        $(this.gridtable).jqGrid('navGrid',this.paginator,{
            edit:false,
            add:false,
            del:false,
            search:false,'cloneToTop':true 
        });
        $(this.gridtable).jqGrid('navButtonAdd',
            this.gridtable+'_toppager_left',
            {
                caption:"Novo",
                buttonicon:"ui-icon-document",
                onClickButton: function()
                {
                    cargos.formNew();
                }

            });
        $(this.gridtable).jqGrid('navButtonAdd',
            this.gridtable+'_toppager_left',
            {
                caption:"Editar",
                buttonicon:"ui-icon-pencil",
                onClickButton:function()
                {
                    cargos.formEdit();
                }
            });
        $(this.gridtable).jqGrid(
            'navButtonAdd',
            this.gridtable+'_toppager_left',
            {
                caption:"Apagar",
                buttonicon:"ui-icon-trash",
                width: 100,
                onClickButton: function(){
                    cargos.formDelete();
                }
            });
    };
    // Configurações do menu de contexto
    var contextCargos = {
        bindings: {
            'add': function(t) {
                cargos.formNew();
            },
            'delete': function(t) {
                cargos.formDelete(t.id);
            },
            'edit': function(t) {
                cargos.formEdit(t.id);
            }
        }
    };
    this.gridComplete	= function()
    {
        $('#gview_tb-cargos .ui-jqgrid-bdiv').contextMenu('MenuJqGrid-geral', contextCargos);
    }
}

function Cargos(){
    this.init = function(){};
    this.createGrid = function(){
        grid = new GridCargos('#tb-cargos','#pg-cargos');
        grid.init();
    };
    this.formNew =  function(){
        $("#tb-cargos").editGridRow("new",
        {
            url              :'<?php echo $this->url(array("action"=>"create")); ?>?format=json',
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
    };
    this.formEdit = function(id)
    {
        var gsr = id ? id : $("#tb-cargos").jqGrid('getGridParam','selrow');
        if(gsr)
        {
            edit_url = '<?php echo $this->url(array("action"=>"update"));?>/'+gsr+'?format=json'
            jQuery("#tb-cargos").jqGrid(
                'editGridRow',
                gsr,
                {
                    url               : edit_url,
                    mtype             : 'POST',
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

    };
    this.formDelete = function(id)
    {
        var gsr = id ? id : $("#tb-cargos").jqGrid('getGridParam','selrow');
        if(gsr)
        {
            edit_url = '<?php echo $this->url(array("action"=>"delete"));?>/id/'+gsr+'?format=json'
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
		
    };
}


$(document).ready(function(){
    cargos = new Cargos();
    cargos.init();
    cargos.createGrid();
});

