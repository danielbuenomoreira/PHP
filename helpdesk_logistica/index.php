<?php
session_start();
require 'conexao.php';

$senha_admin_sistema = 'd92791215';

$diretorio_uploads = 'uploads/';
if (!is_dir($diretorio_uploads)) {
    mkdir($diretorio_uploads, 0777, true);
}

function exibirTextoFormatado($texto)
{
    $texto_seguro = htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
    $padrao_http = '/(https?:\/\/[a-zA-Z0-9\-\.\/\?\&\=\+\~\_\%\#]+)/';
    $texto_linkado = preg_replace($padrao_http, '<a href="$1" target="_blank" rel="noopener noreferrer" style="color: #0056b3; text-decoration: underline;">$1</a>', $texto_seguro);
    $padrao_www = '/(?<!\/\/)(www\.[a-zA-Z0-9\-\.\/\?\&\=\+\~\_\%\#]+)/';
    $texto_linkado = preg_replace($padrao_www, '<a href="http://$1" target="_blank" rel="noopener noreferrer" style="color: #0056b3; text-decoration: underline;">$1</a>', $texto_linkado);
    return nl2br($texto_linkado);
}

function processarAnexos($pdo, $chamado_id, $comentario_id, $arquivos)
{
    global $diretorio_uploads;
    $limite_tamanho = 50 * 1024 * 1024;

    if (isset($arquivos['name'][0]) && $arquivos['name'][0] !== '') {
        $total_arquivos = count($arquivos['name']);
        for ($i = 0; $i < $total_arquivos; $i++) {
            if ($arquivos['error'][$i] === UPLOAD_ERR_OK && $arquivos['size'][$i] <= $limite_tamanho) {
                $nome_original = $arquivos['name'][$i];
                $tipo_mime = $arquivos['type'][$i];
                $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
                $nome_salvo = uniqid('anexo_') . '.' . $extensao;
                $caminho_completo = $diretorio_uploads . $nome_salvo;

                if (move_uploaded_file($arquivos['tmp_name'][$i], $caminho_completo)) {
                    $stmt = $pdo->prepare("INSERT INTO anexos (chamado_id, comentario_id, nome_original, caminho_arquivo, tipo_mime) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$chamado_id, $comentario_id, $nome_original, $caminho_completo, $tipo_mime]);
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $operador = $_POST['operador_atual'] ?? '';

    if ($acao === 'login_admin') {
        $senha = $_POST['senha'] ?? '';
        if ($senha === $senha_admin_sistema) {
            $_SESSION['is_admin'] = true;
            $_SESSION['operador_sessao'] = 'Daniel Moreira';
        } else {
            $_SESSION['is_admin'] = false;
            $_SESSION['operador_sessao'] = 'Daniel Moreira';
        }
        header("Location: index.php");
        exit;
    }

    if ($acao === 'logout_admin') {
        session_destroy();
        header("Location: index.php");
        exit;
    }

    if ($acao === 'novo_chamado') {
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $stmt = $pdo->prepare("INSERT INTO chamados (titulo, descricao, autor) VALUES (?, ?, ?)");
        $stmt->execute([$titulo, $descricao, $operador]);
        $chamado_id = $pdo->lastInsertId();
        processarAnexos($pdo, $chamado_id, null, $_FILES['anexos']);
        header("Location: index.php");
        exit;
    }

    if ($acao === 'novo_comentario') {
        $chamado_id = $_POST['chamado_id'];
        $texto = $_POST['texto'];
        $is_solucao = isset($_POST['is_solucao']) ? 1 : 0;
        $novo_status = $_POST['novo_status'] ?? null;

        $stmt = $pdo->prepare("INSERT INTO comentarios (chamado_id, autor, texto, is_solucao) VALUES (?, ?, ?, ?)");
        $stmt->execute([$chamado_id, $operador, $texto, $is_solucao]);
        $comentario_id = $pdo->lastInsertId();
        processarAnexos($pdo, $chamado_id, $comentario_id, $_FILES['anexos']);

        if ($novo_status) {
            $stmt = $pdo->prepare("UPDATE chamados SET status = ? WHERE id = ?");
            $stmt->execute([$novo_status, $chamado_id]);
        }
        header("Location: index.php");
        exit;
    }

    $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

    if ($acao === 'editar_comentario') {
        $comentario_id = $_POST['comentario_id'];
        $novo_texto = $_POST['novo_texto'];

        $stmt = $pdo->prepare("SELECT autor FROM comentarios WHERE id = ?");
        $stmt->execute([$comentario_id]);
        $comentario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($comentario && ($is_admin || $comentario['autor'] === $operador)) {
            $stmt = $pdo->prepare("UPDATE comentarios SET texto = ?, data_modificacao = CURRENT_TIMESTAMP WHERE id = ?");
            $stmt->execute([$novo_texto, $comentario_id]);
        }
        header("Location: index.php");
        exit;
    }

    if ($acao === 'deletar_chamado') {
        $chamado_id = $_POST['chamado_id'];
        $stmt = $pdo->prepare("SELECT autor FROM chamados WHERE id = ?");
        $stmt->execute([$chamado_id]);
        $chamado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($chamado && ($is_admin || $chamado['autor'] === $operador)) {
            $stmt = $pdo->prepare("SELECT caminho_arquivo FROM anexos WHERE chamado_id = ?");
            $stmt->execute([$chamado_id]);
            $arquivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($arquivos as $arq) {
                if (file_exists($arq['caminho_arquivo'])) unlink($arq['caminho_arquivo']);
            }
            $stmt = $pdo->prepare("DELETE FROM chamados WHERE id = ?");
            $stmt->execute([$chamado_id]);
        }
        header("Location: index.php");
        exit;
    }

    if ($acao === 'deletar_anexo') {
        $anexo_id = $_POST['anexo_id'];
        $stmt = $pdo->prepare("
            SELECT a.caminho_arquivo, COALESCE(c.autor, ch.autor) as autor
            FROM anexos a
            LEFT JOIN comentarios c ON a.comentario_id = c.id
            LEFT JOIN chamados ch ON a.chamado_id = ch.id
            WHERE a.id = ?
        ");
        $stmt->execute([$anexo_id]);
        $arquivo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($arquivo && ($is_admin || $arquivo['autor'] === $operador)) {
            if (file_exists($arquivo['caminho_arquivo'])) unlink($arquivo['caminho_arquivo']);
            $stmt = $pdo->prepare("DELETE FROM anexos WHERE id = ?");
            $stmt->execute([$anexo_id]);
        }
        header("Location: index.php");
        exit;
    }
}

$busca = $_GET['busca'] ?? '';
if ($busca !== '') {
    $stmt = $pdo->prepare("SELECT * FROM chamados WHERE id = ? OR titulo LIKE ? OR autor LIKE ? ORDER BY data_criacao DESC");
    $termo_busca = '%' . $busca . '%';
    $stmt->execute([$busca, $termo_busca, $termo_busca]);
    $chamados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $chamados = $pdo->query("SELECT * FROM chamados ORDER BY data_criacao DESC")->fetchAll(PDO::FETCH_ASSOC);
}

$comentarios_raw = $pdo->query("SELECT * FROM comentarios ORDER BY data_criacao ASC")->fetchAll(PDO::FETCH_ASSOC);
$anexos_raw = $pdo->query("SELECT * FROM anexos")->fetchAll(PDO::FETCH_ASSOC);

$comentarios = [];
foreach ($comentarios_raw as $c) {
    $comentarios[$c['chamado_id']][] = $c;
}

$anexos = [];
foreach ($anexos_raw as $a) {
    if ($a['comentario_id']) {
        $anexos['comentario'][$a['comentario_id']][] = $a;
    } else {
        $anexos['chamado'][$a['chamado_id']][] = $a;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Help Desk - Logística e Transportes</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function validarTamanhoArquivos(input) {
            const limite = 50 * 1024 * 1024;
            for (let i = 0; i < input.files.length; i++) {
                if (input.files[i].size > limite) {
                    alert('ERRO: O arquivo "' + input.files[i].name + '" excede o limite estrito de 50MB. A seleção de arquivos foi cancelada.');
                    input.value = '';
                    break;
                }
            }
        }
    </script>
</head>

<body data-is-admin="<?= isset($_SESSION['is_admin']) && $_SESSION['is_admin'] ? 'true' : 'false' ?>"
    data-operador-sessao="<?= htmlspecialchars($_SESSION['operador_sessao'] ?? '') ?>">

    <form id="form_login" method="POST" style="display:none;">
        <input type="hidden" name="acao" value="login_admin">
        <input type="hidden" name="senha" id="input_senha">
        <input type="hidden" name="operador_atual" id="login_operador">
    </form>

    <div id="modal_senha" class="modal-overlay">
        <div class="modal-box">
            <h3>Autenticação de Admin</h3>
            <p>Digite a senha para habilitar privilégios globais ou cancele para acesso padrão.</p>
            <input type="password" id="senha_modal_input" placeholder="Sua senha secreta..." style="margin-bottom: 15px; text-align: center;">
            <div style="display: flex; gap: 10px;">
                <button onclick="confirmarSenha()" style="flex: 1;">Acessar</button>
                <button onclick="cancelarSenha()" class="btn-cancel" style="flex: 1;">Cancelar</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="header-bar">
            <h2>
                Help Desk - Logística
                <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                    <span style="color:green; font-size:0.5em; vertical-align: middle; margin-left: 10px;">(Admin Logado)</span>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="acao" value="logout_admin">
                        <button type="submit" class="btn-logout">Sair do Admin</button>
                    </form>
                <?php endif; ?>
            </h2>
            <div>
                <label for="operador"><strong>Operador atual:</strong></label>
                <select id="operador" onchange="atualizarOperador()">
                    <option value="">Selecione...</option>
                    <option value="Charles Alexandre">Charles Alexandre</option>
                    <option value="Daniel Moreira">Daniel Moreira</option>
                    <option value="Edgar Abitante">Edgar Abitante</option>
                    <option value="Nathan Toledo">Nathan Toledo</option>
                    <option value="Rosberguer Camargo">Rosberguer Camargo</option>
                    <option value="Valesca Reichelt">Valesca Reichelt</option>
                    <option value="William Albeche">William Albeche</option>
                </select>
            </div>
        </div>

        <div style="margin-bottom: 20px; background: #f1f1f1; padding: 15px; border-radius: 4px;">
            <form method="GET" action="index.php" style="display: flex; gap: 10px;">
                <input type="text" name="busca" placeholder="Pesquisar por número, título ou autor..." value="<?= htmlspecialchars($busca) ?>" style="margin-top: 0; flex: 1;">
                <button type="submit" style="margin-top: 0; width: auto; padding: 8px 20px;">Pesquisar</button>
                <?php if ($busca !== ''): ?>
                    <a href="index.php" style="padding: 10px; text-decoration: none; color: #dc3545; font-weight: bold;">Limpar</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="form-section" id="box-novo-chamado" style="display: none;">
            <h3>Abrir Novo Chamado</h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="acao" value="novo_chamado">
                <input type="hidden" name="operador_atual" class="input-operador">
                <label>Título:</label>
                <input type="text" name="titulo" required>
                <label>Descrição:</label>
                <textarea name="descricao" rows="3" required></textarea>

                <label>Anexos (Máx 50MB por arquivo):</label>
                <input type="file" name="anexos[]" multiple onchange="validarTamanhoArquivos(this)">

                <button type="submit">Cadastrar Tarefa</button>
            </form>
        </div>

        <div class="tabs">
            <div class="tab-btn active" onclick="abrirAba('Novo')">Novos</div>
            <div class="tab-btn" onclick="abrirAba('Em andamento')">Em andamento</div>
            <div class="tab-btn" onclick="abrirAba('Concluído')">Concluídos</div>
        </div>

        <?php
        $abas = ['Novo', 'Em andamento', 'Concluído'];
        foreach ($abas as $aba):
        ?>
            <div id="aba-<?= str_replace(' ', '-', $aba) ?>" class="tab-content <?= $aba === 'Novo' ? 'active' : '' ?>">
                <?php
                $chamados_aba = array_filter($chamados, fn($c) => $c['status'] === $aba);
                if (empty($chamados_aba)) {
                    echo "<p>Nenhum chamado encontrado nesta categoria.</p>";
                }

                foreach ($chamados_aba as $c):
                ?>
                    <div class="card">
                        <h3>
                            #<?= $c['id'] ?> - <?= htmlspecialchars($c['titulo']) ?>
                            <form method="POST" class="form-excluir-chamado" data-autor="<?= htmlspecialchars($c['autor']) ?>" style="display:none;" onsubmit="return confirm('Tem certeza que deseja excluir completamente este chamado e todos os seus arquivos?');">
                                <input type="hidden" name="acao" value="deletar_chamado">
                                <input type="hidden" name="chamado_id" value="<?= $c['id'] ?>">
                                <input type="hidden" name="operador_atual" class="input-operador"> <button type="submit" class="btn-danger">Excluir Chamado</button>
                            </form>
                        </h3>
                        <div class="meta">Aberto por: <?= htmlspecialchars($c['autor']) ?> em <?= date('d/m/Y H:i', strtotime($c['data_criacao'])) ?></div>

                        <p><?= exibirTextoFormatado($c['descricao']) ?></p>

                        <?php if (isset($anexos['chamado'][$c['id']])): ?>
                            <div class="anexos-list">
                                <strong>Anexos originais:</strong><br>
                                <?php foreach ($anexos['chamado'][$c['id']] as $anexo): ?>
                                    <div class="anexo-item">
                                        📄 <?= htmlspecialchars($anexo['nome_original']) ?><br>
                                        <a href="<?= htmlspecialchars($anexo['caminho_arquivo']) ?>" target="_blank">👁 Visualizar</a>
                                        <a href="<?= htmlspecialchars($anexo['caminho_arquivo']) ?>" download="<?= htmlspecialchars($anexo['nome_original']) ?>">⬇ Baixar</a>

                                        <form method="POST" class="form-excluir-anexo" data-autor="<?= htmlspecialchars($c['autor']) ?>" style="display:none;" onsubmit="return confirm('Excluir permanentemente este arquivo?');">
                                            <input type="hidden" name="acao" value="deletar_anexo">
                                            <input type="hidden" name="anexo_id" value="<?= $anexo['id'] ?>">
                                            <input type="hidden" name="operador_atual" class="input-operador"> <button type="submit" class="btn-link-danger">❌</button>
                                        </form>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="comentarios">
                            <?php if (isset($comentarios[$c['id']])): ?>
                                <?php foreach ($comentarios[$c['id']] as $com): ?>
                                    <div class="comentario <?= $com['is_solucao'] ? 'solucao' : '' ?>">
                                        <div class="meta">
                                            <strong><?= htmlspecialchars($com['autor']) ?></strong>
                                            <?= date('d/m/Y H:i', strtotime($com['data_criacao'])) ?>

                                            <?php if (!empty($com['data_modificacao'])): ?>
                                                <span class="editado-badge">(Editado em <?= date('d/m/Y H:i', strtotime($com['data_modificacao'])) ?>)</span>
                                            <?php endif; ?>

                                            <?= $com['is_solucao'] ? '<span class="solucao-badge"> [SOLUÇÃO]</span>' : '' ?>

                                            <button type="button" class="btn-link-edit form-editar-comentario" data-autor="<?= htmlspecialchars($com['autor']) ?>" style="display:none;" onclick="mostrarFormEdicao(<?= $com['id'] ?>)">✏️ Editar</button>
                                        </div>

                                        <div id="texto-comentario-<?= $com['id'] ?>">
                                            <?= exibirTextoFormatado($com['texto']) ?>
                                        </div>

                                        <form method="POST" id="form-edicao-<?= $com['id'] ?>" style="display:none; margin-top: 10px;">
                                            <input type="hidden" name="acao" value="editar_comentario">
                                            <input type="hidden" name="comentario_id" value="<?= $com['id'] ?>">
                                            <input type="hidden" name="operador_atual" class="input-operador">
                                            <textarea name="novo_texto" rows="3" required><?= htmlspecialchars($com['texto']) ?></textarea>
                                            <div style="margin-top: 5px;">
                                                <button type="submit" style="width: auto; padding: 5px 10px;">Guardar Edição</button>
                                                <button type="button" class="btn-cancel" style="width: auto; padding: 5px 10px;" onclick="esconderFormEdicao(<?= $com['id'] ?>)">Cancelar</button>
                                            </div>
                                        </form>

                                        <?php if (isset($anexos['comentario'][$com['id']])): ?>
                                            <div class="anexos-list" style="margin-top: 5px;">
                                                <?php foreach ($anexos['comentario'][$com['id']] as $anexo): ?>
                                                    <div class="anexo-item">
                                                        📄 <?= htmlspecialchars($anexo['nome_original']) ?><br>
                                                        <a href="<?= htmlspecialchars($anexo['caminho_arquivo']) ?>" target="_blank">👁 Visualizar</a>
                                                        <a href="<?= htmlspecialchars($anexo['caminho_arquivo']) ?>" download="<?= htmlspecialchars($anexo['nome_original']) ?>">⬇ Baixar</a>

                                                        <form method="POST" class="form-excluir-anexo" data-autor="<?= htmlspecialchars($com['autor']) ?>" style="display:none;" onsubmit="return confirm('Excluir permanentemente este arquivo?');">
                                                            <input type="hidden" name="acao" value="deletar_anexo">
                                                            <input type="hidden" name="anexo_id" value="<?= $anexo['id'] ?>">
                                                            <input type="hidden" name="operador_atual" class="input-operador"> <button type="submit" class="btn-link-danger">❌</button>
                                                        </form>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <div class="form-section form-interacao" style="display:none;">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="acao" value="novo_comentario">
                                <input type="hidden" name="chamado_id" value="<?= $c['id'] ?>">
                                <input type="hidden" name="operador_atual" class="input-operador">

                                <textarea name="texto" rows="2" placeholder="Digite o seu comentário ou cole um link aqui..." required></textarea>

                                <label style="display:block; margin-top:5px; font-size: 0.9em;">Anexar arquivos (Máx 50MB):</label>
                                <input type="file" name="anexos[]" multiple onchange="validarTamanhoArquivos(this)">

                                <div style="margin-top: 10px; display: flex; align-items: center; gap: 15px;">
                                    <label>
                                        <input type="checkbox" name="is_solucao" value="1" style="width: auto;"> Marcar como Solução
                                    </label>
                                    <select name="novo_status" style="width: auto;">
                                        <option value="">Manter Status (<?= $c['status'] ?>)</option>
                                        <option value="Novo">Mover para Novo</option>
                                        <option value="Em andamento">Mover para Em andamento</option>
                                        <option value="Concluído">Mover para Concluído</option>
                                    </select>
                                    <button type="submit" style="width: auto;">Enviar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="script.js"></script>
</body>

</html>