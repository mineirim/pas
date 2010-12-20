
function GridParcerias(gridtable,paginator,parametros){
    this.gridtable		= gridtable;
    this.paginator 		= paginator;
    this.parametros	 	= parametros;
    this.shrinkToFit	= false;
    this.sortname		= 'id';
    this.sortorder		= "asc";
    this.colNames=['id','Parceiro','Sigla', 'Observações', 'Tipo de Parceria'];
    this.colModel=[
				    {
				        name:'parceria[id]',
				        index:'id',
				        jsonmap : 'id' ,
				        width:1
				    },
				    {
				        name:'parceria[nome]',
				        index:'parceiro_id',
				        jsonmap : 'nome',
				        width:200
				    },
				    {
				        name:'parceria[sigla]',
				        index:'sigla',
				        jsonmap : 'sigla',
				        width:60
				    },
				    {
				        name:'parceria[observacoes]',
				        index:'observacoes',
				        jsonmap : 'observacoes',
				        width:220
				    },
				    {
				        name:'parceria[tipo_parceria]',
				        index:'tipo_parceria',
				        jsonmap : 'tipo_parceria',
				        width:150
				    }
				    ];
    this.caption =   "Parcerias";
    this.afterInsertRow  = function(rowid, rowdata, rowelem)
    {
    	
        $('#' + rowid).contextMenu('MenuParcerias', contextParcerias);
    };
    this.init = function(){
    	this.pager =this.paginator
        $.extend(this, GridPadrao);
        this.url='<?php echo $this->url(array("action"=>"get2grid")); ?>?format=json';
        var self = this;
        $("#tb-parcerias").jqGrid(self);
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
                	
                	parcerias.formNew();
                }

            });
        $(this.gridtable).jqGrid('navButtonAdd',
            this.gridtable+'_toppager_left',
            {
                caption:"Editar",
                buttonicon:"ui-icon-pencil",
                onClickButton:function()
                {
                    parcerias.formEdit();
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
                	parcerias.formDelete();
                }
            });
    };
    // Configurações do menu de contexto
    var contextParcerias = {
        bindings: {
            'add': function(t) {
            	parcerias.formNew();
            },
            'delete': function(t) {
            	parcerias.formDelete(t.id);
            },
            'edit': function(t) {
            	parcerias.formEdit(t.id);
            }
        }
    };
    this.gridComplete	= function()
    {
        $('#gview_tb-parcerias .ui-jqgrid-bdiv').contextMenu('MenuParcerias_geral', contextParcerias);
    };
}

function Parcerias(){
    this.init = function(){};
    this.createGrid = function(){
        grid = new GridParcerias('#tb-parcerias','#pg-parcerias');
        grid.init();
    };
    
    this.fn_acao = function (myurl)
    {
        var divparceria = $('<div id="frmparceria_ajax"></div>').html('Aguarde...').appendTo('body');

        divparceria.load(myurl,
                function()
                {
                     $(".formtabs").tabs({
                        collapsible: true
                        });
   
            		var cache = {},
            		lastXhr;
            		$("#parceiro_text").autocomplete({
            			source: function( request, response ) {
            				var term = request.term;
            				if ( term in cache ) {
            					response( cache[ term ] );
            					return;
            				}

            				lastXhr = $.getJSON( '<?php echo $this->url(array("action"=>"autocomplete", "controller"=>"parceiros","module"=>"programacao"));?>?format=json', request, function( data, status, xhr ) {
            					cache[ term ] = data;
            					if ( xhr === lastXhr ) {
            						response( data );
            					}
            				});
            			},
            			minLength: 2,
            			select: function(event, ui) 
            					{
            						if(ui.item.id=='new'){
            							$('#tab-parceria').tabs('select', '#tab-new'); 
            						    return false;
            						}else{
            							$("#formParceria #parceiro_id").val(ui.item.id);
            						}
            					}
            		});             		
                }
        ).dialog({
            autoOpen: false,
            title: "Parcerias",
            height: 420,
            width: 570,
            modal: true,
            close: function(ev, ui)
                    {
                        // recarrega as grids após atualizações
                        $('tb-parcerias').jqGrid().trigger("reloadGrid");
                        divparceria.remove();
                    }
        });
        divparceria.dialog('open')
    }    
    
    this.formNew =  function(){
    	this.fn_acao('<?php echo $this->url(array("action"=>"create")); ?>?format=html');
    };
    this.formEdit = function(id)
    {
        var gsr = id ? id : $("#tb-parcerias").jqGrid('getGridParam','selrow');
        if(gsr)
        {
            edit_url = '<?php echo $this->url(array("controller"=>"parcerias", "action"=>"edit", "module"=>"programacao"),null,true);?>/id/'+gsr+'?format=html'
            this.fn_acao(edit_url);
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
        var gsr = id ? id : $("#tb-parcerias").jqGrid('getGridParam','selrow');
        if(gsr)
        {
            edit_url = '<?php echo $this->url(array("action"=>"delete"));?>/id/'+gsr+'?format=html'
            this.fn_acao(edit_url);
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




