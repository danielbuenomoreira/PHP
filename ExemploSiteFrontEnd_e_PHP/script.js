function ativarEasterEgg() {
    // Primeiro, pegamos o nosso elemento de áudio que está escondido na página
    const player = document.getElementById('easter-egg-player');

    // Mostramos o alerta personalizado
    alert("Botão clicado! Tocando Wake Me Up do Avicii!");

    // Tornamos o player visível, mudando seu estilo de 'none' para 'block'
    player.style.display = 'block';

    // Damos o comando para a música tocar
    player.play();
}