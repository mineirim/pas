
UsuariosGrid = function(){
    this.sortname		= 'nome';
    this.sortorder		= "asc";
    this.viewrecords            = true;
    this.altRows		= true;
    this.viewsortcols           = [true,'horizontal',true];
    this.rowNum                 = 8;
    this.rowList 		= [20,30,50];
    this.emptyrecords           = "Nenhum usuário encontrado";
    this.editurl		= "<?php echo $this->url(array('action'=>'')) ?>/salvar";
    this.forceFit		= true;
    this.rownumWidth            = 30;
    this.caption		= 'Usuários';
    //this.toolbar		= [true,"top"];
    this.toppager		= true;
    this.cloneToTop		= true;
    this.colNames=['id', 'Nome','E-mail', 'Login','Ações '];
    this.colModel=[
    {
        name:'id',
        index:'id',
        width:'10',
        hidden: true,
        search:false
    },

    {
        name:'nome',
        index:'nome',
        width:'170'
    },
    {
        name:'email',
        index:'email',
        width:170
    },

    {
        name:'username',
        index:'username',
        width:100
    },

    {
        name:'act',
        index:'act',
        width:60,
        sortable:false,
        editable: false,
        search:false
    }
    ];

    this.init = function(gridtable,paginator,parametros){
        this.gridtable=gridtable;
        this.paginator = paginator;
        this.parametros =parametros;
        this.pager	 = this.paginator;

        $.extend(this, GridPadrao);

        this.url='<?php echo $this->baseUrl() ?>/admin/usuarios/localizar/'+parametros,
        this.rowNum         =8;
        this.rowList        =[8,20,30];
        this.pginput        = true;
        this.pgbuttons      = true;
        this.sortname       = 'nome',
        $(this.gridtable).jqGrid(this);

        p={del:false,add:false,edit:false,search:false,alertcap:' para editar :',alerttext:' clique na linha para selecionar','cloneToTop':true}
        $(this.gridtable).navGrid(this.paginator, p);


        if(this.gridtable=='#excluidos'){
            $(this.gridtable).jqGrid('setGridState','hidden').trigger("reloadGrid")
        }else{
            $(this.gridtable).jqGrid('filterToolbar',{
                stringResult: true,
                searchOnEnter : false
            });
        }


    };
    this.gridComplete	= function()
    {
        self = this;
        $("#"+this.id+" .fn_action > a").bind('click',function(){
            arr= this.id.split('_');
            usuarios.fn_acao(arr[1],arr[0] );
        });

    };

    this.initTopBar	= function(){
        var self = this;
        var nomegrid = this.gridtable.replace("#", "");
        var topPagerDiv = $(this.gridtable+"_toppager")[0];
        $("#edit_"+nomegrid+"_top", topPagerDiv).remove();
        $("#del_"+nomegrid+"_top", topPagerDiv).remove();
        $("#search_"+nomegrid+"_top", topPagerDiv).remove();
        $("#refresh_"+nomegrid+"_top", topPagerDiv).remove();
        $("#"+nomegrid+"_toppager_center", topPagerDiv).remove();
        $(".ui-paging-info", topPagerDiv).remove();


        $(this.gridtable).jqGrid('navButtonAdd',
            this.gridtable+'_toppager_left',
            {
                caption:"Novo Usuário",
                buttonicon:"ui-icon-document",
                onClickButton: function()
                {
                    usuarios.fn_acao(false,'add');
                }

            });
    };

    this.afterInsertRow  = function(rowid, rowdata, rowelem)
    {
        //$('#' + rowid).contextMenu('MenuJqGrid', contextInstrumento);

        if(this.id=='excluidos'){
            bar = '<div class="fg-toolbar fg-buttonset ui-widget-content ui-corner-all  ui-helper-clearfix fn_action">'
            bar =bar+'<a href="#" id="restore_'+rowid+'" rel="nofollow" style="margin:0" class="fg-button ui-state-default ui-corner-all" alt="Reativar usuário"><span class="ui-icon ui-icon-refresh"></span></a></div>'
        }else{
            bar = '<div class="fg-toolbar fg-buttonset ui-widget-content ui-corner-all  ui-helper-clearfix fn_action" style="white-space:nowrap;width:100%">'
            bar =bar+ '<a href="#" id="edit_'+rowid+'"   rel="nofollow" style="margin:0" class="fg-button ui-state-default ui-corner-all" alt="Editar"><span class="ui-icon ui-icon-pencil"></span></a>'
            bar =bar+ '<a href="#" id="reset_'+rowid+'"  rel="nofollow" style="margin:0" class="fg-button ui-state-default ui-corner-all" alt="Resetar senha"><span class="ui-icon ui-icon-arrowrefresh-1-e"></span></a>'
            bar =bar+ '<a href="#" id="delete_'+rowid+'" rel="nofollow" style="margin:0" class="fg-button ui-state-default ui-corner-all" alt="Inativar"><span class="ui-icon ui-icon-trash"></span></a></div>'
        }
        $(this).jqGrid('setRowData',rowid,{
            act:bar
        });

    };

};


function Usuarios(){
    var habilitados ='#habilitados';
    var excluidos ="#excluidos"
    this.init = function(){
        
    }
    this.createGrid = function(){

	gridHabilitados = new UsuariosGrid();

	gridHabilitados.init(habilitados,"#pager_habilitados","situacao_id/1")
	gridHabilitados.initTopBar();

	gridExcluidos = new UsuariosGrid();
	gridExcluidos.init(excluidos,"#pager_excluidos","situacao_id/2")
    }
    /**
     * cria um formulário para edição, criação ou deletar um usuário
     */
    this.fn_acao = function (id,acao)
    {
        $('#formulario_ajax').html('Aguarde...');

        $('#formulario_ajax').load("<?php echo $this->url(array('action'=>''));?>"+acao+"/id/"+id,
                function()
                {
                     $(".make-tabs").tabs({
                        collapsible: false
                        });
                    $(".datepick").datepicker(
                    {dateformat:"dd-mm-yy"}
                    );
                }
        ).dialog({
            autoOpen: false,
            title: "Controle de Usuários",
            height: 400,
            width: 665,
            modal: true,
            close: function(ev, ui)
                    {
                        // recarrega as grids após atualizações
                        $(habilitados).jqGrid().trigger("reloadGrid")
                        $(excluidos).jqGrid().trigger("reloadGrid")
                    }
        });
        $('#formulario_ajax').dialog('open')
    }
}