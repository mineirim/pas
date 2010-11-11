var controleGeral;
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

    this.criaMenuTree = function()
    {

	tree = new MyTree();
	tree.create_json();

    };
    this.criaTabs = function()
    {
        $("#formtabs").tabs({collapsible: true});
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
    }

    this.cliques = function(){
        $('button.my-jq-button').each(function(k,v){
            self = this;
            $(v).button({
                icons:{primary: $(v).attr('alt')}
            });
            $(v).css({'font-size': '0.85em'});
        })
        $('button.my-jq-button').live('click',function(){
            alert($(this).val());
            return false;
        })

        $('a.by-ajax').live('click',
            function(event){
                event.preventDefault();
                $('#formulario_ajax').html('Aguarde...');

                $('#formulario_ajax').load(this.href+'?format=html',function(){
                    $("#formtabs").tabs({
                        collapsible: true

                    });
                    enableTabs();
                }).dialog({
                    autoOpen: false,
                    title: this.title,
                    height: 380,
                    width: 580,
                    modal: true
                });
                $('#formulario_ajax').dialog('open');
                return false;
            }
        );
        // responsável por enviar formulários com através do clique do botão com a classe 'by-ajax'
        $("input.by-ajax").live('click',function(e){
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
                    Mensageiro.onSuccess(data);
                } ,
                complete:function(XMLHttpRequest, textStatus){
                    if(textStatus=='success'){
                        $('#formulario_ajax').dialog('close');
                        Mensageiro.onComplete(XMLHttpRequest)
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown){
                    Mensageiro.onError(XMLHttpRequest,textStatus,errorThrown);
                }

            });
            return false;
        });

        $(".submit_descritivo").click(function(e)
            {
                e.preventDefault()
                var options = {
                    success:       showDescritivo,
                    dataType:	'json'
                };
                // bind form using 'ajaxForm'
                formulario  = $(this).parents('form');
                $(formulario).ajaxSubmit(options)
        });
        $(".editdescription").live('click',function(e)
            {
                e.preventDefault();
                e.stopPropagation();

                $this = $(this)
                $tpobjeto = this.id.split('-')[1]

                if($tpobjeto.substr($tpobjeto.length-1,1)!='s')
                {
                    $tpobjeto = $tpobjeto + 's'
                }
                $.getJSON(this.href,
                    function(data){
                        $this.parents('tr.lst').remove()
                        $('#frm'+$tpobjeto).find('#id').val(data.id)
                        $('#frm'+$tpobjeto).find('#descricao').val(data.descricao)
                        if(data.tipo_indicador_id != undefined )
                            $("#tipo_indicador_id-"+data.tipo_indicador_id).attr('checked','checked')
                    });
        });

        $(".deletedescription").live('click',function(e)
        {
            e.preventDefault();
            $this = $(this)
            $tpobjeto = this.id.split('-')[1]
            if($tpobjeto.substr($tpobjeto.length-1,1)!='s')
            {
                $tpobjeto = $tpobjeto + 's'
            }
            $.getJSON(this.href,
                function(data){
                    $this.parents('tr.lst').remove();
                });
        });
        $("#categoria.alterar-categoria").live('change',function(e){
            url = $("#url_categoria").val()+'/categoria_id/'+$(this).val();
            $.getJSON(url,
                function(data){
                    alert ("Indicador Atualizado:  "+data.categoria)

                });
        });
    }
    this.percentual_execucao = function(){
        if($('#progresso').val() != 'undefined'){
            url = baseUrl+'/execucao/from/'+$('#progresso').val();
            $.getJSON(url,function(data){
                $("data").each(function(k,v){
                    $('.execucao').progressbar({
			value: v
                    });
                })
            })
        }
    }
}

function showDescritivo(data,result,obj){
    if(data.toolbar != undefined){
        tabela = obj.attr('id');
        tabela = tabela.substr(3);
        $("#tb"+tabela).append("<tr class='lst'><td>"+data.toolbar+"</td><td>"+data.obj.descricao+"</td></tr>")
        obj[0].descricao.value="";
        obj[0].id.value="";
    }else{
        /**
		 * enquanto ajusta todos os scriptis de add
		 */
        if (data.descricao != undefined){
            tabela = obj.attr('id');
            tabela = tabela.substr(3);
            $("#tb"+tabela).append("<tr class='lst'><td></td><td>"+data.descricao+"</td></tr>")
            obj[0].descricao.value="";
            obj[0].id.value="";
        }
    }
}



function showResponse(responseText, statusText,formulario)
{
    $('.form-errors').remove();
    if (responseText == true)
    {
        options = {
            params : 'format=xml',
            success: updateId
        }
        //formulario.ajaxSubmit(options)
        formulario.submit();
    }
    else 
    {
        for (campo in responseText) {
            $('#'+campo).after('<ul id="'+campo+'_errors" class="form-errors"></ul>');
            for (mensagem in responseText[campo]) {
                $('#'+campo+'_errors').append('<li>'+responseText[campo][mensagem]+'</li>');
            }
        }
    }
}

function updateId(responseXML,statusText,formulario){
	
    id = $('id', responseXML).text();
    formulario[0].id.value=id
    enableTabs();
    tabs =$('#formtabs').tabs();
    selected = tabs.tabs('option', 'selected'); 
    $('#formtabs').tabs('select', selected+1);
    
}




GridPadrao = {
    mtype           : 'GET',
    datatype        : 'json',
    width           :  520,
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
	    width           :  520,
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
                    "theme" : "classic",
                    "dots" : true,
                    "icons" : true
                },
            "plugins" : [ "themes", "json_data", "cookies" ]
            });
        });
    }
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
    }


}