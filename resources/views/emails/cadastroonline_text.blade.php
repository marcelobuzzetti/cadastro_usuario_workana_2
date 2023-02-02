Você se cadastrou na Radar Zenite -
Dados Cadastrados: -
Nome Completo: {{ $cadastro->nome_completo }} -
Email: {{ $cadastro->email }}  -
Telefone: {{ $cadastro->telefone }}  -
Tem Corretora? {{ $cadastro->has_corretora  ? "Sim" : "Não" }} -
Nome da Corretora: {{ $cadastro->nome_corretora }} -
Nr da Corretora: {{ $cadastro->nr_conta_corretora }} -
Usa o Metatrader 5? {{ $cadastro->use_metatrader ? "Sim" : "Não" }} -
Está com autorização da corretora para rotear pelo METATRADER 5? {{ $cadastro->has_auth_use_metatrader ? "Sim" : "Não" }} -
Tem interesse em qual mercado para o RADAR? {{ $cadastro->mercado }}
