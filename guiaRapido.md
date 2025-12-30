# Roteiro: Como usar o script PHP de servidor embutido em segundo plano

Este roteiro supõe que você já tem PHP instalado e disponível no PATH como `php`, conforme o comentário no script.

## 1) Requisitos previos

- Roda apenas uma versão do servidor por vez.
- PHP 8.4 ou superior (conforme comentário do script).
- Composer instalado (porque o script faz uso de `vendor/autoload.php`).
- Dependências instaladas: rode no diretório do script:
  - `composer install`
  - `composer dump-autoload` (opcional, para regenerar autoloads)

## 2) Entendendo o funcionamento do script

- O script executa o servidor embutido do PHP (`PHP -S`) em segundo plano.
- Observação importante: o servidor embutido é adequado apenas para desenvolvimento, não é recomendado para produção.
- O script espera estar no diretório onde exista um `config.json` (constante `CONFIG_FILE` aponta para ele).
- O fluxo principal é baseado no argumento `$argv`:
  - `php servidor.php on` — inicia o servidor
  - `php servidor.php off` — para o servidor
  - `php servidor.php status` — verifica se está rodando
  - `php servidor.php set <atributo> <valor>` — altera configuração no objeto `$serve`
  - `php servidor.php restart` — reinicia o servidor
  - `php servidor.php config` — exibe a configuração atual
  - `php servidor.php test` — (comentações dentro estão presentes; não atua por padrão)
  - qualquer outra chamada mostra o resumo de uso (constante `ABOUT`)

## 3) Comandos básicos

- Iniciar o servidor
  - `php servidor.php on`
  - Saída esperada: “Servidor está rodando!” (ou mensagem de OK)
- Parar o servidor
  - `php servidor.php off`
  - Saída esperada: “Servidor foi finalizado!”
- Ver o status
  - `php servidor.php status`
  - Saída esperada: “ON” ou “OFF” via mensagens definidas
- Ver configuração
  - `php servidor.php config`
  - Saída: lista de atributos/valores e a mensagem de ABOUT
- Ajustar atributo/valor
  - `php servidor.php set <atributo> <novo valor>`
  - Exemplo: `php servidor.php set DOCROOT /var/www/meu_site`
  - Saída: “Alteração feito com sucesso” ou mensagem de erro de sintaxe de entrada
- Reiniciar servidor
  - `php servidor.php restart`
  - Processo: para o servidor, espera, inicia novamente, mostra mensagens de status
- Mostrar configuração completa
  - `php servidor.php config`

## 4) Observações de uso

- O script usa o autoloader do Composer: `require 'vendor/autoload.php';`
- O servidor é apenas para desenvolvimento. Para produção, use servidores adequados (Apache/Nginx com PHP-FPM, etc.).
- O código usa uma classe `Serve` (não fornecida no trecho). Certifique-se de que:
  - A classe `Serve` está disponível via autoload.
  - Existem métodos: `on()`, `off()`, `status()`, `set($attr, $value)`, `set_config()`, `save_config()`, e a propriedade `cfg`.
- A mensagem de ABOUT sugere o uso correto: `php servidor.php [on|off|status|set|restart|config]`.

## 5) Boas práticas ao usar em desenvolvimento

- Sempre verifique logs ao usar `off` ou `restart` para entender falhas.
- Mantenha o `config.json` sob controle de versão apenas se contiver informações não sensíveis.
- Evite expor o servidor embutido a redes externas.

## 6) Estrutura de saída esperada (geral)

- Mensagens definidas no array `MESSAGENS`:
  - OK: "Funcionando!"
  - nOK: "Estamos com problemas! Veja logs."
  - ON: "Servidor está rodando!"
  - OFF: "Servidor não está rodando!"
  - SET: "Alteraçãoo feito com sucesso"
  - nSET: "Sintaxe correta:  php servidor.php set [atributo] [novo valor]" 
  - file_not_exists: "Arquivo não existe!"
  - restart: "Servidor reniciado!"
  - stop: "Servidor foi finalizado!"
  - PAUSA: "Por favor aguarde!"
  - ABOUT: "Uso: php servidor.php [on|off|status|set|restart|config]"
