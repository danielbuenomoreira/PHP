// Pega o formulário e o campo de input
        const form = document.getElementById('divisao');
        const divisorInput = document.getElementById('d2');
        const erroSpan = document.getElementById('divisor-erro');

        // Adiciona um "escutador" para o evento de envio do formulário
        form.addEventListener('submit', function(event) {
            
            // Limpa mensagens de erro antigas
            erroSpan.textContent = ''; 

            // Pega o valor do input e converte para número
            const divisorValue = parseFloat(divisorInput.value) || 0 ;

            // Verifica se o valor é exatamente 0
            if (divisorValue === 0) {
                // Mostra a mensagem de erro
                erroSpan.textContent = 'O divisor não pode ser zero.';
                
                // Impede o envio do formulário
                event.preventDefault(); 
            }
        });