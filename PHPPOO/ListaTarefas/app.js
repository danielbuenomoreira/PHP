/*
 * Novo script para interagir com o backend PHP sem recarregar a página.
 */

// Espera o HTML estar completamente carregado
document.addEventListener("DOMContentLoaded", function () {
    
    // Encontra o formulário e a lista
    const formAdicionar = document.getElementById("formAdicionar");
    const inputTarefa = document.getElementById("inputTarefa");
    const listaTarefas = document.getElementById("ListaTarefas");

    // 1. LIDAR COM A ADIÇÃO DE NOVAS TAREFAS
    if (formAdicionar) {
        formAdicionar.addEventListener("submit", function (e) {
            // Impede o envio normal do formulário (que recarrega a página)
            e.preventDefault();

            const textoTarefa = inputTarefa.value.trim();
            if (textoTarefa === "") return;

            // Prepara os dados para enviar via 'fetch'
            const formData = new FormData();
            formData.append('acao', 'adicionar');
            formData.append('descricao_tarefa', textoTarefa);

            fetch('processar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Converte a resposta em JSON
            .then(data => {
                // 'data' é o objeto JSON que o 'processar.php' enviou
                if (data.status === 'sucesso') {
                    // Limpa o input
                    inputTarefa.value = "";
                    // Adiciona a tarefa na lista (usando os dados da resposta)
                    adicionarTarefaNaLista(data.nova_tarefa.id, data.nova_tarefa.descricao);
                } else {
                    // Opcional: mostrar um alerta se der erro
                    console.error(data.mensagem);
                }
            })
            .catch(error => console.error('Erro no fetch:', error));
        });
    }

    // 2. LIDAR COM CLIQUES NA LISTA (REMOVER E CONCLUIR)
    if (listaTarefas) {
        listaTarefas.addEventListener("click", function (e) {
            
            // Verifica se o clique foi no link de REMOVER (o 'X')
            if (e.target.classList.contains('link-remover')) {
                // Impede o link de ser seguido
                e.preventDefault(); 
                
                const link = e.target.href; // Pega o URL (ex: processar.php?acao=remover&id=5)
                const li = e.target.closest('li'); // Pega o item <li> "pai"
                
                // Faz a chamada fetch para remover
                fetch(link)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'sucesso') {
                            // Remove o <li> do HTML
                            li.remove();
                        } else {
                            console.error(data.mensagem);
                        }
                    });
            }

            // Verifica se o clique foi no link de CONCLUIR (o texto)
            if (e.target.classList.contains('link-tarefa')) {
                e.preventDefault();

                const link = e.target.href;
                const li = e.target.closest('li');

                fetch(link)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'sucesso') {
                            // Adiciona ou remove a classe 'done'
                            if (data.novo_estado === 1) {
                                li.classList.add('done');
                            } else {
                                li.classList.remove('done');
                            }
                        } else {
                            console.error(data.mensagem);
                        }
                    });
            }
        });
    }

    /**
     * Função auxiliar para criar e adicionar o HTML da nova tarefa na lista
     */
    function adicionarTarefaNaLista(id, descricao) {
        // Remove a mensagem "Nenhuma tarefa" se ela existir
        const info = listaTarefas.querySelector('.info');
        if (info) info.remove();

        // Cria o novo elemento <li>
        const li = document.createElement('li');
        
        // Define o HTML interno com os links corretos para o processar.php
        li.innerHTML = `
            <a href='processar.php?acao=concluir&id=${id}' class='link-tarefa'>${descricao}</a>
            <a href='processar.php?acao=remover&id=${id}' class='link-remover'>&#x2716;</a>
        `;
        
        // Adiciona o novo <li> no TOPO da lista (melhor que no final)
        listaTarefas.prepend(li);
    }

});