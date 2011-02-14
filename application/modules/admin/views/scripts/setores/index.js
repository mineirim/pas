
function GridSetores(gridtable,paginator,parametros){
    this.loadonce		= true;
    this.gridtable		= gridtable;
    this.paginator 		= paginator;
    this.parametros	 	= parametros;
    this.ExpandColumn  = "setor[nome]";
    this.colNames=['id','Setor','Sigla','Chefia','Selecione a chefia', 'Subordinado a:'];
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
				        name:'setor[chefia]',
				        index:'chefia',
				        editable:false,
				        jsonmap : 'chefia'
				    },				    {
				        name	:'setor[chefia_id]',
				        index	:'chefia_id',
				        editable:true,
                                        hidden	: true,
				        jsonmap : 'chefia_id',
                                        edittype:"select",
                                        editoptions:{
                                                dataUrl:'<?php echo $this->url(array("module"=>"default", "controller"=>"usuarios", "action"=>"get")); ?>?format=html',
                                                dataInit :  function(element)
                                                {
                                                        var gsr = $("#tb-setores").jqGrid('getGridParam','selrow');
                                                        setTimeout(function() {$(element).val(parseInt(gsr,10));},1000);
                                                }
                                        },
                                        formoptions:{ elmprefix:"&nbsp;&nbsp;&nbsp;&nbsp;" },
                                        editrules	: {edithidden:true}
				    },
				    {
				    	name	:'setor[setor_id]',
				        index	:'setor_id',
				        jsonmap : 'setor_id',
				        hidden	: true,
					editable: true,
                                        edittype:"select",
                                        editoptions:{
                                                dataUrl:'<?php echo $this->url(array("action"=>"get")); ?>?format=html',
                                                dataInit :  function(element)
                                                {
                                                        var gsr = $("#tb-setores").jqGrid('getGridParam','selrow');
                                                        setTimeout(function() {$(element).val(parseInt(gsr,10));},10000);
                                                }
                                        },
                                        formoptions:{ elmprefix:"&nbsp;&nbsp;&nbsp;&nbsp;" },
                                        editrules	: {edithidden:true}
						
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
        $.extend(this, TreeGridPadrao);
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
    /**
     * Adiciona novo elemento 
     */
    this.formNew =  function(from){
        $("#tb-setores").editGridRow("new",
        {
            url              :'<?php echo $this->url(array("action"=>"create")); ?>?format=json',
            mtype            :'POST',
            modal             : true,
            closeAfterAdd    : true,
            reloadAfterSubmit: true,
            closeOnEscape    : true,
            recreateForm	 : true,
            height           : 450,
            width            : 720,
            afterComplete    :  function(response, postdata, formid)
			{
				Mensageiro.onComplete(response, postdata, formid);
            	$("#tb-setores").trigger("reloadGrid");
			},
			errorTextFormat	  : function(response,b)
			{
				Mensageiro.onError(response);
				var json = eval('(' + response.responseText + ')');
				return json.errormessage
			}
        }
        );
    };
    /**
     * Edita a linha selecionada
     */
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
                    height            : 450,
                    width             : 720,
                    afterComplete     : Mensageiro.onComplete,
                    errorTextFormat	  : function(response,b)
                    {
                    	Mensageiro.onError(response);
                    	var json = eval('(' + response.responseText + ')');
                    	return json.errormessage
                    }
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
    /**
     * APAGA A LINHA SELECIONADA
     * @TODO implementar a lista de setores a serem deletado recursivamente
     */
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
                    mtype             : 'POST',
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
