// PASSO 1: Selecionar os elementos do HTML que vamos usar
// Usamos 'const' porque estas variáveis não vão mudar.
const input = document.getElementById("EntradaTarefas");
const list = document.getElementById("ListaTarefas");

// PASSO 2: Definir a função para adicionar uma nova tarefa
function adicionarTarefa() {
    
    // Pega o texto do <input> e usa .trim() para remover espaços em branco
    // (assim, o utilizador não pode adicionar uma tarefa só com espaços)
    const taskText = input.value.trim();

    // Se o texto (após o .trim()) estiver vazio, a função para aqui.
    if (taskText === "") return;

    // Cria um novo elemento <li> (item de lista) na memória
    const li = document.createElement("li");

    // Define o HTML interno do <li>.
    li.innerHTML = `${taskText}<span onclick="removerTarefa(this)">&#x2716;</span>`;

    // Adiciona um "escutador" de evento de clique ao <li> (ao item todo)
    li.addEventListener("click", function (e) {
        
        // Esta condição (e.target.tagName !== "SPAN") é importante!
        // Ela verifica se o clique NÃO foi no <span> ('X').
        // Se não foi no 'X', então podemos marcar/desmarcar a tarefa.
        if (e.target.tagName !== "SPAN") {
            // toggle() é como um interruptor: se a classe 'done' existe, remove. Se não existe, adiciona.
            this.classList.toggle("done");
        }
    });

    // Adiciona o <li> (novo item) como "filho" da <ul> (a lista)
    list.appendChild(li);

    // Limpa o campo de <input> para o utilizador poder digitar outra tarefa
    input.value = "";
}

// PASSO 3: Definir a função para remover a tarefa
function removerTarefa(span) {
    // 'span' é o elemento <span> que foi clicado.
    // 'span.parentElement' é o "pai" dele, ou seja, o <li> que queremos apagar.
    // .remove() apaga o elemento <li> do HTML.
    span.parentElement.remove();
}

// PASSO 4: Adicionar um "escutador" de evento ao <input> para a tecla 'Enter'
input.addEventListener("keypress", function (e) {
    
    // Verifica se a tecla que foi pressionada é a 'Enter'
    if (e.key === "Enter") {
        
        // Se for 'Enter', chama a função 'adicionarTarefa()',
        adicionarTarefa();
    }
});