
$(document).ready(function(){
		
		
		//$('#tabela').corner("round 8px").parent().css('padding', '5px').corner("round 10px");
		
		$('.fg-button').hover(
				function(){ 
					$(this).addClass("ui-state-hover"); 
				},
				function(){ 
					$(this).removeClass("ui-state-hover"); 
				}
			);
		
		$('.bt-menu').hover(
				function(){ 
					$(this).addClass("ui-state-hover"); 
				},
				function(){ 
					$(this).removeClass("ui-state-hover"); 
				}
		);
		
		$(function() {
			
			$("#formtabs").tabs({
				collapsible: true				
			});
			enableTabs();
		});
		
		$("#formtabs input.byajax").click(function(e){
			e.preventDefault();
			isvalidform(this, e)
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
			

});

function showDescritivo(data,result,obj){
	if(data.descricao != undefined){
		tabela = obj.attr('id');
		tabela = tabela.substr(3);
		$("#tb"+tabela).append("<tr><td>"+data.descricao+"</td></tr>")
		obj[0].descricao.value="";
		
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


function isvalidform(obj, e)
{

    var options = {
        success:       showResponse,
        dataType:	'json',
        url:       '/monitorasus-zf/public/acoes/validar'    
    }; 
    // bind form using 'ajaxForm'
    formulario  = obj.parent('form');
    $(formulario).ajaxSubmit(options)
    
}
function showResponse(responseText, statusText,formulario)
{
    $('.form-errors').remove();
    if (responseText == true)
    {
    	options = {params : 'format=xml', success: updateId }
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