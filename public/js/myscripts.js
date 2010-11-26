
$(document).ready(function(){

	$('#trimestre').live('change',function(){
		parametros = $(this).parents('form').serialize();
		$.ajax({
			url: baseUrl+'/metas/procurartrimestre',
			data:parametros,
			type: "POST",
            success:function(dados){
			if (typeof(dados) === "object"){
        		  $("#id").val(dados.id);
        		  $("#meta_id").val(dados.meta_id);
        		  $("#percentual").val(dados.percentual);
        		  $("#avaliacao_descritiva").val(dados.avaliacao_descritiva);
        		  $("#slider").slider("value",dados.percentual);
        		  
         	   }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
         	   
         	   alert('Não encontrado')
         	   
         	   }
			});
		});		
	
	
	tree = new MyTree();
	tree.create_json();

		$(function() {
			
			$("#formtabs").tabs({
				collapsible: true
				
			});
			enableTabs();
		});
		$('a.by-ajax').live('click',function(event){
			event.preventDefault();
			$('#formulario_ajax').html('Aguarde...');

			$('#formulario_ajax').load(this.href+'/format/html',function(){
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
		});
		
		$("input.by-ajax").live('click',function(e){
			
			url=$(this).parents('form').attr('action');
			data = $(this).parents('form').serialize();
            $.ajax({  
                type: "POST",  
                url: url,  
                data: data,  
               success: function(data, status,xhr){
            		if (typeof(data) === "object"){
            			if(data.status){
            				/**
            				 * TODO implementar timer para sumir com a flash message
            				 */
            				$('#flash-m').html(data.status).fadeOut(3000);
            			}
            		}
               } ,
               complete:function(XMLHttpRequest, textStatus){
            	   if(textStatus=='success'){
           				$('#formulario_ajax').dialog('close');
            	   }
               },
               error: function(XMLHttpRequest, textStatus, errorThrown){
            	   
            	   alert('erro')
            	   
            	   }

           });  
			return false;
		})
		
		$(".progressbar").progressbar({
			value: 50
		});
		
		//$(".progressbar").append('<span style="position:relative;top:-1.2em">50</span>')
		
		$(
			function()
			{
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
			}
		);
			
		/*
		 * edição de objetos via ajax
		*/
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
					  $this.parents('tr.lst').remove()
		          
			        });

			
		});		
		$(".datepick").datepicker({dateformat:"dd-mm-yy"});
		
		
		
		$('.tooltip').tooltip();
		
		
		$("#categoria.alterar-categoria").live('change',function(e){
			url = $("#url_categoria").val()+'/categoria_id/'+$(this).val();
			$.getJSON(url,
			        function(data){
					  alert ("Indicador Atualizado:  "+data.categoria)
		          
			        });
		});

});

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


function showResponse(responseText, statusText,formulario)
{
    $('.form-errors').remove();
    if (responseText == true)
    {
    	options = {params : 'format=xml', success: updateId}
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