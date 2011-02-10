<?php
class Zend_View_Helper_Atividades extends Zend_View_Helper_Abstract
{
	public $view;
	
	
	function Atividades($controller = 'atividades') 
	{
		$this->_controller = $controller;
		$mysession = new Zend_Session_Namespace ( 'mysession' );
		$this->acl = $mysession->acl;
		$auth = Zend_Auth::getInstance ();
		if ($auth->hasIdentity ()) {
			$this->role = $auth->getIdentity ()->username;
		} else {
			$this->role = 'guest';
		}
		$resource = $controller;
		
		if (! $this->acl->has ( $resource ))
			$resource = null;
		
		$this->res = $resource;
		
		if ($this->role == 'guest' && ! $this->acl->hasRole ( 'guest' ))
			$this->acl->addRole ( 'guest' );
			

		if ($this->acl->isAllowed ( $this->role, $resource, 'editar' )|| ! $resource){
			$html = "<form id='". $this->view->form->getId()."'

              enctype='".$this->view->form->getEnctype()."'
              action='".$this->view->url(array('action' => 'update', 
				'module' => 'programacao',
				'controller' => 'atividades'))."?format=json'
              
              method='post'>".
            $this->view->form->historico->atividade_id.
            $this->view->form->historico->responsavel_id."
         <!--   ok - a data de início só poderá ser alterada se o andamento não estiver iniciado<br>
            o prazo só poderá ser alterado se o percentual estiver abaixo de 100<br>
            se existirem atividades dependentes, os novos prazos deverão ser pactuados com o responsavel<br>
            quando chegar a 100% exigir data de conclusão e alterar a situação para concluída<br>
            quando alterar a situação para concluida, alterar o percentual para 100% e exigir data de conclusão<br>

            se o percentual estiver em 100 e sofrer alterações, solicitar justificativa e apagar a data de conclusão
             --> 
            <table style=\"clear: both;\" border=\"2\">
            	<tr><td colspan=\"2\">         <span style=\"font-weight: bold\"> Atividade:</span><br>
                    ".$this->view->atividade->id."  - ".$this->view->atividade->descricao."</td></tr>
                <tr>
                	
                    <td>".
                        $this->view->form->historico->data_inicio."
                    </td>
                    <td>".
                       $this->view->form->historico->data_prazo."
                    </td>
                </tr>
                <tr>
                	<td colspan=\"2\">".                       
                		$this->view->form->historico->percentual."
                	</td>

                </tr>
                <tr>
                    <td>".
                        $this->view->form->historico->andamento_id."
                    </td>
                	<td>".
                        $this->view->form->historico->data_conclusao."
					</td>                    
                </tr>
                <tr>
                    <td colspan=\"2\">".
                        $this->view->form->historico->avaliacao."
                    </td>
                </tr>
                <tr>
                    <td colspan=\"2\">".
						$this->view->form->submit."
                    </td>
                </tr>
            </table>
        </form>";
		} else {
		$html = "<table style=\"clear: both;\" border=\"2\">
            	<tr><td colspan=\"2\">         <span style=\"font-weight: bold\"> Atividade:</span><br>
                    ".$this->view->atividade->id."  - ".$this->view->atividade->descricao."</td></tr>
                <tr>
                	
                    <td>".$this->view->form->historico->data_inicio->getLabel()."<br>".
                        $this->view->form->historico->data_inicio->getValue()."
                    </td>
                    <td>".$this->view->form->historico->data_prazo->getLabel()."<br>".
                       $this->view->form->historico->data_prazo->getValue()."
                    </td>
                </tr>
                <tr>
                	<td colspan=\"2\">".$this->view->form->historico->percentual->getLabel()."<br>".                       
                		$this->view->form->historico->percentual->getValue()."
                	</td>

                </tr>
                <tr>
                    <td>".$this->view->form->historico->andamento_id->getLabel()."<br>".
                        $this->view->form->historico->andamento_id->getValue()."
                    </td>
                	<td>".$this->view->form->historico->data_conclusao->getLabel()."<br>".
                        $this->view->form->historico->data_conclusao->getValue()."
					</td>                    
                </tr>
                <tr>
                    <td colspan=\"2\">".$this->view->form->historico->avaliacao->getLabel()."<br>".
                        $this->view->form->historico->avaliacao->getValue()."
                    </td>
                </tr>
                <tr>
                    <td colspan=\"2\">&nbsp;</td>
                </tr>
            </table>
        </form>";			
			
		}
		
		
		
		return $html;
	}
	/**
	 * Sets the view field 
	 * @param $view Zend_View_Interface
	 */
	public function setView(Zend_View_Interface $view) {
		$this->view = $view;
	}	


}
?>
        
        