# ServerPHP

Script php gerenciando servidor embutido php.

# README

## Comandos para executar

- php Servidor.php
- -> Uso: php servidor.php [on|off|status|set|restart|config]

## COMPOSER

- após git clone, execute **composer init**

## GIT

- **git add [file]**, Adiciona arquivo epositório local.

- **git commit -m "mensagem descrevendo"**, Comita, o arquivo pode ir para repositorio remoto.

- **git push origin main**, Envia os commits do seu ramo local main para o ramo main do repositório remoto chamado origin.

## Visão geral

Script PHP version 8.4 simples que executa o servidor embutido (PHP -S) em segundo plano. 
O script recebe comandos via linha de comando: "on" para iniciar o servidor e "off" para parar. 

Ele usa um arquivo de JSON para gerenciar o processo do servidor.

Observações:
- O servidor embutido é adequado para desenvolvimento, não para produção.
- O script assume que o PHP está disponível no PATH como php.
- Substitua localhost e 8090 conforme necessário.
- O script usa PID para permitir start, stop e kill do processo.

Contempla autoload manual em PHP com duas classes: `Base` e `Serve`. O autoload registra uma função anônima para incluir arquivos de classe com base no namespace/class name. O código demonstra a criação de objetos e a leitura de seus atributos.

## Observações técnicas

**Autoload básico**:
 - O autoload utiliza `spl_autoload_register` para incluir arquivos com base no nome da classe.
 - A convenção usada é que o nome da classe corresponde ao nome do arquivo (ex.: `Base` -> `Base.php`).
   
## Estrutura de Arquivos

├── public 

│ └── index.php

├── src

│ ├── Base.php

│ ├── Calculator.php

│ ├── Serve.php

│ └── Showconfig.php

├── LICENSE

├── composer.json

├── index.php

├── php_S_.jpg

├── phpunit.xml

├── readme.md

├── servidor.php

├── server.log


Iniciar o servidor
php servidor.php on
Saída esperada: “Servidor está rodando!” (ou mensagem de OK)

Parar o servidor
php servidor.php off
Saída esperada: “Servidor foi finalizado!”

Ver o status
php servidor.php status
Saída esperada: “ON” ou “OFF” via mensagens definidas

Ver configuração
php servidor.php config
Saída: lista de atributos/valores e a mensagem ABOUT

Ajustar atributo/valor
php servidor.php set <atributo> <novo valor>
Exemplo: php servidor.php set DOCROOT /var/www/meu_site
Saída: “Alteração feito com sucesso” ou mensagem de erro de sintaxe de entrada

Reiniciar servidor
php servidor.php restart
Processo: para o servidor, espera, inicia novamente, mostra mensagens de status

Mostrar configuração completa
php servidor.php config

OBSERVAÇÕES RÁPIDAS

- O script roda somente em Linux, check o php.ini
- O servidor embutido é para desenvolvimento; não use em produção.
- O script depende de Composer e do autoload (vendor/autoload.php).
- Certifique-se de que a classe Serve e seus métodos (on, off, status, set, etc.) estão disponíveis.

