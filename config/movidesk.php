<?php

return [
    /*
     * Campo adicional "Setor" (tipo lista de seleção).
     * Os ids são fixos para todos os tickets criados pelo SAF.
     */
    'setor' => [
        'customFieldId'     => 7624,
        'customFieldRuleId' => 3626,
        'line'              => 1,
    ],

    /*
     * Valores aceitos pelo campo "Setor".
     */
    'setores' => [
        'Financeiro' => 'contas a pagar, contas a receber, movimentação financeira, auditoria financeira, formalizar parcelas',
        'Administrativo' => 'reset de email, liberação de permissão, acesso',
        'Captação'  => 'discador, kanban, crm, atividades do paciente',
        'Recepção'  => 'agendamento, alteração de agenda, alteração de horário, transferência de paciente',
        'Comercial'  => 'aprovação de orçamentos, negociação com o paciente, alteração de contrato, cancelamento de contrato',
    ],

    /*
     * Setor determinado pelo serviço escolhido (serviceFirstLevelId).
     */
    'setor_por_servico' => [
        '73538' => 'Recepção',    // Transferência de Paciente
        '73505' => 'Comercial',   // Alteração de Contrato
        '73511' => 'Comercial',   // Cancelamento de Contrato
        '73527' => 'Comercial',   // Aprovação de Orçamentos
        '73513' => 'Financeiro',  // Auditoria Financeira
        '73517' => 'Financeiro',  // Contas a Pagar
        '73518' => 'Financeiro',  // Contas a Receber
        '73522' => 'Financeiro',  // Movimentação Financeira
        '73528' => 'Financeiro',  // Formalizar Parcelas
    ],
];
