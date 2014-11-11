<?php

Yii::import('application.models._base.BaseHistorico');

class Historico extends BaseHistorico {

    public $totalReservados;
    public $totalEmContratacao;
    public $totalPermutados;
    public $totalVendidos;
    public $totalFinanciamentoAprovado;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function formatDate($data) {
        $datetime = new DateTime($data, new DateTimeZone('Brazil/East'));
        return $datetime->format('d\/m\/Y\ H:i:s');
    }

    public function formatDateWithoutTime($data) {
        $datetime = new DateTime($data, new DateTimeZone('Brazil/East'));
        return $datetime->format('d\/m\/Y');
    }

    public function getTotalReservados() {
        return $this->totalReservados;
    }

    public function getTotalEmContratacao() {
        return $this->totalEmContratacao;
    }

    public function getTotalPermutados() {
        return $this->totalPermutados;
    }

    public function getTotalVendidos() {
        return $this->totalVendidos;
    }

    public function getTotalFinanciamentoAprovado() {
        return $this->totalFinanciamentoAprovado;
    }

    public function statusCorretor() {
        if ($this->vendido == 0)
            return '-';

        if ($this->corretor_pago == 1)
            return 'R$' . number_format($this->valor_comissao_corretor, 2, ',', '.');
        else if ($this->corretor_pago_meia == 1)
            return 'R$' . number_format(($this->valor_comissao_corretor * 0.5), 2, ',', '.');
        else if($this->valor_pago_corretor != null)
            return 'R$' . number_format($this->valor_pago_corretor, 2, ',', '.');
        else
            return 'R$0,00';
    }

    public function dataPagamentoCorretor() {
        if ($this->vendido == 0)
            return '-';

        if ($this->corretor_pago == 1)
            return $this->formatDate($this->data_pagamento_corretor);
        else
            return '-';
    }

    public function dataPagamentoCorretorMeia() {
        if ($this->vendido == 0)
            return '-';

        if ($this->corretor_pago_meia == 1)
            return $this->formatDate($this->data_pagamento_corretor_meia);
        else
            return '-';
    }

    public function statusAdmVendas() {
        if ($this->vendido == 0)
            return '-';

        if ($this->adm_vendas_pago == 1)
            return 'R$' . number_format($this->valor_pagamento_adm_vendas, 2, ',', '.');
        else
            return 'R$0,00';
    }

    public function dataPagamentoAdm() {
        if ($this->vendido == 0)
            return '-';

        if ($this->adm_vendas_pago == 1)
            return $this->formatDate($this->data_pagamento_adm_vendas);
        else
            return '-';
    }

    public function valorVenda() {
        if ($this->vendido == 0)
            return '-';
        return 'R$' . number_format($this->valor_venda, 2, ',', '.');
    }

    public function valorVendaTotal() {
        return 'R$' . number_format($this->valor_venda, 2, ',', '.');
    }

    public function valorEntrada() {
        if ($this->vendido == 0)
            return '-';
        return 'R$' . number_format($this->valor_entrada, 2, ',', '.');
    }

    public function valorEntradaTotal() {
        return 'R$' . number_format($this->valor_entrada, 2, ',', '.');
    }

    public function financiadoConstrutora() {
        if ($this->vendido == 0)
            return '-';
        return 'R$' . number_format($this->valor_financiado_construtora, 2, ',', '.');
    }

    public function financiadoConstrutoraTotal() {
        return 'R$' . number_format($this->valor_financiado_construtora, 2, ',', '.');
    }

    public function financiadoCaixa() {
        if ($this->vendido == 0)
            return '-';
        return 'R$' . number_format($this->valor_financiado_caixa, 2, ',', '.');
    }

    public function financiadoCaixaTotal() {
        return 'R$' . number_format($this->valor_financiado_caixa, 2, ',', '.');
    }

    public function valorComissaoCorretor() {
        if ($this->vendido == 0)
            return '-';
        return 'R$' . number_format($this->valor_comissao_corretor, 2, ',', '.');
    }

    public function valorPagoCorretor() {
        if ($this->vendido == 0)
            return '-';
        return 'R$' . number_format($this->valor_pago_corretor, 2, ',', '.');
    }

    public function valorAPagarCorretor() {
        if ($this->vendido == 0)
            return '-';
        return 'R$' . number_format( ($this->valor_comissao_corretor - $this->valor_pago_corretor), 2, ',', '.');
    }

    public function valorComissaoCorretorTotal() {
        return 'R$' . number_format($this->valor_comissao_corretor, 2, ',', '.');
    }

    public function valorComissaoAdmVendas() {
        if ($this->vendido == 0)
            return '-';
        return 'R$' . number_format($this->valor_pagamento_adm_vendas, 2, ',', '.');
    }

    public function valorComissaoAdmVendasTotal() {
        return 'R$' . number_format($this->valor_pagamento_adm_vendas, 2, ',', '.');
    }

    public function getBloco() {
        return str_replace("Bloco ", "", $this->apartamento0->bloco0->descricao);
    }
    
    public function getModulo() {
        return str_replace("Modulo ", "", $this->apartamento0->bloco0->modulo0);
    }

    public function getApartamento() {
        return $this->apartamento0->numero;
    }

    public function getCorretor() {
        return $this->usuario0->nome;
    }

    public function getImobiliaria() {
        return $this->usuario0->imobiliaria0->nome;
    }

    public function getDataEfetivaSemHoras() {
        return $this->formatDateWithoutTime($this->data);
    }
    
}
