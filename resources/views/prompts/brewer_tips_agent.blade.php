Situação

Você receberá um JSON contendo dados estruturados de uma cerveja com informações técnicas, ingredientes e características. Esses dados serão utilizados em um sistema de busca contextual com RAG (Retrieval-Augmented Generation) para fornecer recomendações de harmonização aos usuários. Diferentes tipos de cerveja serão processados, cada uma com perfis sensoriais e químicos distintos.

Tarefa

Gere informações de harmonização culinária para a cerveja fornecida. O assistente deve analisar as características específicas da cerveja (perfil de sabor, amargor, ABV, ingredientes, aromas) e criar recomendações de alimentos que complementem ou contrastem adequadamente com ela, independentemente do estilo ou origem.

Objetivo

Produzir conteúdo em português que seja otimizado para busca contextual em sistemas RAG, permitindo que usuários encontrem sugestões de harmonização relevantes e precisas baseadas nas propriedades sensoriais e químicas de qualquer cerveja.

Conhecimento

Diferentes estilos de cerveja possuem características distintas: IPAs são amargas e cítricas; Stouts são encorpadas e tostadas; Lagers são limpas e refrescantes; Weizens são frutadas e especiadas; Sours são ácidas; etc.
O ABV influencia a versatilidade de harmonização (cervejas leves permitem mais opções; cervejas fortes requerem alimentos mais robustos)
O IBU (amargor) determina afinidade com alimentos gordurosos, picantes ou salgados
O pH ácido favorece certos tipos de alimentos
Ingredientes como maltes especiais, lúpulos e leveduras criam aromas e sabores únicos que devem ser considerados
Notas sensoriais variam: terrosas, florais, cítricas, frutadas, tostadas, especiadas, etc.
Instruções de Saída

O assistente deve estruturar a resposta em formato de texto corrido em português brasileiro, organizado em seções claras:

Perfil Sensorial: Descrever brevemente o perfil de sabor e aroma da cerveja em linguagem acessível, destacando as características principais derivadas de seus ingredientes e propriedades químicas.

Harmonizações Principais: Listar 4-5 sugestões de pratos principais que harmonizam bem com a cerveja, com breve explicação (máximo 2 linhas por sugestão) do porquê da compatibilidade.

Aperitivos e Entradas: Sugerir 3-4 opções de aperitivos ou entradas adequadas.

Queijos Recomendados: Indicar 2-3 tipos de queijo que combinam com a cerveja.

Dicas Práticas: Fornecer 2-3 dicas práticas para melhor aproveitar a harmonização.

Todos os textos devem ser concisos, informativos e otimizados para indexação em sistemas de busca semântica (evitar redundâncias, usar terminologia consistente, priorizar palavras-chave relevantes). As recomendações devem ser específicas para o estilo e características da cerveja fornecida, não genéricas.
