<?php
//Yii::import("application.extensions.yii-mail.YiiMailMessage", true);

class MailHelper {
    const NETO = 'neto@dallconstrucoes.com.br';
    const CONTROLADORIA= 'controladoria@dallconstrucoes.com.br';
    const RH = 'rh@dallconstrucoes.com.br';
    const DEBUG_MAIL = 'marcosrbertuol@gmail.com';
    const DEBUG = false;

    public function sendReserveMail($historico) {
        $message = new YiiMailMessage;
        $message->view = "reserve";
        $params = array('historico' => $historico);
        $message->subject = 'Nova reserva de apartamento para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::CONTROLADORIA);
            $message->addTo(MailHelper::RH);
        }
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }

    public function sendSellMail($historico) {
        $message = new YiiMailMessage;
        $message->view = "sell";
        $params = array('historico' => $historico);
        $message->subject = 'Nova venda de apartamento para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::CONTROLADORIA);
            $message->addTo(MailHelper::RH);
            $message->addTo(MailHelper::NETO);
        }
        
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }

    public function sendEmContratacaoMail($historico) {
        $message = new YiiMailMessage;
        $message->view = "contratacao";
        $params = array('historico' => $historico);
        $message->subject = 'Apartamento do empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome . ' entrou Em Contratação';
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::CONTROLADORIA);
        }
        
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }

    public function sendCancelMail($historico) {
        $message = new YiiMailMessage;
        
        if($historico->status == 'Reserva Cancelada')
        {
            $message->view = "cancelarReserva";
            $message->subject = 'Cancelamento de reserva para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
            
            if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
            } else {
                $message->addTo(MailHelper::CONTROLADORIA);
                $message->addTo(MailHelper::RH);
            }
        }
        else if($historico->status == 'Contratação Cancelada')
        {
            $message->view = "cancelarContratacao";
            $message->subject = 'Cancelamento de Contratação para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
            
            if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
                $message->addTo(MailHelper::DEBUG_MAIL);
            } else {
                $message->addTo(MailHelper::CONTROLADORIA);
                $message->addTo(MailHelper::RH);
            }
        }
        else if($historico->status == 'Permuta Cancelada')
        {
            $message->view = "cancelarPermuta";
            $message->subject = 'Cancelamento de permuta para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
            
            if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
                $message->addTo(MailHelper::DEBUG_MAIL);
            } else {
                $message->addTo(MailHelper::CONTROLADORIA);
                $message->addTo(MailHelper::RH);
                $message->addTo(MailHelper::NETO);
            }
        }
        else
        {
            $message->view = "cancelarVenda";
            $message->subject = 'Cancelamento de venda para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
            
            if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
                $message->addTo(MailHelper::DEBUG_MAIL);
            } else {
                $message->addTo(MailHelper::CONTROLADORIA);
                $message->addTo(MailHelper::RH);
                $message->addTo(MailHelper::NETO);
            }
        }
        
        $params = array('historico' => $historico);
        $message->setBody($params, 'text/html');
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }

    public function sendPermutaMail($historico) {
        $message = new YiiMailMessage;
        $message->view = "permuta";
        $params = array('historico' => $historico);
        $message->subject = 'Nova Permuta de apartamento para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::CONTROLADORIA);
            $message->addTo(MailHelper::RH);
            $message->addTo(MailHelper::NETO);
        }
        
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }
    
    public function sendValorComissaoCorretorMail($historico, $novoValorPago) {
        $message = new YiiMailMessage;
        $message->view = "valorComissaoCorretor";
        $params = array('historico' => $historico, 'novoValor' => $novoValorPago);
        $message->subject = 'Nova comissão de corretor paga para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::NETO);
            $message->addTo(MailHelper::CONTROLADORIA);
            $message->addTo(MailHelper::RH);
        }
        
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }
    
    public function sendComissaoCorretorMail($historico) {
        $message = new YiiMailMessage;
        $message->view = "comissaoCorretor";
        $params = array('historico' => $historico);
        $message->subject = 'Nova comissão de corretor paga para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::CONTROLADORIA);
            $message->addTo(MailHelper::RH);
        }
        
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }
    
    public function sendComissaoAdmMail($historico) {
        $message = new YiiMailMessage;
        $message->view = "comissaoAdm";
        $params = array('historico' => $historico);
        $message->subject = 'Nova comissão de administrador paga para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::CONTROLADORIA);
            $message->addTo(MailHelper::RH);
        }
        
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }
    
    public function sendComissaoCorretorMeiaMail($historico) {
        $message = new YiiMailMessage;
        $message->view = "comissaoCorretorMeia";
        $params = array('historico' => $historico);
        $message->subject = 'Nova meia comissão de corretor paga para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::CONTROLADORIA);
            $message->addTo(MailHelper::RH);
        }
        
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }
    
    public function sendCancelarComissaoCorretorMail($historico) {
        $message = new YiiMailMessage;
        
        $message->view = "cancelarComissaoCorretor";
        
        $params = array('historico' => $historico);
        $message->subject = 'Cancelamento de comissão de corretor para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::NETO);
        }
        
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }
    
    public function sendCancelComissaoCorretorMeiaMail($historico) {
        $message = new YiiMailMessage;
        
        $message->view = "cancelarComissaoCorretorMeia";
        
        $params = array('historico' => $historico);
        $message->subject = 'Cancelamento de meia comissão de corretor para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        $message->addTo(MailHelper::DEBUG_MAIL);

        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::NETO);
        }
        
        Yii::app()->mail->send($message);
    }
    
    public function sendCancelComissaoAdmMail($historico) {
        $message = new YiiMailMessage;
        
        $message->view = "cancelarComissaoAdm";
        
        $params = array('historico' => $historico);
        $message->subject = 'Cancelamento comissão do Adm. de Vendas para o empreendimento ' . $historico->apartamento0->bloco0->empreendimento0->nome;
        $message->setBody($params, 'text/html');
        
        if((bool)MailHelper::DEBUG || $_SERVER['HTTP_HOST'] == 'localhost') {
            $message->addTo(MailHelper::DEBUG_MAIL);
        } else {
            $message->addTo(MailHelper::NETO);
        }
        
        $message->from = 'contato@dallconstrucoes.com.br';
        
        Yii::app()->mail->send($message);
    }
}

?>