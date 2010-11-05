
function GridSetores(gridtable,paginator,parametros){
    this.gridtable		= gridtable;
    this.paginator 		= paginator;
    this.parametros	 	= parametros;
    this.colNames=['id','Setor','Sigla','Descrição', 'Setor superior'];
    this.colModel=[
				    {
				        name:'setor[id]',
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
				        name:'setor[nome]',
				        index:'nome',
				        editable:true,
				        jsonmap : 'nome',
				        editoptions:{
				            size:60
				        },
				        formoptions:
				        {
				            label: "Nome",
				            elmprefix:"(*)"
				        },
				        editrules:{
				            required:true
				        }
				    },
				    {
				        name:'setor[sigla]',
				        index:'sigla',
				        editable:true,
				        jsonmap : 'sigla',
				        editoptions:{
				            size:60
				        },
				        formoptions:
				        {
				            label: "Sigla",
				            elmprefix:"(*)"
				        },
				        editrules:{
				            required:true
				        }
				    },
				    {
				        name:'setor[descricao]',
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
				    },
				    {
				    	name:'setor[setor_id]',
				        index:'setor_id',
				        jsonmap : 'setor_id',
					    editable: true,
						edittype:"select",
						editoptions:{
							dataUrl:'<?php echo $this->url(array("action"=>"get")); ?>?format=html'
						},
						formoptions:{ elmprefix:"&nbsp;&nbsp;&nbsp;&nbsp;" }
				    }
				    ];
    this.caption =   "Setores";
    this.recreateForm =true;
    this.afterInsertRow  = function(rowid, rowdata, rowelem)
    {
        $('#' + rowid).contextMenu('MenuSetores', contextSetores);
    };
    this.init = function(){
    	this.pager =this.paginator
        $.extend(this, GridPadrao);
        this.url='<?php echo $this->url(array("action"=>"get2grid")); ?>?format=json';
        var self = this;
        $("#tb-setores").jqGrid(self);
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
                    setores.formNew();
                }

            });
        $(this.gridtable).jqGrid('navButtonAdd',
            this.gridtable+'_toppager_left',
            {
                caption:"Editar",
                buttonicon:"ui-icon-pencil",
                onClickButton:function()
                {
                    setores.formEdit();
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
                    setores.formDelete();
                }
            });
    };
    // Configurações do menu de contexto
    var contextSetores = {
        bindings: {
            'add': function(t) {
                setores.formNew();
            },
            'delete': function(t) {
                setores.formDelete(t.id);
            },
            'edit': function(t) {
                setores.formEdit(t.id);
            }
        }
    };
    this.gridComplete	= function()
    {
        $('#gview_tb-setores .ui-jqgrid-bdiv').contextMenu('MenuSetores-geral', contextSetores);
    }
}

function Setores(){
    this.init = function(){};
    this.createGrid = function(){
        grid = new GridSetores('#tb-setores','#pg-setores');
        grid.init();
    };
    this.formNew =  function(){
        $("#tb-setores").editGridRow("new",
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
        var gsr = id ? id : $("#tb-setores").jqGrid('getGridParam','selrow');
        if(gsr)
        {
            edit_url = '<?php echo $this->url(array("action"=>"update"));?>/'+gsr+'?format=json'
            jQuery("#tb-setores").jqGrid(
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
        var gsr = id ? id : $("#tb-setores").jqGrid('getGridParam','selrow');
        if(gsr)
        {
            edit_url = '<?php echo $this->url(array("action"=>"delete"));?>/id/'+gsr+'?format=json'
            jQuery("#tb-setores").jqGrid(
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
