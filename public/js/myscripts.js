var controleGeral;
var g;
$(document).ready(function(){
    controleGeral = new ControleGeral();
    controleGeral.init();

});

/**
 *Classe responsável por iniciar todos os controles padronizados da aplicação
 *ex: quando clicar num botão com a classe tal, executar tal evento
 **/
function ControleGeral(){

    this.init =  function()
    {
        this.criaMenuTree();
        this.criaTabs();
        this.cliques();
        this.percentual_execucao();
    };
    
    this.eventos_classes = function(){
    	eventos_classes();
    }

    this.criaMenuTree = function()
    {

	tree = new MyTree();
	tree.create_json();

    };
    this.criaTabs = function()
    {
        $("#formtabs").tabs({collapsible: false});
        enableTabs();
        $(".datepick").datepicker({
            dateformat:"dd-mm-yy"
        });

        $('.tooltip').tooltip();
    }
    /**
     *Verifica se existem dependencias das tabs em relação à primeira
     */
    function enableTabs(){
        tabs=[];
        $("#formtabs form").each( function(){
            dep = $(this).children('input#dependents');
            if(dep.length>0){
                tabs = dep[0].value.split(',')
                id = this.elements['id'].value
                if(id==""){
                    for(i=0; i<tabs.length ;i++){
                        tabs[i]=parseInt(tabs[i])
                    }
                    $("#formtabs").tabs('option', 'disabled', tabs);
                }else{
                    $("#formtabs").tabs('option', 'disabled', []);
                }
            }
        });
        $(".make-tabs").each(function(){
            if(!$(this).hasClass('ui-tabs')){
                $(this).tabs({collapsible: false});
            }

            $(this).find("form").each( function(){
                dep = $(this).children('input#dependents');
                if(dep.length>0){
                    tabs = dep[0].value.split(',')
                    id = this.elements['id'].value
                    if(id==""){
                        for(i=0; i<tabs.length ;i++){
                            tabs[i]=parseInt(tabs[i])
                        }
                        $("#formtabs").tabs('option', 'disabled', tabs);
                    }else{
                        $("#formtabs").tabs('option', 'disabled', []);
                    }
                }
            });


        })
    }
    /**
     *habilita a função de autoload de código javascript para tags especificadas
     **/
    this.enableAutoLoad= function(){
        $('a.ajax-form-load').live('click',
            function(event){
                event.preventDefault();
                Carregador.carrega(this.href+'?format=js', 'text/javascript')
            }
        );
    }
    this.cliques = function(){
        $('button.my-jq-button').each(function(k,v){
            $(v).button({
                icons:{primary: $(v).attr('alt')}
            });
        });
        $('button.ajax-form-load').live('click',function(event){
            event.preventDefault();
            $('#formulario_ajax').html('Aguarde...');

            $('#formulario_ajax').load(this.value+'?format=html',function(){
                $("#formtabs").tabs({
                    collapsible: true

                });
                enableTabs();
                eventos_classes();

            }).dialog({
                autoOpen: false,
                title: this.title,
                height: 450,
                width: 720,
                modal: true
            });
            $('#formulario_ajax').dialog('open');
            return false;
        });
        $('.dialog-form-close').live('click',function(){$('#formulario_ajax').dialog('close');})
        $('a.ajax-form-load').live('click',
            function(event){
                event.preventDefault();
                $('#formulario_ajax').html('Aguarde...');

                $('#formulario_ajax').load(this.href+'?format=html',function(){
                    $("#formtabs").tabs({
                        collapsible: true
                    });
                    enableTabs();
                    eventos_classes();
                }).dialog({
                    autoOpen: false,
                    title: this.title,
                    height: 450,
                    width: 720,
                    modal: true
                });
                $('#formulario_ajax').dialog('open');
                return false;
            }
        );
        // responsável por enviar formulários através do clique do botão com a classe 'by-ajax'
        $("input.by-ajax").live('click',function(e){
        	frm = $(this).parents('form');
            url=$(this).parents('form').attr('action');
            // por padrão, o jquery não envia o valor para o botão clicado
            // este pedaço de código corrige este problema
            clicked = $(this).attr("name") + "=" + $(this).val();
            data = $(this).parents('form').serialize() + "&" + clicked;
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function(data, status,xhr){
                	if(data.newid){
                		$('#'+frm.attr('id')+' #id').val(data.newid);
                		$('.sync-parent-id').each(function(){ 
                			$(this).val(data.newid)
                			});
                		enableTabs();
                	}
                    Mensageiro.onSuccess(data);
                } ,
                complete:function(XMLHttpRequest, textStatus){
                    if(textStatus=='success'){
                        Mensageiro.onComplete(XMLHttpRequest)
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    Mensageiro.onError(XMLHttpRequest,textStatus,errorThrown);
                }

            });
            return false;
        });


        /**
         *efeito de highlight em tabela
         */
      $(".tb-corpo tr").live({
          mouseenter: function()
              {
        	  	$(this).addClass("ui-state-highlight");
              },
           mouseleave: function()
              {
        	   	$(this).removeClass("ui-state-highlight");
              }
          });

    };
    this.percentual_execucao = function(){
        if($('#progresso').val() != 'undefined'){
            url = baseUrl+'/execucao/index/from/'
            parametros = {progresso:$('#progresso').val(), parent_id: $('#parent_id').val()}
            $.getJSON(url,parametros,function(data){
                $.each(data, function(k,v){
                    $("#progbar-"+k).progressbar({
			value: v
                    });
                })
            })
        }
    };
    /**
     * habilita o comportamento padrão para classes padronizadas
     */
    function eventos_classes(){
        $(".datepick").datepicker(
        		{dateformat:"dd-mm-yy"}
        		);

        $(".div_slider").each(function(){
            id = this.id.substr(3);
            $(this).slider({
                value:$("#"+id).val(),
                min: 0,
                max: 100,
                step: 5,
                slide: function(event, ui) {
                        $("#"+id).val(ui.value);
                }
            })
        })


    }
}




GridPadrao = {
    mtype           : 'GET',
    datatype        : 'json',
    width           :  665,
    height          : 230,
    rownumbers      : false,
    rowNum          :-1,
    rowList         :[],
    pginput         : false,
    pgbuttons       : false,
    viewrecords     : true,
    toppager        : true,
    cloneToTop      : true,
    forceFit        : true,
    jsonReader: {repeatitems : false, root:"rows"}
};

TreeGridPadrao = {
    mtype           : 'GET',
    datatype        : 'json',
    width           :  665,
    height          : 230,
    treeGridModel 	: 'adjacency',
    treeGrid      	: true,
    ExpandColClick	: false,
    rowNum          :-1,
    rowList         :[],
    pginput         : false,
    pgbuttons       : false,
    viewrecords     : true,
    toppager        : true,
    cloneToTop      : true,
    forceFit        : true,
    jsonReader     : {
                  repeatitems : false,
                  id:"id",
                  root:"rows"
    },
    treeReader : {
                 level_field: "level",
                 parent_id_field: "parent",
                 leaf_field: "isLeaf",
                 expanded_field: "expanded"
    }

};

Mensageiro ={
    onComplete : function (response)
    {
        var json = eval('(' + response.responseText + ')');
        obj={
            mensagem:'',
            errors:''
        };
        if(json.notice){
            obj.mensagem ='<h3>'+json.notice+'</h3>';
        }
        if(json.errormessage){
        	obj.errors +=json.errormessage; 
        }
        if(json.errors) {
            success = false;
            
            for(i in json.errors) {
                message += json.errors[i] + '<br/>';
            }
            obj.errors += message
        }
        $('#flash-m').html(obj.mensagem+'<br>'+obj.errors).fadeIn(1000);
        $('#flash-m').fadeOut(5000)

        if(json.refreshPermissions){
            $.ajax({
                type: "POST",
                url: baseUrl+'/auth/refresh',
                success: function(data, status,xhr){
                } ,
                complete:function(XMLHttpRequest, textStatus){
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    Mensageiro.onError(XMLHttpRequest,textStatus,errorThrown);
                }

            });
        }
        /**
         *quando é feita alguma alteração no formulário, ele obrigatoriamente passa pelo onComplete
         *quando o retorno do json diz para dar refresh na pagina, ele adiciona uma funçao à caixa de diálogo
         */
        if(json.alert){
        	
        	 $( "<div title='Erro'></div>" )
             .html(json.alert)
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
        if(json.nextTab){
            $("#formulario_ajax > .make-tabs").tabs({ selected: json.nextTab });
        }
        if(json.refreshPage){
            $('#formulario_ajax').dialog({close: function(ev, ui){
                    location.reload();}
            });
        }
        if(!json.keepOpened==true){
            $('#formulario_ajax').dialog('close');
        }
    },
    onSuccess : function(data)
    {
        if (typeof(data) === "object"){
            if(data.status){
                $('#flash-m').html(data.status).fadeOut(3000);
            }
        }

    },
    onError : function(response,textStatus,errorThrown)
    {
    	var json = eval('(' + response.responseText + ')');
        obj={
            mensagem:'',
            errors:''
        };
        if(json.errormessage){
        	obj.mensagem +=json.errormessage; 
        }
        if(json.errors) {
            /**
             * TODO implementar recursividade dos erros
             *
            success = false;
            message += jQuery().serialize(json.errors)+ '<br/>';
            obj.errors += message
            */
        }
        $( "<div title='Erro'></div>" )
            .html(obj.mensagem+'<br>'+obj.errors)
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

        $('#flash-m').html(obj.mensagem+'<br>'+obj.errors).fadeIn(1000);
        $('#flash-m').fadeOut(5000)
    }
}


function MyTree(){
    this.init = function(){
        $("#menu-tree").jstree({
            //"core" : { "initially_open" : [ "root" ] },
            "html_data" : {
                "data" : $(".menu-tree").html()
            },
            "themes" : {
                "theme" : "classic",
                "dots" : true,
                "icons" : true
            },
            "plugins" : [ "themes", "html_data" , "ui", "cookies" ],
            cookie_options : {
                auto_save:true
            }

        });
        $("#menu-tree").delegate("a","click", function (e) {
            document.location.href = this.href;
        });

        $("#menu-tree").bind("select_node.jstree",
            function(e,data)
            {
            //acrescentar eventos do onclick
            }
            );
    };
    this.create_json = function(){
        $.getJSON(baseUrl+'/treemenu', function(data){
            $("#menu_tree").jstree({
                "correct_state" : true,
    		"json_data" : {"data" :data},
    		"themes" : {
                    "theme" : "custom",
                    "dots" : true,
                    "icons" : false
                },
            "plugins" : [ "themes", "json_data", "cookies" ]
            });
        });
    };
    this.create = function(){
    	$("#menu_tree").jstree({
    		"correct_state" : true,
    		"json_data" : {
    			"data" : [
    				{
    					"data" : "Administração",
    					"state" : "closed",
    					"attr" : {"id" : "li-admin"},
    					"children" : [
    					               {'data' :{'title':"Alterar Senha",
    					            	   		 "attr" : {"href" : "/public/usuarios/changepassword"}
    					               			}
    					               },
    					               {'data' :{'title':"Usuários", "attr" : {"href" : "/public/usuarios"}
    					               }},
    					               {'data' :{'title':"Grupos",   "attr" : {"href" : "/public/grupos"}}}
    					             ]
    				},
    				{
    					"attr" : {"id" : "plano-root"},
    					"state" : "closed",
    					"data" : {
    						"title" : "Plano",
    						"attr" : {"href" : "/public/plano/programas"}
    					}
    				},
    				{
    					"attr" : {"id" : "li-indicadores"},
    					"data" : {
    						"title" : "Indicadores",
    						"attr" : {"href" : "/public/indicadores"}
    					}
    				},
    				{
    					"attr" : {"id" : "li-relatorios"},
    					"data" : {
    						"title" : "Relatorios",
    						"attr" : {"href" : "/public/relatorios"}
    					}
    				}
    			],
    			"ajax" : {"url" : "/public/treemenu?format=json",
		    				"data" : function (n) {
										return {node : n.attr("id") ? n.attr("id") : 0, openeds : $.cookie('jstree_open')};
	    							}
    					 }
    		},
    		"themes" : {
                "theme" : "classic",
                "dots" : true,
                "icons" : true
            },
            "plugins" : [ "themes", "json_data", "cookies" ]

    	});
    };


}




/**
 * responsável por carregar automaticamente arquivos javascript específicos de cada pagina
 */
Carregador = {
    arquivos:[]
    ,head : $("head")
    ,carrega: function(url, type){
        if(this.arquivos[url])
            return;

        var jsExpr = new RegExp( "js$", "i" );
        var cssExpr = new RegExp( "css$", "i" );
        if( type == null )
        if( jsExpr.test( url ) )
            type = 'text/javascript';
        else if( cssExpr.test( url ) )
            type = 'text/css';

        var tag = null;
        switch( type ){
            case 'text/javascript' :
                tag = document.createElement( 'script' );
                tag.type = type;
                tag.src = url;
                break;
            case 'text/css' :
                tag = document.createElement( 'link' );
                tag.rel = 'stylesheet';
                tag.type = type;
                tag.href = 'stylesheets/'+url;
                break;
        }
        //head.append("<script src=\"" + url + "\" type=\"text/javascript\"></scr" + "ipt>");
        this.head.append(tag)
        this.arquivos[url]=true;
    }
}



String.prototype.capitalize = function(){
    return this.replace(/\S+/g, function(a){
        return a.charAt(0).toUpperCase() + a.slice(1).toLowerCase();
    });
};
